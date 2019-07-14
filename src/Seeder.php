<?php

namespace Chojnicki\LaravelSeederDebugger;

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
        if (! $this->debug) return;

        /* Debug execution time */
        $executionTime = microtime(true) - $this->startExecutionTime;
        $this->command->info('Seeding execution time: ' . round($executionTime, 2) . 's.');

        /* Debug queries */
        $this->command->info('Database queries executed: ' . $this->queriesCount . '.');

        /* Debug RAM usage */
        $RAMUsage = memory_get_usage();
        $RAMUsage = round($RAMUsage / 1024 / 1024); // to MB
        $RAMUsagePeak = memory_get_peak_usage();
        $RAMUsagePeak = round($RAMUsagePeak / 1024 / 1024); // to MB

        $this->command->info('Current RAM usage is ' . $RAMUsage . 'MB with peak during execution ' . $RAMUsagePeak . 'MB.');
    }

}
