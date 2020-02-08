<?php

namespace App\Console\Commands;

use App\City;
use App\State;
use App\Topic;
use App\CellPhone;
use Aws\S3\S3Client;
use App\Samuel\Script;
use Illuminate\Console\Command;

class FullScan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'traveco:fullscan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Faz o scaneamento completo de uma pagina de cidade do site travesti com local, e sobe para produção';

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
        $script->fullScan(new Topic, new State, new City, new CellPhone);
    }
}
