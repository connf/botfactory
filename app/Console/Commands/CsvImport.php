<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CsvImport extends Command
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
    protected $description = 'Import data from an API endpoint';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
