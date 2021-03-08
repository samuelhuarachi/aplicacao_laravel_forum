<?php

namespace App\Http\Controllers;

use App\City;
use App\Photo;
use App\State;
use App\Topic;
use App\LastSee;
use App\CellPhone;
use App\Samuel\S3Soul;
use App\Samuel\ReplySoul;
use App\Samuel\TopicSoul;
use App\Samuel\CommentSoul;
use Illuminate\Http\Request;
use App\Samuel\GoogleRecaptcha;
use App\Http\Requests\ReplyRequest;
use App\Http\Requests\TopicRequest;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Cache;
use App\Samuel\Statistic\StatisticSingle;
use Aws\S3\S3Client;

class IndexController extends Controller
{

    public function teste2() {
        echo "teste2";

        $s3Client = S3Client::factory([
            'credentials' => [
                'key' => ' AKIAJZ2ERZ5NLDUOLEKA',
                'secret' => ' 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'
            ],
            'version' => 'latest',
            'region' => 'sa-east-1'
        ]);

        // $objects = $s3Client->getPaginator('ListObjects', ['Bucket' => "forumttt"]);
        // foreach ($objects as $listResponse) {
        //     $items = $listResponse->search("Contents[?starts_with(Key,'production/')]");
        //     foreach($items as $item) {
        //         dump($item['Key']);
        //     }
        // }
        //$s3Client->deleteMatchingObjects('forumttt', 'local/tocantins');

        $objects = $s3Client->getIterator('ListObjects', array(
            "Bucket" => 'forumttt',
            "Prefix" => "production/"
        )); 

        $i=0;

        foreach ($objects as $a) {
            print_r($a['Key']);
            echo "<br>";

            if(++$i > 100) break;
        }

        echo "conectado na s3";
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(
        Request $request, 
        State $state, 
        City $city,
        StatisticSingle $statisticSingle,
        S3Soul $s3Soul)
    {
        $states = $state->all();

        $stateT = $request->session()->get('stateT');
        $cityT = $request->session()->get('cityT');

        if (!$stateT) {
            $request->session()->put('stateT', 26);
            $stateT = 26;
        }
        if (!$cityT) {
            $request->session()->put('cityT', 3374);
            $cityT = 3374;
        }

        $cityFounded = $city->find($cityT);
        $stateFounded = $state->find($stateT);


        $allCities = Cache::rememberForever('allCities_' . $stateT, function () use ($city, $stateT) {
                return $city->where('state_id', $stateT)->get();
        });


        $coversList = [];
        $lastSeeList = [];
        $lastSee = new LastSee();
        $photoModel = new Photo();
        $listt = [];
        

        $cityFoundedArray = Cache::remember('cityFounded_' . $cityT, 720,
            function () use ($cityFounded) {
                return $cityFounded->topics->toArray();
        });

        $totaTopics =$cityFounded->topics()->count();
        $cityFoundedPaginate = $cityFounded->topics()->latest()->paginate(100);

        foreach($cityFoundedPaginate->items() as $topic)
        {
            // Defenindo foto de capa
            // $photoFounded = Cache::rememberForever('foto-de-capa-'.$topic['cellphone'], function () use($topic, $photoModel) {
            //     return $photoModel->where('cellphone', $topic['cellphone'])->first();
            // });
            
            // if ($photoFounded) {
            //     $coversList[$topic['slug']] = $photoFounded->photo;
            // }

            /**
             * ultima vez que foi vista
             */
            $lastSeeFounded = Cache::remember($topic['cellphone'] ."_" .$topic['city_id'], 720, function() use ($lastSee, $topic)
            {
                return $lastSee
                    ->select('lastsee', 'current')
                    ->where('cellphone', $topic['cellphone'])
                    ->where('city_id', $topic['city_id'])
                    ->orderBy('created_at', 'desc')
                    ->first();
            });

            if ($lastSeeFounded) {
                $lastSeeList[$topic['cellphone']] = [
                    'data' => $lastSeeFounded->toArray()
                ];
            }

            /**
             * carrega uma lista da cidade atual, onde a gp esta
             */
            $statisticSingle->setCellphone($topic['cellphone']);
            $listt[$topic['cellphone']] = $statisticSingle->get(true, null);
        }


        return view('index', compact(
                    'cityFoundedPaginate',
                    'states',
                    'stateFounded',
                    'cityFounded',
                    'allCities',
                    'totaTopics',
                    's3Soul',
                    'listt',
                    'coversList',
                    'lastSeeList'));
    }

    public function setNewState($id, State $state, City $city, Request $request)
    {
        $stateFind = $state->find($id);
        if (!$stateFind) {
            return redirect()->route('forum.index');
        }

        if ($stateFind->slug == 'sao-paulo') {
            $cityFind = $city->where('slug', 'sao-paulo')->first();
        }elseif($stateFind->slug == 'rio-de-janeiro') {
            $cityFind = $city->where('slug', 'rio-de-janeiro')->first();
        }else {
            $cityFind = $city->where('state_id', $stateFind->id)->first();
        }
        
        $request->session()->put('stateT', $stateFind->id);
        $request->session()->put('cityT', $cityFind->id);

        return redirect()->route('forum.index');
    }

    public function setNewCity(Request $request, State $state, City $city)
    {
        $data = $request->all();
        $cityID = (int)$data['cityID'];

        $cityFind = $city->find($cityID);

        if (!$cityFind) {
            return redirect()->route('forum.index');
        }

        $stateFind = $state->find($cityFind->state_id);

        $request->session()->put('stateT', $stateFind->id);
        $request->session()->put('cityT', $cityFind->id);

        return redirect()->route('forum.index');
    }

    public function topicNew($stateSlug, $citySlug, 
                State $stateModel, City $cityModel)
    {
        $stateFind = $stateModel->where('slug', $stateSlug)->first();

        if (!$stateFind) {
            return redirect()->route('forum.index');
        }

        $cityFind = $cityModel
                    ->where('state_id', $stateFind->id)
                    ->where('slug', $citySlug)
                    ->first();

        if (!$cityFind) {
            return redirect()->route('forum.index');
        }

        $stateFounded = $stateFind;
        $cityFounded = $cityFind;

        return view('forum.topic.new', 
                compact('stateFind', 'cityFind',
                        'stateFounded', 'cityFounded'));
    }

    public function topicInsert(
        TopicRequest $request,
        GoogleRecaptcha $googleRecaptcha,
        TopicSoul $topicSoul)
    {
        $data = $request->all();

        $recaptchaResponse = $data['g-recaptcha-response'];

        if (!$googleRecaptcha->isvalid($recaptchaResponse)) {
            return redirect()->back()->withErrors(['Captcha inválido']);
        }

        try {
            $response = $topicSoul->save($data, $request);
            return redirect()->route('forum.index');
        } catch(\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function topicDetails($state, $city, $slug,
                        State $stateModel, City $cityModel,
                        Topic $topic, CellPhone $cellPhoneModel,
                        Request $request,
                        StatisticSingle $statisticSingle,
                        Photo $photoModel)
    {
        
        $stateFind = $stateModel->where('slug', $state)->first();

        if (!$stateFind) {
            return redirect()->route('forum.index');
        }

        $cityFind = $cityModel
                    ->where('state_id', $stateFind->id)
                    ->where('slug', $city)
                    ->first();

        if (!$cityFind) {
            return redirect()->route('forum.index');
        }

        $stateFounded = $stateFind;
        $cityFounded = $cityFind;

        $topicFind = $topic->where('city_id', $cityFind->id)
                           ->where('slug', $slug)
                           ->first();

        if (!$topicFind) {
            // redirecion para a 404
            return redirect()->route('forum.index');
        }

        $request->session()->put('stateT', $stateFounded->id);
        $request->session()->put('cityT', $cityFounded->id);

        $photos = [];
        // if ($topicFind->cellphone && trim($topicFind->cellphone) !== "") {
        //     $photos = $photoModel->where('cellphone', $topicFind->cellphone)->get();
        // }

        $findedCellphone = $cellPhoneModel->where('cellphone', $topicFind->cellphone)->first();


        $statisticSingle->setCellphone($topicFind->cellphone);
        $statistic = $statisticSingle->get();
        
        return view('forum.topic.detail', 
                        compact(
                            'topicFind', 
                            'stateFounded', 
                            'cityFounded',
                            'photos',
                            'statistic',
                            'findedCellphone'));
    }

    public function commentInsert(
                        CommentRequest $request,
                        GoogleRecaptcha $googleRecaptcha,
                        CommentSoul $commentSoul)
    {

        $data = $request->all();
        $recaptchaResponse = $data['g-recaptcha-response'];

        if (!$googleRecaptcha->isvalid($recaptchaResponse)) {
            return redirect()->back()->withErrors(['Captcha inválido']);
        }

        $commentSoul->insert($data);

        return redirect()->back();
    }

    public function newReply(ReplyRequest $replyRequest, 
                        ReplySoul $replySoul,
                        GoogleRecaptcha $googleRecaptcha)
    {
        $data = $replyRequest->all();
        $recaptchaResponse = $data['g-recaptcha-response'];
        if (!$googleRecaptcha->isvalid($recaptchaResponse)) {
            return redirect()->back()->withErrors(['Captcha inválido']);
        }

        $replySoul->save($data);
        return redirect()->back();
    }

    
}
