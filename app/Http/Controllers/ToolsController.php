<?php

namespace App\Http\Controllers;

use App\City;
use App\State;
use App\Topic;
use App\CellPhone;
use \Aws\S3\S3Client;
use App\Samuel\Script;
use App\Samuel\General;
use App\Samuel\TopicSoul;
use \Cocur\Slugify\Slugify;
use App\Samuel\CommentSoul;
use Illuminate\Http\Request;
use App\Samuel\GoogleRecaptcha;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TopicRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;

class ToolsController extends Controller
{

    /**
     * Ach oque vou precisar mais usar
     *
     * @param Topic $topic
     * @return void
     */
    public function createS3FoldersOfGirls(Topic $topic)
    {
        echo "Ok";

        $s3Client = S3Client::factory([
            'credentials' => [
                'key' => ' ',
                'secret' => ' '
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
        //This will return the HTML source of the page as a string.
        $htmlString = file_get_contents(
            'https://www.garotascomlocal.com.br/acompanhante/kely-couto/');

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

            $altText = $imageTag->getAttribute('alt');

            $titleText = $imageTag->getAttribute('title');

            $extractedImages[] = array(
                'src' => $imgSrc,
                'alt' => $altText,
                'title' => $titleText
            );

            
            $ext = pathinfo($imgSrc, PATHINFO_EXTENSION);
            
            //dump($imgSrc);

            $url = $imgSrc;
            $img = 'teste1/foto-da-garotas-kely-couto-'.$count.'.webp';
            file_put_contents($img, file_get_contents($url));

            $count = $count + 1;
        }

        //dump("fim");

        //var_dump our array of images.
        // dump($extractedImages);
    }


    public function routineScan(Script $script)
    {
        $script->routineScan();
    }

    /**
     * Acho que nao vou precisar mais usar
     *
     * @param Topic $topic
     * @param State $stateModel
     * @param City $cityModel
     * @param CellPhone $cellphoneModel
     * @return void
     */
    public function fullScan(Topic $topic, State $stateModel, City $cityModel, CellPhone $cellphoneModel)
    {

        $this->clearTeste1Folder();
        $slugify = new \Cocur\Slugify\Slugify();
        $stateSlug = 'bahia';
        $citySlug = 'salvador';
        $url = 'https://www.garotascomlocal.com.br/salvador/';

        $stateFind = $stateModel->where('slug', $stateSlug)->first();
        $cityFind = $cityModel->where('slug', $citySlug)->where('state_id', $stateFind->id)->first();
        
        $htmlString = file_get_contents($url);

        $dom = new \DOMDocument;

        @$dom->loadHTML($htmlString);

        $allLinks = $dom->getElementsByTagName('a');
        $links = [];
        foreach($allLinks as $a) {
            $class = $a->getAttribute('class');
            if ($class == 'job_listing-clickbox') {
                $links[] = $a->getAttribute('href');

            }
        }

        foreach($links as $link) {
            $findPhone = "";
            $findName = "";
            $descritption = "";
            $this->clearTeste1Folder();

            $htmlString = file_get_contents($link);
            @$dom->loadHTML($htmlString);
            $allHeaders6 = $dom->getElementsByTagName('h6');
            foreach($allHeaders6 as $h6) {
                $class = $h6->getAttribute('class');

                if ($class == 'whatsapp-phone') {
                    $findPhone = trim(str_replace('- S?? CONTATO PROFISSIONAL OU SER?? BLOQUEADO','',trim($h6->textContent)));
                    //dump($findPhone);
                }
            }

            $allHeaders1 = $dom->getElementsByTagName('h1');
            foreach($allHeaders1 as $h1) {
                $class = $h1->getAttribute('class');

                if ($class == 'job_listing-title') {
                    $findName = ucwords(trim($h1->textContent));
                }
            }

            $allAside = $dom->getElementsByTagName('aside');
            foreach($allAside as $aside) {
                $id = $aside->getAttribute('id');
                if ($id == 'listify_widget_panel_listing_content-1') {
                    $descritption = trim($aside->textContent);
                }
            }

            if ($findPhone == "" || $findName == "") {
                // dump("nao encontrei todas as informacoes nesse link " . $link);
            } else {

                $slug = $slugify->slugify($findName);
                $justNumbersPhone = preg_replace('/\D/', '', $findPhone);

                
                if (strlen((string)$justNumbersPhone) == 11) {
                    $numberFormarted = vsprintf("(%s%s) %s%s%s%s%s-%s%s%s%s", str_split($justNumbersPhone));
                
                    $findTopic = $topic->where('cellphone', $numberFormarted)
                                        ->where('city_id', $cityFind->id)
                                        ->first();
                    
                    if (!$findTopic) {
                        $this->createNewTopic($cityFind->id, 1, $findName, $slug, $numberFormarted);
                    }

                    $findCellphone = $cellphoneModel->where('cellphone', $numberFormarted)->first();
                    if (!$findCellphone) {
                        $newCellphone = new CellPhone;
                        $newCellphone->cellphone = $numberFormarted;
                        $newCellphone->about = $descritption;
                        $newCellphone->save();
                    }


                    $checkIfExistsInS3 = $this->isExistsImagesInS3Folder($stateSlug, $citySlug, $slug);
                    if (!$checkIfExistsInS3) {
                        $this->clearTeste1Folder();
                        $this->saveImagesInTeste1Folder($slug, $link);
                        $this->saveImagesInS3($stateSlug, $citySlug, $slug);
                    }
                }
            }
        }
    }

    public function getCityAvailable(
        Topic $topic, 
        City $city, 
        State $state,
        General $general)
    {
        $citysAvailable = $general->getCitysAvailableFromCache();
        $general->generateSchemaScanCityState($citysAvailable);
    }

    public function createNewTopic($cityID, $userID, $girlName, $girlSlug, $cellphone)
    {
        $girlSlug = $this->ajustSlugIsExists($girlSlug, $cityID);

        $topic = new Topic;
        $topic->city_id = $cityID;
        $topic->user_id = $userID;
        $topic->title = $girlName;
        $topic->slug = $girlSlug;
        $topic->cellphone = $cellphone;
        $topic->save();
    }

    function ajustSlugIsExists($girlSlug, $cityID)
    {
        $topic = new Topic;
        $slug = $girlSlug;
        $checkIfExists = true;
        $count = 0;
        $slugBackup = $slug;
        while ($checkIfExists == true)
        {
            if ($count > 0) {
                $slug = $slugBackup . '-' . $count;
            }

            $topicCount = $topic->where('city_id', $cityID)
                                        ->where('slug', $slug)
                                        ->count();

            if ($topicCount == 0) {
                $checkIfExists = false;
            }
            $count = $count + 1;
        }

        return $slug;
    }

    public function clearTeste1Folder()
    {
        $files = glob(storage_path('logs').'/*');
        foreach($files as $file) {
            if(is_file($file))
                unlink($file);
        }
    }

    public function saveImagesInTeste1Folder($girlSlug, $url)
    {
        $htmlString = file_get_contents($url);
        $htmlDom = new \DOMDocument;
        @$htmlDom->loadHTML($htmlString);
        $imageTags = $htmlDom->getElementsByTagName('amp-img');
        
        $count = 1;
        foreach($imageTags as $imageTag) {
            $imgSrc = $imageTag->getAttribute('src');
            
            if ($imgSrc !== 'https://www.garotascomlocal.com.br/wp-content/uploads/2015/05/cropped-cropped-acompanhantes-garotass-de-programa-com-local.png' && $imgSrc !== 'https://www.garotascomlocal.com.br/wp-content/uploads/2020/02/cropped-cropped-acompanhantes-garotass-de-programa-com-local.png') {
                
                $img = storage_path('logs') . '/foto-da-garotas-'.$girlSlug.'-'.$count.'.webp';
                
                // file_put_contents($img, file_get_contents($imgSrc));

                if ($imgSrc && $img) {
                    copy($imgSrc, $img);
                }
                

                //dump($img);
                
                $count = $count + 1;
            }
        }
    }

    function saveImagesInS3($stateSlug, $citySlug, $trannhySlug)
    {
        $s3Client = S3Client::factory([
            'credentials' => [
                'key' => ' ',
                'secret' => ''
            ],
            'version' => 'latest',
            'region' => 'sa-east-1'
        ]);

        $files = glob(storage_path('logs').'/*'); // get all file names
        foreach($files as $file){ // iterate files
            if(is_file($file)) {
                
                $folder1 = env("APP_ENV").'/'.$stateSlug.'/'.$citySlug.'/'.$trannhySlug.'/photos/'.basename($file);
                $result = $s3Client->putObject([
                    'Bucket' => 'forumttt',
                    'Key'    => $folder1,
                    'ACL'    => 'public-read',
                    'SourceFile' => $file
                ]);
            }
        }
    }

    function isExistsImagesInS3Folder($stateSlug, $citySlug, $trannhySlug)
    {
        $folder2 = env("APP_ENV").'/'.$stateSlug.'/'.$citySlug.'/'.$trannhySlug.'/photos/';
        
        $s3Client = S3Client::factory([
            'credentials' => [
                'key' => ' ',
                'secret' => ' '
            ],
            'version' => 'latest',
            'region' => 'sa-east-1'
        ]);

        $objects = $s3Client->getIterator('ListObjects', array(
            'Bucket' => 'forumttt',
            'Prefix' => $folder2
        ));
        
        foreach($objects as $object) {
            if ($object["Size"] > 0) {
                return true;
            }
        }

        return null;
    }

    public function fillPhotos(Script $script)
    {
        $script->tempFillPhotoTable();
    }

}