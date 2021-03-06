<?php

namespace App\Samuel;

use App\City;
use App\Photo;
use App\State;
use App\Topic;
use App\LastSee;
use App\CellPhone;
use Aws\S3\S3Client;
use App\Samuel\General;

class Script {

    protected $generalService;
    protected $logFileName;
    protected $linkGirls;
    protected $topicModel;
    protected $lastSeeModel;
    protected $stateModel;
    protected $cityModel;
    protected $cellphoneModel;

    public function __construct(
                        General $general, 
                        LastSee $lastSeeModel,
                        State $stateModel,
                        City $cityModel,
                        Topic $topicModel,
                        Cellphone $cellphoneModel)
    {
        $this->generalService = $general;
        $this->topicModel = $topicModel;
        $this->lastSeeModel = $lastSeeModel;
        $this->stateModel = $stateModel;
        $this->cityModel = $cityModel;
        $this->cellphoneModel = $cellphoneModel;
    }

    public function routineScan()
    {
        $slugify = new \Cocur\Slugify\Slugify();
        $this->createLogFile();
        $listOfLinks = $this->generalService->garotasComLocalMap();

        //dd($listOfLinks);

        foreach($listOfLinks as $currentLink)
        {
            $stateID = $currentLink['state_id'];
            $cityID = $currentLink['city_id'];
            $URL = $currentLink['url'];

            $girlLinkFounded = $this->findGirlsLinksOnThisCity($URL);
            foreach($girlLinkFounded as $linkGirls)
            {
                // $linkGirls = 'https://www.garotascomlocal.com.br/acompanhante/rosy-pinheiro-trans/';
                // dump($linkGirls);

                $this->linkGirls = $linkGirls;

                $girlName = $this->getGirlsName();
                if ($girlName == "") {
                    $this->writeInLog("Nome da garotas inválido".PHP_EOL."URL: ". $this->linkGirls);
                    continue;
                }

                $cellphone = $this->getGirlsCellPhone();
                $isCellphoneValid = $this->isCellphoneValid($cellphone);

                if ($isCellphoneValid) {

                    $cellphone = $this->formatCellPhoneNumber($cellphone);

                    $description = $this->getDescription();
                    $girlSlug = $slugify->slugify($girlName);


                    // if topic exists
                    $topicsFounded = $this->findTopicByCellphone($cellphone);

                    if (count($topicsFounded) == 0) {
                        $this->writeInLog("Nova garotas URL: " . $linkGirls);
                        //dump("Nova garotas URL: " . $linkGirls);
                        $newTopic = $this->createNewTopic($cityID, 1, $girlName, $girlSlug, $cellphone);
                        $this->saveGirlsDescription($cellphone, $description);

                        $stateFounded = $this->stateModel->find($stateID);
                        $cityFounded = $this->cityModel->find($cityID);

                    } else {
                        $topicFounded = $this->findTopicByCellphoneAndCity($cellphone, $cityID);
                        
                        if (!$topicFounded) {
                            $this->writeInLog("Mudou de cidade URL: " . $linkGirls);
                            //dump("Mudou de cidade URL: " . $linkGirls);
                            $this->createNewTopic($cityID, 1, $girlName, $girlSlug, $cellphone);
                        }
                    }

                    $this->updateLastSee($cellphone, $cityID);
                    $this->updateLinkInCellphoneTable($cellphone, $linkGirls);
                    
                } else {
                    $this->writeInLog("Celular inválido".PHP_EOL."URL: ". $this->linkGirls);
                }

                //dd("é apra ter ataulziado o linkt");
            }
        }
    }

    protected function updateLinkInCellphoneTable($cellphone, $linkGirls) {
        $findCellphone = $this->cellphoneModel->where('cellphone', $cellphone)->first();
        if ($findCellphone) {
            $findCellphone->update([
                'linkt' => $linkGirls
            ]);
        }
    }

    

    protected function isIssetPhotosInS3($topics)
    {
        foreach($topics as $topic) {
            $cityID = $topic->city_id;
            $cityFounded = $this->cityModel->find($cityID);
            $stateFounded = $this->stateModel->find($cityFounded->state_id);

            $photos = $this->getPhotos($stateFounded->slug, $cityFounded->slug, $topic->slug);
            if (count($photos) > 0) {
                return $photos;
            }
        }
        return null;
    }

    protected function isIssetPhotos($cellphone)
    {
        $photoModel = new Photo();
        return $photoModel->where('cellphone', $cellphone)->first();
    }

    protected function savePhotosInDB($stateSlug, $citySlug, $topicSlug, $cellphone)
    {
        $photos = $this->getPhotos($stateSlug, $citySlug, $topicSlug);
        foreach($photos as $photo) {
            $this->saveOnePhotoInDB($cellphone, $photo);
        }
    }

    protected function saveOnePhotoInDB($cellphone, $urlPhoto)
    {
        $photoModel = new Photo();
        $photoModel->cellphone = $cellphone;
        $photoModel->photo = $urlPhoto;
        $photoModel->save();
    }

