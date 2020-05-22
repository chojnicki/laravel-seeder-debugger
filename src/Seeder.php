<?php

namespace Chojnicki\LaravelSeederDebugger;

use Chojnicki\LaravelSeederDebugger\Events\SeedingFinished;
use DB;

abstract class Seeder extends \Illuminate\Database\Seeder
{
    public $startExecutionTime; // will be set at construction
    public $queriesCount = 0; // will increase after every seeding query
    public $debug = true; // show debug info at end


    /**
     * Save start time for calculating execution time
     */
    public function __construct()
    {
        if ($this->debug) {
            $this->startExecutionTime = microtime(true);

            DB::listen(function () {
                $this->queriesCount++;
            });
        }
    }


    /**
     * Show debug info after finish
     */
    public function __destruct()
    {
        if (get_class($this) != 'DatabaseSeeder') return; // print debug only on main seeder
        
        if (! $this->debug) return;

        /* Debug execution time */
        $executionTime = microtime(true) - $this->startExecutionTime;
        $this->command->info('Seeding execution time: ' . round($executionTime, 2) . 's.');

        /* Debug queries */
        $this->command->info('Database queries executed: ' . $this->queriesCount . '.');

        /* Debug RAM usage */
        $RAMUsage = memory_get_usage();
        $RAMUsage = round($RAMUsage / 1024 / 1024, 2); // to MB
        $RAMUsagePeak = memory_get_peak_usage();
        $RAMUsagePeak = round($RAMUsagePeak / 1024 / 1024, 2); // to MB

        /* Print debug in console */
        $this->command->info('Current RAM usage is ' . $RAMUsage . 'MB with peak during execution ' . $RAMUsagePeak . 'MB.');

        /* Fire event with debug */
        event(new SeedingFinished([
            'execution_time' => $executionTime,
            'queries_count' => $this->queriesCount,
            'ram_usage' => $RAMUsage,
            'ram_usage_peak' => $RAMUsage,
        ]));
    }

}
