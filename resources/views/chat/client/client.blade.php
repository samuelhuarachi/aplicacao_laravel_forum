@extends('chat.client.base')

@section('head')

@endsection

@section('content')


@include('chat._message-toast')

@include('chat.client._menu')

<div class="container">
    
    <div class="row">
        <div class="col-md-12 mb-3 mt-3">
            <div class="column80">
                <div id="message-default-client" class="alert alert-info" role="alert"></div>
                
                <!-- se tiver token, se tiver autenticado, se tiver credito -->
                @if($tokenClient && isset($reponseAuthClient) && $reponseAuthClient->nickname &&
                $reponseAuthClient->credits > 0)
                <button id="btnPrivateSession" class="float-right">
                    Iniciar privado <i class="far fa-eye-slash"></i></button>
                @endif

                <!-- se tiver token, se tiver autenticado -->
                @if($tokenClient && isset($reponseAuthClient) && $reponseAuthClient->nickname)
                <button id="btnStopPrivateSession" class="float-right">
                    Encerrar privado</button>
                @endif

                <h2 class="mt-4">{{ $analistExists->name }} {{ $analistExists->lastname }}</h2>
                @if ($tokenClient && isset($reponseAuthClient) && $reponseAuthClient->email_verified == false)
                    <br><br>
                    @include('chat.client.components.messages.verifiedemail')
                @endif
            </div>
        </div>
        <div class="col-md-12 mt-3">
            <div id="analist-header">

                <div class="float-right" id="live-info">
                    <i id="live-circle" class="fas fa-circle"></i>
                    Live
                </div>

                @if($tokenClient && isset($reponseAuthClient) && $reponseAuthClient->nickname)
                    <div id="client-info-panel">
                        <span><i class="fas fa-user mr-1"></i> {{ $reponseAuthClient->nickname }}</span>
                        <span id="creditsTopStreamVideo" class="ml-3"><i class="fas fa-donate mr-1"></i> {{ $reponseAuthClient->credits }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 ">

            <div class="workspace">
                
                <!-- <img id="playImage" src="{{ asset('images/play2.png') }}" alt="">
                 -->
                <video 
                id="friendsVideo" 
                playsinline autoplay ></video>

                <!-- <video preload="none" 
                autoplay="" 
                id="videoView"
                playsinline=""
                 webkit-playsinline="" 
                 wmode="opaque" 
                 src="" class=""></video> -->
            </div>
        </div>
    </div>

</div>


<div class="chat">
    <div id="history-messages" class="history"></div>
    <div class="message">
        Digite sua mensagem
        <textarea id="txtAreaMessage" name="textarea"></textarea>
        <button id="btnSend" class="btn btn-sm btn-primary" type="button">
            <i class="fas fa-th"></i> Enviar</button>
    </div>
</div>


@if(!$tokenClient)
    @include('chat.client.components.modal.registerandlogin')
    @include('chat.client.components.modal.forgotPassword')
@endif

@if($tokenClient)
    @include('chat.client.components.modal.account')

    @if($tokenClient && isset($reponseAuthClient) && $reponseAuthClient->email_verified == true)
        @include('chat.client.components.modal.modalAddCredits')
        @include('chat.client.components.modal.modalPayment')
        @include('chat.client.components.modal.modalTransactions')
        @include('chat.client.components.modal.modalSessions')
    @endif
@endif




@endsection

@section('client')

@include('chat.client._setupjavascript')

@endsection