    protected function saveGirlsDescription($cellphone, $description)
    {
        $findCellphone = $this->cellphoneModel->where('cellphone', $cellphone)->first();
        if (!$findCellphone) {
            $newCellphone = new CellPhone;
            $newCellphone->cellphone = $cellphone;
            $newCellphone->about = $description;
            $newCellphone->save();
        }
    }

    protected function updateLastSee($cellphone, $cityID)
    {
        $lastSeeFounded = $this->lastSeeModel->where('cellphone', $cellphone)
                                ->where('city_id', $cityID)
                                ->where('current', 1)
                                ->orderBy('created_at', 'desc')
                                ->first();

        if (!$lastSeeFounded) {
            $this->lastSeeModel->where('cellphone', $cellphone)
                ->update(['current' => false]);

            $lastSeeModel = new LastSee();
            $lastSeeModel->cellphone = $cellphone;
            $lastSeeModel->city_id = $cityID;
            $lastSeeModel->lastsee = date('Y-m-d');
            $lastSeeModel->current = true;
            $lastSeeModel->created_at = date('Y-m-d H:i:s');
            $lastSeeModel->updated_at = date('Y-m-d H:i:s');
            $lastSeeModel->save();
        } else {
            // $this->lastSeeModel->where('cellphone', $cellphone)
            //                  ->where('city_id', $cityID)
            //                 ->update([
            //                     'lastsee' => date('Y-m-d'),
            //                     'current' => true
            //                     ]);

            $this->lastSeeModel->where('cellphone', $cellphone)
                ->update(['current' => false]);
            $lastSeeFounded->update([
                                'lastsee' => date('Y-m-d'),
                                'current' => true
                            ]);
        }
    }

    protected function findTopicByCellphoneAndCity($cellphone, $cityID)
    {
        return $this->topicModel->where('cellphone', $cellphone)
                                        ->where('city_id', $cityID)
                                        ->first();
    }

    protected function findTopicByCellphone($cellphone)
    {
        return $this->topicModel->where('cellphone', $cellphone)
                                        //->where('city_id', $cityFind->id)
                                        ->get();
    }

    protected function getDescription()
    {
        $htmlString = file_get_contents($this->linkGirls);
        $dom = new \DOMDocument;
        @$dom->loadHTML($htmlString);
        $allAside = $dom->getElementsByTagName('aside');
        foreach($allAside as $aside) {
            $id = $aside->getAttribute('id');
            if ($id == 'listify_widget_panel_listing_content-1') {
                return trim($aside->textContent);
            }
        }
        return null;
    }

    protected function getGirlsName()
    {
        $htmlString = file_get_contents($this->linkGirls);
        $dom = new \DOMDocument;
        @$dom->loadHTML($htmlString);
        $allHeaders1 = $dom->getElementsByTagName('h1');
        foreach($allHeaders1 as $h1) {
            $class = $h1->getAttribute('class');
            if ($class == 'job_listing-title') {
                return ucwords(trim($h1->textContent));
            }
        }
    }

    protected function formatCellPhoneNumber($cellphone)
    {
        $telExplode = array_filter(explode(' ', $cellphone));

        $ddd = current($telExplode);
        next($telExplode);
        $numberCellPhone = current($telExplode);


        $ddd = $telExplode[0];
        $ddd = $this->formatDDD($ddd);

        //$numberCellPhone = $telExplode[1];
        //$ddd = substr($ddd, 1, 2);
        $cellphone = $ddd . $numberCellPhone;

        $justNumbersPhone = preg_replace('/\D/', '', $cellphone);
        return vsprintf("(%s%s) %s%s%s%s%s-%s%s%s%s", str_split($justNumbersPhone));
    }

    protected function isCellphoneValid($cellphone)
    {
        if ($cellphone == "") {
            $this->writeInLog("Número de celular inválido, vazio".PHP_EOL."URL: ".$this->linkGirls .PHP_EOL."Cellphone: ".$cellphone);
            return null;
        }

        $telExplode = array_filter(explode(' ', $cellphone));

        if (count($telExplode) !== 2) {
            dump("Número de celular inválido, falha no explode".PHP_EOL."URL: ".$this->linkGirls .PHP_EOL."Cellphone: ".$cellphone);
            $this->writeInLog("Número de celular inválido".PHP_EOL."URL: ".$this->linkGirls .PHP_EOL."Cellphone: ".$cellphone);
            return null;
        }

        $ddd = current($telExplode);
        next($telExplode);
        $numberCellPhone = current($telExplode);

        $ddd = $this->formatDDD($ddd);

        if (!$ddd) {
            dump("Número de celular inválido, falha no ddd".PHP_EOL."URL: ".$this->linkGirls .PHP_EOL."Cellphone: ".$cellphone);
            return null;
        }


        $cellphone = $ddd . $numberCellPhone;

        $justNumbersPhone = preg_replace('/\D/', '', $cellphone);

        if (strlen((string)$justNumbersPhone) != 11) {
            $this->writeInLog("Número de celular inválido".PHP_EOL."URL: ".$this->linkGirls .PHP_EOL."Cellphone: ".$cellphone);
            return null;
        }

        return true;
    }

