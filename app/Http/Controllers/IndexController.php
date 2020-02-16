<?php

namespace App\Http\Controllers;

use App\City;
use App\State;
use App\Topic;
use App\CellPhone;
use \Aws\S3\S3Client;
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

class IndexController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(
        Request $request, 
        State $state, 
        City $city,
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
        $allCities = $city->where('state_id', $stateT)->get();

        // findOnePhotoTranny

        $coversList  = Cache::remember($stateFounded->slug . '-' . $cityFounded->slug . '-covers', 604800, function () use($stateFounded, $cityFounded, $s3Soul) {
            $photosList = [];
            foreach($cityFounded->topics as $topic)
            {
                $photoFinded = $s3Soul->findOnePhotoTranny($stateFounded->slug, $cityFounded->slug, $topic->slug);
                if ($photoFinded) {
                    $photosList[$topic->slug] = $photoFinded;
                }
            }
            return $photosList;
        });

        return view('index', compact(
                    'states',
                    'stateFounded',
                    'cityFounded',
                    'allCities',
                    's3Soul',
                    'coversList'));
    }

    public function setNewState($id, State $state, City $city, Request $request)
    {
        $stateFind = $state->find($id);
        if (!$stateFind) {
            return redirect()->route('forum.index');
        }

        $cityFind = $city->where('state_id', $stateFind->id)->first();

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
                        Request $request)
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
        if ($topicFind->cellphone && trim($topicFind->cellphone) !== "") {
            $s3Client = S3Client::factory([
                            'credentials' => [
                                'key' => ' AKIAJZ2ERZ5NLDUOLEKA',
                                'secret' => ' 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'
                            ],
                            'version' => 'latest',
                            'region' => 'sa-east-1'
                        ]);

            $folder2 = env("APP_ENV").'/'.$stateFounded->slug.'/'.$cityFounded->slug.'/'.$topicFind->slug.'/photos/';
            
            $objects = $s3Client->getIterator('ListObjects', array(
                'Bucket' => 'forumttt',
                'Prefix' => $folder2
            ));

            foreach($objects as $object) {

                if ($object['Size'] !== "0") {
                    $photo = 'https://forumttt.s3-sa-east-1.amazonaws.com/'.$object['Key'];

                    $photos[] = $photo;
                }
                
            }
        }

        $findedCellphone = $cellPhoneModel->where('cellphone', $topicFind->cellphone)->first();

        return view('forum.topic.detail', 
                        compact(
                            'topicFind', 
                            'stateFounded', 
                            'cityFounded',
                            'photos',
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
