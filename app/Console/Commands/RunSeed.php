<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RunSeed extends Command
{
    protected $signature = 'run:seed';
    protected $description = 'Run Seed';
    protected array $ignoreSeed = [
        'DatabaseSeeder'
    ];

    public function handle(): void
    {
        $ds = DIRECTORY_SEPARATOR;
        $seedFolder = realpath(public_path('..' . $ds . 'database' . $ds . 'seeders'));
        $seeder = array_filter(scandir($seedFolder), function ($file) {
            $file = explode('.php', $file);
            return count($file) == 2 && !in_array($file[0], $this->ignoreSeed);
        });
        $seeder = array_map(function ($file) {
            return explode('.php', $file)[0];
        }, $seeder);
        $seeder = array_values($seeder);
        foreach ($seeder as $seed) {
            Artisan::call('db:seed --class="' . $seed . '"');
        }
    }
}
