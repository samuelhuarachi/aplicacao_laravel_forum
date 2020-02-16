<?php

namespace App\Console\Commands;

use App\City;
use App\Samuel\S3Soul;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class GenerateTrannyCoverThumbs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'traveco:generatethumbs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gera thumb das travestis';

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
        
        $s3Soul = new S3Soul();
        $city = new City();
        $cityFounded = $city->find(3828);

        $coversList  = Cache::remember('sao-paulo' . '-' . 'sao-paulo' . '-covers', 604800, function () use($s3Soul, $cityFounded) {
            $photosList = [];

            foreach($cityFounded->topics as $topic)
            {
                $photoFinded = $s3Soul->findOnePhotoTranny('sao-paulo', 'sao-paulo', $topic->slug);
                if ($photoFinded) {
                    $photosList[$topic->slug] = $photoFinded;
                }
            }
            return $photosList;
        });
    }
}
