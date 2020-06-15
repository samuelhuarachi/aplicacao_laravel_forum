<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Samuel\Chat\Authenticate;
use App\Samuel\Chat\AnalistService;
use Session;
use App\Samuel\Chat\ClientService;
use App\Samuel\Chat\Client\Auth as AuthClient;
use Twilio\Rest\Client;

class ChatController extends Controller
{
    
    public function client($slug, 
                ClientService $clientService,
                AuthClient $authClient)
    {
        $tokenClient = Session::get('clientToken');

        /**
         * valida o usuario
         */
        $reponseAuthClient = null;
        if ($tokenClient) {
            $reponseAuthClient = $authClient->authByToken($tokenClient);
            if (!$reponseAuthClient) {
                Session::forget('clientToken');
                return redirect()->route('chat');
            }
            $reponseAuthClient = json_decode($reponseAuthClient);
        }

        /**
         * Verifica se o slug existe
         */
        $analistExists = $clientService->getAnalistBySlug($slug);
        if (!$analistExists)
            abort(404);

        
        $analistExists = json_decode($analistExists);

        /**
         * acesso com o analista offline
         */
        $isAvailable = $clientService->checkRoomIsAvailable($slug);
        if (!$isAvailable) {
            $dataChallenge = null;
            return view('chat.client.client', 
                        compact(    'tokenClient', 
                                    'reponseAuthClient', 
                                    'isAvailable',
                                    'analistExists', 
                                    'dataChallenge'));
        }

        /**
         * verifica se a analista esta em sessao privada
         */
        $isAnalistInPrivateSession = $clientService->isAnalistInPrivateSession($slug);
        if (!$tokenClient && $isAnalistInPrivateSession) {
            Session::flash('flash_message', '<i class="fas fa-exclamation"></i> A garota esta em uma sessão privada no momento');
            return redirect()->route('chat');
        }
        

        /**
         * verifica se voce ja tem um sessao ativa com esse analista
         */
        if ($tokenClient) {
            $checkActiveRoom = $clientService->checkActiveRoom($tokenClient, $slug);
            if ($checkActiveRoom) {
                $message = '<i class="fas fa-exclamation"></i> Identificamos que já existe uma sessao ativa para essa modelo. Caso o problema persista, entre em contato com o suporte atraves do e-mail: ' . env('SUPPORT_EMAIL');
                
                Session::flash('flash_message', $message);
                return redirect()->route('chat');
            }
        }

        

        /**
         * pegar a proposta ativa
         */
        $dataChallenge = $clientService->getChallenge($slug);
        
        if (!$tokenClient) {
            $tokenClient = null;
        } else {
            return view('chat.client.client', 
                        compact('tokenClient', 'isAvailable',
                                    'reponseAuthClient', 'analistExists', 'dataChallenge'));
        }

        return view('chat.client.client', compact(
            'isAvailable',
            'tokenClient', 'analistExists',
             'dataChallenge'));
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

        $myData = \json_decode($analistService->getData());

        $token = Session::get('myToken');

        //$analistFind = $analistService->sessionOpenedBySlug($slug);

        $challengeActive = $analistService->getChellengeActive();

        return view('chat.analist.analist', 
                    compact('myData', 'token', 'challengeActive'));
    }
    
    public function analistLogin()
    {
        // echo "Ok2";
        return view('chat.analist.login');
    }

    /**
     * autentica o analista
     */
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

    public function chat(ClientService $clientService,
                    AuthClient $authClient)
    {
        $analists = json_decode($clientService->getAllAnalists());
        $onlineAnalists = $clientService->onlineAnalists($analists);
        
        $tokenClient = Session::get('clientToken');
        $reponseAuthClient = null;
        
        if (!$tokenClient) {
            $tokenClient = null;
        } else {
            $reponseAuthClient = $authClient->authByToken($tokenClient);
            if (!$reponseAuthClient) {
                Session::forget('clientToken');
                return redirect()->route('chat');
            }
            
            $reponseAuthClient = json_decode($reponseAuthClient);
        }

        return view('chat.chat', compact('analists','tokenClient', 
                                            'reponseAuthClient', 'onlineAnalists'));
    }
}
