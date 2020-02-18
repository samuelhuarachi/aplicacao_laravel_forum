<?php

namespace App\Console\Commands;

use App\Samuel\Script;
use Illuminate\Console\Command;

class RoutineScan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'traveco:routine-scan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $scriptService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Script $script)
    {
        parent::__construct();
        $this->scriptService = $script;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->scriptService->routineScan();
    }
}
