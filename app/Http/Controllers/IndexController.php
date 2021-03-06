<?php

namespace App\Http\Controllers;

use App\City;
use App\Photo;
use App\State;
use App\Topic;
use App\Comment;
use App\LastSee;
use App\CellPhone;
use Aws\S3\S3Client;
use App\Samuel\S3Soul;
use App\Samuel\Script;
use App\Samuel\ReplySoul;
use App\Samuel\TopicSoul;
use App\Samuel\CommentSoul;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Samuel\GoogleRecaptcha;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ReplyRequest;
use App\Http\Requests\TopicRequest;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Cache;
use App\Samuel\Statistic\StatisticSingle;

class IndexController extends Controller
{


    public function teste3(Script $script) {
        echo "teste 333";
        $script->routineScan();
    }

    public function teste2() {
        echo "teste2";

        $s3Client = S3Client::factory([
            'credentials' => [
                'key' => ' ',
                'secret' => ' '
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
        S3Soul $s3Soul,
        Topic $topicModel)
    {
        $cellphone = $request->input('cellphone');

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


        $cellphoneSearch = null;
        if ($cellphone && $cellphone !== "") {
            $topicFouded = $topicModel->where('cellphone', $cellphone)->limit(1)->get();
            $totaTopics = 1;
            $cityFoundedPaginate = $topicModel->where('cellphone', $cellphone)->paginate(1);
            $cellphoneSearch = true;

            if ($topicFouded) {
                $cityFounded = $topicFouded->first()->city;
                $stateFounded = $topicFouded->first()->city->state;
            }

        } else {
            $totaTopics =$cityFounded->topics()->count();
            $cityFoundedPaginate = $cityFounded->topics()->latest()->paginate(100);
        }
        

        $cellPhoneNewGirl = [];
        $expiresAt = Carbon::now()->addMinutes(700);
        $expiresAt2 = Carbon::now()->addMinutes(180);


        foreach($cityFoundedPaginate->items() as $topic)
        {
            // Defenindo foto de capa
            // $photoFounded = Cache::rememberForever('foto-de-capa-'.$topic['cellphone'], function () use($topic, $photoModel) {
            //     return $photoModel->where('cellphone', $topic['cellphone'])->first();
            // });
            
            // if ($photoFounded) {
            //     $coversList[$topic['slug']] = $photoFounded->photo;
            // }

            if ($topic['cellphone']) {

                
                $qtd = Cache::remember(str_replace(' ', '', $topic['cellphone']) . "_new_girl", $expiresAt, function() use ($topicModel, $topic)
                {
                    return $topicModel->select('id')
                                        ->where('cellphone', $topic['cellphone'])
                                        ->where(function($query) {
                                            $query->where('created_at', '<=', '2021-03-13 00:00:00')
                                                ->orWhere('created_at', '<', date('Y-m-d H:i:s', strtotime('-30 days')));
                                        })
                                        ->count();
                });

                $cellPhoneNewGirl[$topic['cellphone']] = $qtd;
            }
            


            /**
             * ultima vez que foi vista
             */
            $lastSeeFounded = Cache::remember($topic['cellphone'] ."_" .$topic['city_id'], $expiresAt2, function() use ($lastSee, $topic)
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

        //dump($cityFoundedPaginate->items());


        return view('index', compact(
                    'cityFoundedPaginate',
                    'states',
                    'stateFounded',
                    'cityFounded',
                    'allCities',
                    'totaTopics',
                    's3Soul',
                    'listt',
                    'cellPhoneNewGirl',
                    'coversList',
                    'cellphoneSearch',
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
        }elseif($stateFind->slug == 'minas-gerais') {
            $cityFind = $city->where('slug', 'belo-horizonte')->first();
        }elseif($stateFind->slug == 'acre') {
            $cityFind = $city->where('slug', 'rio-branco')->first();
        }elseif($stateFind->slug == 'alagoas') {
            $cityFind = $city->where('slug', 'maceio')->first();
        }elseif($stateFind->slug == 'amazonas') {
            $cityFind = $city->where('slug', 'manaus')->first();
        }elseif($stateFind->slug == 'amapa') {
            $cityFind = $city->where('slug', 'macapa')->first();
        }elseif($stateFind->slug == 'bahia') {
            $cityFind = $city->where('slug', 'salvador')->first();
        }elseif($stateFind->slug == 'ceara') {
            $cityFind = $city->where('slug', 'fortaleza')->first();
        }elseif($stateFind->slug == 'espirito-santo') {
            $cityFind = $city->where('slug', 'vitoria')->first();
        }elseif($stateFind->slug == 'goias') {
            $cityFind = $city->where('slug', 'goiania')->first();
        }elseif($stateFind->slug == 'maranhao') {
            $cityFind = $city->where('slug', 'sao-luis')->first();
        }elseif($stateFind->slug == 'mato-grosso-do-sul') {
            $cityFind = $city->where('slug', 'campo-grande-')->first();
        }elseif($stateFind->slug == 'mato-grosso') {
            $cityFind = $city->where('slug', 'cuiaba')->first();
        }elseif($stateFind->slug == 'para') {
            $cityFind = $city->where('slug', 'belem')->first();
        }elseif($stateFind->slug == 'paraiba') {
            $cityFind = $city->where('slug', 'joao-pessoa')->first();
        }elseif($stateFind->slug == 'pernambuco') {
            $cityFind = $city->where('slug', 'recife')->first();
        }elseif($stateFind->slug == 'piaui') {
            $cityFind = $city->where('slug', 'teresina')->first();
        }elseif($stateFind->slug == 'parana') {
            $cityFind = $city->where('slug', 'curitiba')->first();
        }elseif($stateFind->slug == 'rio-grande-do-norte') {
            $cityFind = $city->where('slug', 'natal')->first();
        }elseif($stateFind->slug == 'rondonia') {
            $cityFind = $city->where('slug', 'porto-velho')->first();
        }elseif($stateFind->slug == 'roraima') {
            $cityFind = $city->where('slug', 'boa-vista')->first();
        }elseif($stateFind->slug == 'rio-grande-do-sul') {
            $cityFind = $city->where('slug', 'porto-alegre')->first();
        }elseif($stateFind->slug == 'santa-catarina') {
            $cityFind = $city->where('slug', 'florianopolis')->first();
        }elseif($stateFind->slug == 'tocantins') {
            $cityFind = $city->where('slug', 'palmas')->first();
        }elseif($stateFind->slug == 'sergipe') {
            $cityFind = $city->where('slug', 'aracaju')->first();
            
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
            return redirect()->back()->withErrors(['Captcha inv??lido']);
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
                        Comment $commentModel,
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
        

        $expiresAt = Carbon::now()->addMinutes(700);
        $qtdNewGirl = Cache::remember(str_replace(' ', '', $topicFind->cellphone) . "_new_girl", $expiresAt, function() use ($topic, $topicFind)
                {
                    return $topic->select('id')
                                        ->where('cellphone', $topicFind->cellphone)
                                        ->where(function($query) {
                                            $query->where('created_at', '<=', '2021-03-13 00:00:00')
                                                ->orWhere('created_at', '<', date('Y-m-d H:i:s', strtotime('-30 days')));
                                        })
                                        ->count();
                });
                
        return view('forum.topic.detail', 
                        compact(
                            'topicFind', 
                            'commentModel',
                            'stateFounded', 
                            'cityFounded',
                            'qtdNewGirl',
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
            return redirect()->back()->withErrors(['Captcha inv??lido']);
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
            return redirect()->back()->withErrors(['Captcha inv??lido']);
        }

        $replySoul->save($data);
        return redirect()->back();
    }

    
}
