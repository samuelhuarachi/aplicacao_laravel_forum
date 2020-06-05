@extends('chat.base')

@section('content')

@include('_message-success')
@include('_message-error2')
@if ($tokenClient && isset($reponseAuthClient) && $reponseAuthClient->email_verified == false)
    @include('chat.client.components.messages.verifiedemail')
@endif



@include('chat.client._menu')

<div class="container">
    <div class="row">

        <div id="header-camstream">
            <h1>Garotas ao vivo na webcam (em breve)</h1>
        </div>

        <div class="col-md-12">
            <br>
            <center>
                Confiras as melhores garotas da BonecaForum/GarotaForum CamStream
            </center>

            <ul class="nav nav-tabs mb-3">
                <li class="nav-item">
                    <a id="btn_woman_list" class="nav-link active">
                        Mulheres</a>
                </li>
                <li class="nav-item">
                    <a id="btn_tranny_list" class="nav-link" >
                        Transex <i class="fas fa-transgender"></i></a>
                </li>
            </ul>
    
            <div id="woman_list">

            
                @foreach($analists as $analist)

                    @if ($onlineAnalists && isset($onlineAnalists[$analist->slug]))
                        @php
                            $online = true
                        @endphp
                    @else
                        @php
                            $online = null
                        @endphp
                    @endif

                    <figure class="figure">
                        <a href="{{ route('chat.client', $analist->slug) }}">
                            @if($online)
                                <div class="onlineFlag">
                                    Online <span><i id="live-circle" class="fas fa-circle"></i></span>
                                </div>
                            @else
                                <div class="onlineFlag">
                                    Offline <span><i id="off-circle" class="fas fa-circle"></i></span>
                                </div>
                            @endif
                            <img 
                                width="150" 
                                src="{{ asset('images/modelos/' . $analist->photo) }}" 
                                class="figure-img img-fluid"
                                alt="">
                            
                            <figcaption class="figure-caption">{{ $analist->name }} {{ $analist->lastname }}</figcaption>
                        </a>
                    </figure>
                @endforeach
            </div>
            <div id="tranny_list">
                Não encontramos nenhuma no momento
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




@if(!$tokenClient)
    @include('chat.client.components.modal.registerandlogin')
    @include('chat.client.components.modal.forgotPassword')
    
@endif

@if($tokenClient)
    @include('chat.client.components.modal.account')
@endif

@if($tokenClient && isset($reponseAuthClient) && $reponseAuthClient->email_verified == true)
    @include('chat.client.components.modal.modalAddCredits')
    @include('chat.client.components.modal.modalPayment')
    @include('chat.client.components.modal.modalTransactions')
    @include('chat.client.components.modal.modalSessions')
@endif

<style>
#menu-area {
    width: 100%;
}
</style>

@endsection


@section('client')

@include('chat.client._setupjavascript')

@endsection