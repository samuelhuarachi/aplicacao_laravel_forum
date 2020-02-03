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

    public function extractImagesFromWebSite()
    {
        echo "ok";

        //This will return the HTML source of the page as a string.
        $htmlString = file_get_contents(
            'https://www.travesticomlocal.com.br/acompanhante/grazi-martins/');

        //Create a new DOMDocument object.
        $htmlDom = new \DOMDocument;

        //Load the HTML string into our DOMDocument object.
        @$htmlDom->loadHTML($htmlString);

        //Extract all img elements / tags from the HTML.
        $imageTags = $htmlDom->getElementsByTagName('amp-img');

        //Create an array to add extracted images to.
        $extractedImages = array();

        $count = 1;
        //Loop through the image tags that DOMDocument found.
        foreach($imageTags as $imageTag){

            //Get the src attribute of the image.
            $imgSrc = $imageTag->getAttribute('src');

            //Get the alt text of the image.
            $altText = $imageTag->getAttribute('alt');

            //Get the title text of the image, if it exists.
            $titleText = $imageTag->getAttribute('title');

            //Add the image details to our $extractedImages array.
            $extractedImages[] = array(
                'src' => $imgSrc,
                'alt' => $altText,
                'title' => $titleText
            );

            
            $ext = pathinfo($imgSrc, PATHINFO_EXTENSION);
            
            dump($imgSrc);
            // $ch = curl_init($imgSrc);
            // $fp = fopen('teste1/foto-nicoly-maya-'.$count.'.webp', 'wb');
            // curl_setopt($ch, CURLOPT_FILE, $fp);
            // curl_setopt($ch, CURLOPT_HEADER, 0);
            // curl_exec($ch);
            // curl_close($ch);
            // fclose($fp);

            $url = $imgSrc;
            $img = 'teste1/foto-da-travesti-grazi-martins-'.$count.'.webp';
            file_put_contents($img, file_get_contents($url));

            $count = $count + 1;
        }

        dump("fim");

        //var_dump our array of images.
        // dump($extractedImages);
    }
}