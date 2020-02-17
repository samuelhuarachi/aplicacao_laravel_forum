<?php

namespace App\Console\Commands;

use App\Samuel\Script;
use Illuminate\Console\Command;

class FillPhotoTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'traveco:fill-photo-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        $script = new Script();
        // $script->tempFillPhotoTable();
    }
}
