<?php

namespace App\Http\Controllers;

use App\City;
use App\State;
use App\Topic;
use App\Samuel\TopicSoul;
use App\Samuel\CommentSoul;
use Illuminate\Http\Request;
use App\Samuel\GoogleRecaptcha;
use App\Http\Requests\TopicRequest;
use App\Http\Requests\CommentRequest;
use \Aws\S3\S3Client;

class ToolsController extends Controller
{



    public function createS3FoldersOfGirls(Topic $topic)
    {
        echo "Ok";

        $s3Client = S3Client::factory([
            'credentials' => [
                'key' => ' AKIAJZ2ERZ5NLDUOLEKA',
                'secret' => ' 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'
            ],
            'version' => 'latest',
            'region' => 'sa-east-1'
        ]);

        $allTopic = $topic->all();
        
        foreach($allTopic as $topic)
        {
            
            if ($topic->cellphone && trim($topic->cellphone) !== "") {

                $city = $topic->city;
                $state = $topic->city->state;

                $citySlug = $city->slug;
                $stateSlug = $state->slug;

                $folder1 = env("APP_ENV").'/'.$stateSlug.'/'.$citySlug.'/'.$topic->slug.'/photos/';
                $folder2 = env("APP_ENV").'/'.$stateSlug.'/'.$citySlug.'/'.$topic->slug.'/capa/';
                $folder3 = env("APP_ENV").'/'.$stateSlug.'/'.$citySlug.'/'.$topic->slug.'/videos/';

                $result = $s3Client->putObject([
                    'Bucket' => 'forumttt',
                    'Key'    => $folder1,
                    'ACL'    => 'public-read'
                ]);

                $result = $s3Client->putObject([
                    'Bucket' => 'forumttt',
                    'Key'    => $folder2,
                    'ACL'    => 'public-read'
                ]);

                $result = $s3Client->putObject([
                    'Bucket' => 'forumttt',
                    'Key'    => $folder3,
                    'ACL'    => 'public-read'
                ]);
            }

        }
        echo "fim";
        
    }
}