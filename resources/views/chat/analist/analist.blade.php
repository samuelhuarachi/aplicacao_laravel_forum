@extends('chat.analist.base')

@section('content')

<div class="container">
    <div class="row">
        <div id="full-menu" class="col-md-12 mb-3">
            <div id="menu-area">
                <div id="logo-live">Boneca Forum - Cam stream</div>
                <button class="btn btn-danger btn-sm">Sair</button>
                <button class="btn btn-danger btn-sm">Estatística</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <div id="analist-header">
                <h2 class="float-left">{{ $myData->name }} {{ $myData->lastname }}</h2>

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

                <video id="analistVideo" autoplay muted></video>

            </div>
        </div>
    </div>
    <div class="row">
        <div  class="col-md-12 mb-3">
            <div id="statistic">
                <h2>Dados</h2>
                <p>
                    <small id="socketOnlineClients">0 usuários online</small>
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
            Enviar</button> 
    </div>
</div>

@endsection

@section('analist')
<script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.5/socket.io.min.js"></script>

<script src="{{ asset('js/peerAnalist.js') }}"></script>

<script type="text/javascript">
    let token = '{{ $token }}'
    let slug = '{{ $myData->slug }}'
    const analistName = '{{ $myData->name }}'
    const analistLastname = '{{ $myData->lastname }}'
</script>

@endsection