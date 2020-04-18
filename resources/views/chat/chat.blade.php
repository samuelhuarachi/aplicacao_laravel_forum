@extends('chat.base')

@section('content')

@include('chat.client._menu')

<div class="container">
    <div class="row">
        <div  class="col-md-12">
            @if ($tokenClient && isset($reponseAuthClient) && $reponseAuthClient->email_verified == false)
                @include('chat.client.components.messages.verifiedemail')
            @endif
            <h1>Garotas</h1>
            @include('_message-success')
            @include('_message-error2')

            @foreach($analists as $analist)
                <p>
                    <center>
                        <a href="{{ route('chat.client', $analist->slug) }}">{{ $analist->name }} {{ $analist->lastname }}</a>
                    </center>
                </p>
            @endforeach
            
        </div>
    </div>
</div>


@if(!$tokenClient)
    @include('chat.client.components.modal.registerandlogin')
@endif

@if($tokenClient)
    @include('chat.client.components.modal.account')
@endif

@endsection


@section('client')

@include('chat.client._setupjavascript')

@endsection