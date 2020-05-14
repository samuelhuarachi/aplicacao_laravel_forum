@extends('chat.client.base')


@section('content')

@include('chat.client._menu')

<div class="container">
    <div class="row">
        <div class="col-sm"></div>
        <div class="col-sm">
        <br>
        <br><br>
            <h3>Redefinicao de senha</h3>
            <p>Digite abaixo sua nova senha</p>

            <form action="" autocomplete="off">
                <input class="form-control" type="password" id="inputNewPassword">

                <input type="hidden" id="nicknameHidden" name="nickname" value="{{ $nickname }}">
                <input type="hidden" id="tokenHidden" name="token" value="{{ $token }}">
                <br>
                <div id="redefinePassword"></div>
                <button id="btnRedefinePassword" type="button" 
                    class="btn btn-sm btn-danger">
                    <i class="fas fa-key"></i> Redefinir</button>

                <div id="div-message-redefine-password-client"></div>
            </form>
        </div>
        <div class="col-sm"></div>
    </div>
</div>

<style>
#menu-area {
    width: 100%;
}
</style>

@if(!isset($tokenClient) || !$tokenClient)
    @include('chat.client.components.modal.registerandlogin')
    @include('chat.client.components.modal.forgotPassword')
@endif

@if(isset($tokenClient) && $tokenClient)
    @include('chat.client.components.modal.account')

    @if($tokenClient && isset($reponseAuthClient) && $reponseAuthClient->email_verified == true)
        @include('chat.client.components.modal.modalAddCredits')
        @include('chat.client.components.modal.modalPayment')
        @include('chat.client.components.modal.modalTransactions')
    @endif
@endif


@endsection

@section('client')

    @include('chat.client._setupjavascript')

@endsection