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

class IndexController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, State $state, City $city)
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

        return view('index', compact(
                    'states',
                    'stateFounded',
                    'cityFounded',
                    'allCities'));
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
            // return redirect()->back()->withErrors(['Captcha inválido']);
        }

        $response = $topicSoul->save($data, $request);

        if ($response) {

        }

        return redirect()->back();
    }

    public function topicDetails($state, $city, $slug,
                        State $stateModel, City $cityModel,
                        Topic $topic)
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

        return view('forum.topic.detail', 
                        compact(
                            'topicFind', 
                            'stateFounded', 
                            'cityFounded'));
    }

    public function commentInsert(
                        CommentRequest $request,
                        GoogleRecaptcha $googleRecaptcha,
                        CommentSoul $commentSoul)
    {

        $data = $request->all();
        $recaptchaResponse = $data['g-recaptcha-response'];

        if (!$googleRecaptcha->isvalid($recaptchaResponse)) {
            // return redirect()->back()->withErrors(['Captcha inválido']);
        }

        $commentSoul->insert($data);

        return redirect()->back();
    }
}
