<?php
namespace App\Samuel;

use App\Topic;
use Illuminate\Support\Facades\Auth;

class TopicSoul {

    protected $topic;

    public function __construct(Topic $topicModel)
    {
        $this->topic = $topicModel;
    }

    public function save($data, $request)
    {
        $user = Auth::user();

        $cityID = $request->session()->get('cityT');

        $slug = $this::slugify($data['title']);


        $checkIfExists = true;
        $count = 0;
        $slugBackup = $slug;
        while ($checkIfExists == true)
        {
            if ($count > 0) {
                $slug = $slugBackup . '-' . $count;
            }

            $topicCount = $this->topic->where('city_id', $cityID)
                                        ->where('slug', $slug)
                                        ->count();

            if ($topicCount == 0) {
                $checkIfExists = false;
            }
            $count = $count + 1;
        }

        $this->topic->city_id = $cityID;
        $this->topic->user_id = $user->id;
        $this->topic->title = $data['title'];
        $this->topic->slug = $slug;
        $this->topic->cellphone = $data['cellphone'];

        return $this->topic->save();
    }

    public static function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}