<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Samuel\Chat\Authenticate;
use App\Samuel\Chat\AnalistService;
use Session;
use App\Samuel\Chat\ClientService;
use App\Samuel\Chat\Client\Auth as AuthClient;

class ChatController extends Controller
{
    
    public function client($slug, 
                ClientService $clientService,
                AuthClient $authClient)
    {
        $tokenClient = Session::get('clientToken');

        /**
         * Verifica se o slug existe
         */
        $analistExists = $clientService->getAnalistBySlug($slug);
        if (!$analistExists)
            abort(404);

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
                    // return view('chat.analist.message',
                    //             compact('message'));

                Session::flash('flash_message', $message);
                return redirect()->route('chat');
            }
        }

        
        
        $isAvailable = $clientService->checkRoomIsAvailable($slug);
        if (!$isAvailable) {
            $message = '<i class="fas fa-exclamation"></i> Parece que a modelo não está mais online <i class="far fa-sad-cry"></i>';
            Session::flash('flash_message', $message);
                return redirect()->route('chat');
        }

        
        $reponseAuthClient = null;
        $analistExists = json_decode($analistExists);
        
        if (!$tokenClient) {
            $tokenClient = null;
        } else {
            $reponseAuthClient = $authClient->authByToken($tokenClient);
            if (!$reponseAuthClient) {
                abort(403, 'Token inválido');
            }
            
            $reponseAuthClient = json_decode($reponseAuthClient);

            return view('chat.client.client', 
                        compact('tokenClient', 
                                    'reponseAuthClient', 'analistExists'));
        }

        
        return view('chat.client.client', compact('tokenClient', 'analistExists'));
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

        /**
         * revisar esse codigo abaixo
         */
        // if ($analistFind) {
        //     $analistFind  = json_decode($analistFind);
        //     if ($analistFind->findAnalist) {
        //         $message = "Identificamos que existe uma sessão aberta para você. 
        //         <br>Caso não consiga solucionar o problema, entrar em contato com suporte.";
        //         return view('chat.analist.message',
        //                     compact('message'));
        //     }
        // }
        
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

    public function chat(ClientService $clientService,
                    AuthClient $authClient)
    {
        $analists = json_decode($clientService->getAllAnalists());
        
        $tokenClient = Session::get('clientToken');
        $reponseAuthClient = null;
        
        if (!$tokenClient) {
            $tokenClient = null;
        } else {
            $reponseAuthClient = $authClient->authByToken($tokenClient);
            if (!$reponseAuthClient) {
                return abort(403, 'Token inválido');
            }
            
            $reponseAuthClient = json_decode($reponseAuthClient);

            
            return view('chat.chat', 
                        compact('tokenClient', 
                                    'reponseAuthClient', 'analists'));
        }

        return view('chat.chat', compact('analists','tokenClient', 
                                            'reponseAuthClient'));
    }
}
