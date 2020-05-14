<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Samuel\Chat\Authenticate;
use App\Samuel\Chat\AnalistService;
use Session;
use App\Samuel\Chat\ClientService;
use App\Samuel\Chat\Client\Auth as AuthClient;
use App\Samuel\PagseguroService;

class ClientController extends Controller
{

    public function authClient($token, AuthClient $authClient)
    {
        $response = $authClient->authByToken($token);
        if (!$response) {
            abort(403, 'Token inválido');
        }

        $clientData = json_decode($response);
        Session::put('clientToken', $clientData->token);


        // Session::flash('flash_message','Cadastro realizado com 
        //         sucesso. Nao esqueca de verificar seu e-mail');


        return redirect()->route('chat');
    }

    public function emailVerified($nickname, $email_token, 
                ClientService $clientService)
    {
        
        $response = $clientService->verifiedEmail($nickname, $email_token);

        if (!$response) {
            return redirect()
                        ->route('chat')
                        ->withErrors(['Erro na verificacao do e-mail, entre em contato com o suporte']);
        }

        Session::flash('flash_message','E-mail verificado');
        return redirect()->route('chat');
    }

    public function forgotEmail($nickname, $token)
    {
        
        return view('chat.client.redefine-password', 
                        compact('nickname', 
                                    'token'));
    }

    public function logout()
    {
        Session::forget('clientToken');
        return redirect()->route('chat');
    }

    public function resendVerifiedMail($token, 
                    ClientService $clientService)
    {

        $response = $clientService->sendVerifiedEmailWithToken($token);
        if (!$response) {
            return redirect()
                        ->route('chat')
                        ->withErrors(['Erro no envio do e-mail de verificacao, entre em contato com o suporte']);
        }

        Session::flash('flash_message','E-mail de verificacao enviado');
        return redirect()->route('chat');
    }

    public function payment(Request $request, 
                    PagseguroService $pagseguroService,
                    ClientService $clientService)
    {
        $data = $request->all();
        $clientToken = $data['client_token'];

        $response = $clientService->getDataByToken($clientToken);
        
        if (!$response) {
            return redirect()
                    ->route('chat')
                    ->withErrors(['Usuário não encontrado. Caso continue tendo problema com o pagamento enviar um e-mail para ' . env('SUPPORT_EMAIL')]);
        }

        $userData = \json_decode($response);

        /**
         * crio uma ordem na api do pagseguro
         */
        $responsePagseguroService = $pagseguroService->newOrder($data, $userData);
        
        $info = $responsePagseguroService["info"];
        $responsePagseguro = json_decode($responsePagseguroService["response"]);
        
        if ($info["http_code"] !== 201) {
            $errorPagseguroMessage = "";
            if (isset($responsePagseguro->error_messages)) {
                foreach($responsePagseguro->error_messages as $message) {
                    $code = $message->code;
                    $description = $message->description;
                    $parameter_name = $message->parameter_name;
                    $errorPagseguroMessage = $errorPagseguroMessage . 
                    $code . " " . $description. " " . $parameter_name . " * ";
                }
            }
            
            return redirect()
                    ->route('chat')
                    ->withErrors([$errorPagseguroMessage . 
                            'Caso continue tendo problema com o pagamento 
                            enviar um e-mail para ' . 
                            env('SUPPORT_EMAIL')]);
        }

        /**
         * registra a ordem na minha api
         */
        $registerNew = $pagseguroService->registerNewOrderInApi($clientToken, $responsePagseguroService["response"]);

        // dump($responsePagseguroService["response"]);

        Session::flash('flash_message','Obrigado pela sua transacao. Ela sera creditada, assim que recebermos a confirmacao. Voce podera acompanhar o status dela em "transacoes" no menu. Caso tenha algum problema, com alguma transacao, enviar um email para o suporte ' . env('SUPPORT_EMAIL'));
        return redirect()->route('chat');
    }

    public function transactions(
                AuthClient $authClient,
                ClientService $clientService)
    {
        $token = Session::get('clientToken');
        $tokenClient = Session::get('clientToken');

        $reponseAuthClient = $authClient->authByToken($token);
        if (!$reponseAuthClient) {
            return abort(403, 'Voce nao esta autenticado');
        }

        $transactions = $clientService->getTransactionsByToken($token);
        
        if ($transactions) {
            $transactionsJson = json_decode($transactions);
        }   
        
        $reponseAuthClient = json_decode($reponseAuthClient);
        return view('chat.client.transactions',
                        compact('transactionsJson', 
                                'tokenClient', 'reponseAuthClient'));
    }
}




