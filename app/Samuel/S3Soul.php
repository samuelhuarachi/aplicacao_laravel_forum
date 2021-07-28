<?php
namespace App\Samuel;

use Aws\S3\S3Client;

class S3Soul
{

    public function getS3Client() {
        return S3Client::factory([
            'credentials' => [
                'key' => ' ',
                'secret' => ' '
            ],
            'version' => 'latest',
            'region' => 'sa-east-1'
        ]);
    }

    public function findOnePhotoTranny($stateSlug, $citySlug, $topicSlug) {
        
        $s3Client = $this->getS3Client();
        $folder2 = env("APP_ENV").'/'.$stateSlug.'/'.$citySlug.'/'.$topicSlug.'/photos/';
        $objects = $s3Client->getIterator('ListObjects', array(
            'Bucket' => 'forumttt',
            'Prefix' => $folder2
        ));
        
        if (!$objects) {
            return null;
        }

        $listObjects = [];
        foreach($objects as $object) {
            $listObjects[] = $object;
            
        }
        
        shuffle($listObjects);
        foreach($listObjects as $object) {

            if ($object['Size'] !== "0") {
                return 'https://forumttt.s3-sa-east-1.amazonaws.com/'.$object['Key'];
            }
            
        }
        return null;
    }

}