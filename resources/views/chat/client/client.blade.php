@extends('chat.client.base')

@section('content')


<div class="container">
    <div class="row">
        <div id="full-menu" class="col-md-12 mb-3">
            <div id="menu-area">
                <div id="logo-live"><i style="margin-right: 10px;" class="fas fa-stream"></i> Boneca Forum - Cam stream</div>
                <!-- <button class="btn btn-danger btn-sm">Sair</button> -->
                <button id="btnCredits" class="btn btn-danger btn-sm"><i class="fas fa-coins"></i> Creditos</button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-3">
            <h2 class="float-left">safsafdsaf</h2>
        </div>
        <div class="col-md-12">
            <div id="analist-header">
                
            <i class="fas fa-video"></i>
               
                <div class="float-right" id="live-info">
                    <img width="10" src="{{ asset('images/green.png') }}" alt=""> 
                        <small>Live</small>
                </div>
                
            </div>
        </div>
    </div>

    <div class="row">
        <div  class="col-md-12 mb-3">
            
            <div class="workspace">

                <video id="friendsVideo" autoplay></video>

            </div>
        </div>
    </div>

    <div class="row">
        <div  class="col-md-12 mb-3">
            <div id="statistic">
                <h2>Dados</h2>
                <p>
                    sdafsafdsafds
                </p>
            </div>
        </div>
    </div>

</div>




<div class="chat">
    <div id="history-messages" class="history">
        <!-- <div id="history-messages">
            sdfsafdsaf <br>
            sadfsafa
        </div> -->
    </div>
    <div class="message">
        <small>Digite sua mensagem</small>
        <textarea id="txtAreaMessage" name="textarea"></textarea>
        <button id="btnSend" class="btn btn-sm btn-primary" type="button">
            <i class="fas fa-th"></i> Enviar</button> 
    </div>
</div>




@endsection

@section('client')

<script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
<script src="{{ asset('js/peerClient.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/fontawesome.min.js"></script>

@endsection