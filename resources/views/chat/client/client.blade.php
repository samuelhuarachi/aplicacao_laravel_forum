@extends('chat.client.base')

@section('head')

@endsection

@section('content')

<div id="message-default-client" class="alert alert-info" role="alert"></div>


@include('chat._message-toast')

@include('chat.client._menu')

<div class="container">

    <div class="row">
        <div class="col-md-12 mt-3">
            <div class="column80">

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
            <div id="challengeInfo" class="column80 mb-3"></div>
            <div id="analist-header">
                

                <div class="float-right" id="live-info">
                    <i id="live-circle" class="fas fa-circle"></i>
                    Live
                </div>

                @if($tokenClient && isset($reponseAuthClient) && $reponseAuthClient->nickname)
                <div id="client-info-panel">

                    <span><i class="fas fa-user mr-1"></i> {{ $reponseAuthClient->nickname }}</span>
                    <span id="creditsTopStreamVideo" class="ml-3"><i class="fas fa-donate mr-1"></i>
                        {{ number_format($reponseAuthClient->credits, 2) }}</span>
                    <span id="session_cost_aproximate" class="ml-3"></span>
                    <span id="time_aproximate" class="ml-3"></span>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 ">
            <div class="workspace">

                <img id="playImage" src="{{ asset('images/play2.png') }}" alt="">

                <video id="friendsVideo" playsinline autoplay></video>

                <!-- <video preload="none" 
                autoplay="" 
                id="videoView"
                playsinline=""
                 webkit-playsinline="" 
                 wmode="opaque" 
                 src="" class=""></video> -->
            </div>
        </div>
        
        <div class="col-md-12 mt-1">
            <div class="mb-3">
                <button data-value=10 class="btn btn-outline-dark btnGift">enviar 10 <i class="fas fa-coins"></i></button>
                <button data-value=20 class="btn btn-outline-dark btnGift">enviar 20 <i class="fas fa-coins"></i></button>
                <button data-value=30 class="btn btn-outline-dark btnGift">enviar 30 <i class="fas fa-coins"></i></button>
                <button data-value=50 class="btn btn-outline-dark btnGift">enviar 50 <i class="fas fa-coins"></i></button>
                <button data-value=100 class="btn btn-outline-dark btnGift">enviar 100 <i class="fas fa-coins"></i></button>
                <button data-value=200 class="btn btn-outline-dark btnGift">enviar 200 <i class="fas fa-coins"></i></button>
                <button class="btn btn-outline-dark btnGift">Outro valor <i class="fas fa-coins"></i></button>
            </div>
            
            <div class="column80">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a id="cam_girl_description_link" class="nav-link active" ><i class="fas fa-address-card"></i> Sobre mim</a>
                    </li>
                    <li class="nav-item">
                        <a id="cam_girl_photos_link" class="nav-link" ><i class="fas fa-camera-retro"></i> Fotos</a>
                    </li>
                    <li class="nav-item">
                        <a id="cam_girl_videos_link" class="nav-link" ><i class="fas fa-film"></i> Videos</a>
                    </li>
                </ul>
                <br>
                <div id="cam_girl_description">
                    @if(isset($analistExists) && isset($analistExists->description))

                    {!! $analistExists->description !!}

                    @endif
                </div>
                <div id="cam_girl_photos">

                    @if(isset($analistExists) && isset($analistExists->gallery))
                        @foreach($analistExists->gallery as $urlPhoto)

                        <a 
                            data-caption="Fotos da camgirl {{ $analistExists->name }} {{ $analistExists->lastname }}"
                            data-fancybox="gallery" href="{{ $urlPhoto }}">
                            <img class="image-in-gallery" src="{{ $urlPhoto }}" alt="">
                        </a>
                        @endforeach
                    @endif    
                    
                   
                </div>
                <div id="cam_girl_videos">
                    A garota não postou videos até o momento
                </div>

                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                
            </div>

        </div>
    </div>
</div>


<div id="primary_chat" class="chat">
<button id="btnMaximizeChat" class="btn btn-primary btn-xs float-right">
            Maximizar <i class="fas fa-expand-alt"></i></button>
    <button id="btnMinimizeChat" class="btn btn-primary btn-xs float-right">
            Minimizar <i class="fas fa-compress-alt"></i></button>
    <div style="clear:both;"></div>
    <div id="history-messages" class="history"></div>
    <div class="message">
        Digite sua mensagem
        <textarea id="txtAreaMessage" name="textarea"></textarea>
        <button id="btnSend" class="btn btn-sm btn-primary" type="button">
            Enviar <i class="fas fa-paper-plane"></i></button>
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