    protected function formatDDD($ddd) {

        if (!$ddd) {
            return null;
        }

        $ddd = str_replace(array('(',')'), '',$ddd);

        $number = intval($ddd);

        if ($number == 0) { 
            return null;
        }

        $ddd = strval($number);

        if (strlen($ddd) !== 2) {
            return null;
        }

        return $ddd;
    }

    protected function getGirlsCellPhone()
    {
        $cellphoneFinded = null;
        $htmlString = file_get_contents($this->linkGirls);
        $dom = new \DOMDocument;
        @$dom->loadHTML($htmlString);

        $allDivs = $dom->getElementsByTagName('div');
        foreach($allDivs as $div) {
            $divClass = $div->getAttribute('class');
            if ($divClass == 'job_listing-phone') {
                $allA = $div->getElementsByTagName('a');
                foreach($allA as $a) {

                    if ($a->textContent == "WhatsApp" || $a->textContent == "Whatsapp" || $a->textContent == "WhatsaApp") {

                        break;
                    }
                    return $cellphoneFinded = $a->textContent;
                }
            }
        }

        $allHeaders6 = $dom->getElementsByTagName('h6');
        foreach($allHeaders6 as $h6) {
            $class = $h6->getAttribute('class');
            if ($class == 'whatsapp-phone') {
                return trim(str_replace('- SÓ CONTATO PROFISSIONAL OU SERÁ BLOQUEADO','',trim($h6->textContent)));
            }
        }
    }

    protected function createLogFile()
    {
        $fileName = storage_path()."/".date('d_m_Y__H_i_s').".log";
        $log= fopen($fileName, "w");
        fclose($log);
        chmod($fileName, 0777);
        $this->logFileName = $fileName;
    }

    protected function writeInLog($text)
    {
        $text = $text.PHP_EOL;
        $hour = "[".date('H:i:s')."]".PHP_EOL;
        $separator = "==========================================".PHP_EOL.PHP_EOL;
        $log = fopen($this->logFileName, 'a');
        fwrite($log, $hour);
        fwrite($log, $text);
        fwrite($log, $separator);
        fclose($log);
    }

    protected function findGirlsLinksOnThisCity($url)
    {
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

        return $links;
    }

    public function fullScan(Topic $topic, State $stateModel, City $cityModel, CellPhone $cellphoneModel)
    {

        $this->clearTeste1Folder();
        $slugify = new \Cocur\Slugify\Slugify();
        $stateSlug = 'amapa';
        $citySlug = 'macapa';
        $url = 'https://www.garotascomlocal.com.br/macapa/';

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
                    $findPhone = trim(str_replace('- SÓ CONTATO PROFISSIONAL OU SERÁ BLOQUEADO','',trim($h6->textContent)));
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
                        //$this->clearTeste1Folder();
                        //$this->saveImagesInTeste1Folder($slug, $link);
                        //$this->saveImagesInS3($stateSlug, $citySlug, $slug);
                    }
                }
            }
        }
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

        return $topic;
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
                
                

                if ($imgSrc && $img) {
                //    file_put_contents($img, file_get_contents($imgSrc));
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
                'secret' => ' '
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

    function getPhotos($stateSlug, $citySlug, $trannhySlug)
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

        $photos = [];
        foreach($objects as $object) {
            if ($object["Size"] > 0) {
                $photos[] = 'https://forumttt.s3-sa-east-1.amazonaws.com/'.$object['Key'];
            }
        }

        return $photos;
    }

    public function tempFillPhotoTable()
    {

        $topic = new Topic();
        $city = new City();
        $state = new State();

        $topicFind = $topic
                ->where('cellphone', '!=', "")
                ->whereNotNull('cellphone')->get();
        
        foreach($topicFind as $topic) {
            $cityID = $topic->city_id;
            $cityFind = $city->find($cityID);
            $stateFind = $state->find($cityFind->state_id);

            $photos = $this->getPhotos($stateFind->slug, $cityFind->slug, $topic->slug);
            foreach($photos as $photo) {
                $photoModel = new Photo();
                $photoModel->cellphone = $topic->cellphone;
                $photoModel->photo = $photo;
                $photoModel->save();
            }
        }
        //dump("FIM");
    }

    public function tempFillLasSee()
    {
        $topic = new Topic();
        $topicFind = $topic
                ->where('cellphone', '!=', "")
                ->whereNotNull('cellphone')->get();
        
        foreach($topicFind as $topic) {
            $lastSee = new LastSee();
            $lastSee->cellphone = $topic->cellphone;
            $lastSee->city_id = $topic->city_id;
            $lastSee->lastsee = date('Y-m-d');
            $lastSee->current = true;
            $lastSee->save();
        }
        //dump("FIM LAST SEE");
    }

    public function normalizeLastSee()
    {
        $topic = new Topic();
        $topicFind = $topic
                ->where('cellphone', '!=', "")
                ->whereNotNull('cellphone')->get();
        
        foreach($topicFind as $topic) {
            $this->updateLastSee($topic->cellphone, $topic->city_id);
        }
        //dump("FIM");
    }
}