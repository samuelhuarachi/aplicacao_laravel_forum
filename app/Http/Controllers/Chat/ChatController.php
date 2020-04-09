<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Samuel\Chat\Authenticate;
use App\Samuel\Chat\AnalistService;
use Session;
use App\Samuel\Chat\ClientService;

class ChatController extends Controller
{
    
    public function client($slug, ClientService $clientService)
    {
        $analistExists = $clientService->getAnalistBySlug($slug);

        if (!$analistExists)
            abort(404);
        
        $isAvailable = $clientService->checkRoomIsAvailable($slug);
        if (!$isAvailable) {
            $message = "Parece que a modelo não está mais online :(";
                return view('chat.analist.message',
                            compact('message'));
        }

        return view('chat.client.client');
    }

    public function analist($slug, AnalistService $analistService)
    {
        $myData = Session::get('myData');

        if (!$myData) {
            abort(403, 'Unauthorized');
        }

        if ($slug != $myData->slug) {
            abort(403, 'Unauthorized');
        }

        $token = Session::get('myToken');

        $analistFind = $analistService->sessionOpenedBySlug($slug);

        if ($analistFind) {
            $analistFind  = json_decode($analistFind);
            if ($analistFind->findAnalist) {
                $message = "Identificamos que existe uma sessão aberta para você. 
                <br>Caso não consiga solucionar o problema, entrar em contato com suporte.";
                return view('chat.analist.message',
                            compact('message'));
            }
        }
        
        return view('chat.analist.analist', 
                    compact('myData', 'token'));
    }
    
    public function analistLogin()
    {
        // echo "Ok2";
        return view('chat.analist.login');
    }

    
    public function authenticate(Request $request,
                                Authenticate $authenticate,
                                AnalistService $analistService)
    {
        $data = $request->all();
        
        $authenticate->setLogin($data['login3']);
        $authenticate->setPass($data['password3']);

        $token = $authenticate->verify();
        if (!$token) {
            return redirect()
                            ->back()
                            ->withErrors(['Senha ou usuaio invalido']);
        }

        // $stateT = $request->session()->get('stateT');
        // $request->session()->put('stateT', 26);
        
        $token = json_decode($token);
        $request->session()->put('myToken', $token->token);

        $analistData = $analistService->getData();

        if (!$analistData) {
            return redirect()
                            ->back()
                            ->withErrors(['Ocorreu algum problema com seus dados, entre em contato com o suporte']);
        }

        $analistData = json_decode($analistData);
        $request->session()->put('myData', $analistData);
        
        return redirect()->route('chat.analist', $analistData->slug);
    }
}
