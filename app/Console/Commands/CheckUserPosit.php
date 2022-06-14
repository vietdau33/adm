<?php

namespace App\Console\Commands;

use App\Http\Services\ModelService;
use App\Http\Services\TelegramService;
use App\Models\DepositLogs;
use App\Models\UserUsdt;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CheckUserPosit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posit:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check user posit';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        try{
            foreach (UserUsdt::all() as $usdt) {
                if($usdt->user->role == 'admin') {
                    continue;
                }
                $userMoney = $usdt->user->money;

                try_again:
                $contents = $this->getTransactionHistory($usdt->token);
                if ($contents['status'] == '0') {
                    if($contents['message'] == 'NOTOK' && strpos($contents['result'], 'Max rate limit reached') === 0) {
                        sleep(3);
                        goto try_again;
                    }
                    continue;
                }
                $logs = DepositLogs::whereUserId($usdt->user_id)->get()->pluck('hash')->toArray();
                foreach ($contents['result'] as $result) {
                    if (in_array($result['hash'], $logs)) {
                        continue;
                    }

                    if (!isset($result['value'])) {
                        continue;
                    }

                    if($result['to'] != $usdt->token) {
                        continue;
                    }

                    $amount = (int)substr($result['value'], 0, -14);
                    $amount /= 10000;
                    if($amount < 10) {
                        continue;
                    }
                    $userMoney->wallet += $amount;

                    ModelService::insert(DepositLogs::class, [
                        'user_id' => $usdt->user_id,
                        'hash' => $result['hash'],
                        'block_hash' => $result['blockHash'],
                        'from' => $result['from'],
                        'amount' => $amount,
                        'contents' => json_encode($result)
                    ]);

                    TelegramService::sendMessageDeposit([
                        'username' => $usdt->user->username,
                        'amount' => $amount,
                        'hash' => $result['hash'],
                        'from' => $result['from']
                    ]);
                }
                $userMoney->save();
            }
        }catch (Exception $exception) {
            logger($exception->getMessage());
        }
        return 0;
    }

    public function getTransactionHistory($address)
    {
        $param = [
            'module' => 'account',
            'action' => 'tokentx',
            'address' => $address,
            'apikey' => env('API_KEY_BSC', ''),
            'contractaddress' => '0x55d398326f99059fF775485246999027B3197955',
            'page' => 1,
            'offset' => 20,
            'startblock' => 0,
            'endblock' => 999999999,
            'sort' => 'desc'
        ];
        $response = Http::get('https://api.bscscan.com/api', $param);
        return $response->json();
    }
}
