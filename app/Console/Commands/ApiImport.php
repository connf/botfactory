<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ApiImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from a CSV file (usually called orders.csv)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
