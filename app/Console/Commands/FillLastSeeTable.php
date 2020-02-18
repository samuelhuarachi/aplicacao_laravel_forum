<?php

namespace App\Console\Commands;

use App\Samuel\Script;
use Illuminate\Console\Command;

class FillLastSeeTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'traveco:fill-lastsee-table';

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
        $this->scriptService->tempFillLasSee();
    }
}
