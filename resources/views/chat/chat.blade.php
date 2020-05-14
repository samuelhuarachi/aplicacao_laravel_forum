@extends('chat.base')

@section('content')

@include('chat.client._menu')

<div class="container">
    <div class="row">
        <div class="col-md-12">

            @include('_message-success')
            @include('_message-error2')
            @if ($tokenClient && isset($reponseAuthClient) && $reponseAuthClient->email_verified == false)
                @include('chat.client.components.messages.verifiedemail')
            @endif
            <br>
            <center>
                <h1>Garotas</h1>
                <br>
                Confiras as melhores garotas da BonecaForum/GarotaForum CamStream
            </center>
            <hr>
            
            <div>
                @foreach($analists as $analist)

                    <figure class="figure">
                        <a href="{{ route('chat.client', $analist->slug) }}">
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