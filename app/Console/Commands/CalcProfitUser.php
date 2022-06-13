<?php

namespace App\Console\Commands;

use App\Http\Services\ModelService;
use App\Mail\LogMail;
use App\Mail\OtpMail;
use App\Models\DailyMissionLogs;
use App\Models\InvestmentBought;
use App\Models\ProfitLogs;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CalcProfitUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calc:profit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Caculator Profit User';

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
        DB::beginTransaction();
        try{
            foreach ($this->getInvestmentBought($user->id) as $invest) {
                if(diffDaysWithNow($invest->created_at) > $invest->days) {
                    continue;
                }
                $invest->daily_today = 0;
                $invest->save();
            }
            DB::commit();
        }catch (Exception $exception) {
            DB::rollBack();
            logger($exception->getMessage());
            $mail = new LogMail($exception->getMessage());
            Mail::to('saoxa37@gmail.com')->queue($mail);
        }
        return 0;
    }

    private function getDailyToDay() {
        $today = Carbon::today()->format('Y-m-d');
        $preday = Carbon::today()->subDay()->format('Y-m-d');
        return DailyMissionLogs::where('created_at', '>=', $preday . ' 07:00:00')
            ->where('created_at', '<', $today . ' 07:00:00')
            ->get();
    }
    private function getInvestmentBought($user_id) {
        return InvestmentBought::whereUserId($user_id)->whereDailyToday(1)->get();
    }
}
