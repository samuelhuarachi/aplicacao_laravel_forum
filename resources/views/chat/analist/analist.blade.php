@extends('chat.analist.base')

@section('content')

<audio id="alertNewClients">
  <source src="{{ asset('audio/alertnewclients.wav') }}" type="audio/wav">
  Your browser does not support the audio element.
</audio>


<div class="container">
    <div class="row">
        <div id="full-menu" class="col-md-12 mb-3">
            <div id="menu-area">
                <div id="logo-live">Boneca Forum - Cam stream</div>
                <a href="{{ route('chat.analist.logout') }}" class="btn btn-danger btn-sm float-right">Sair</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <div id="analist-header">
                <h2>{{ $myData->name }} {{ $myData->lastname }}</h2>

                <div id="analistGainsInfo">
                    Ganhos {{ round($myData->gains, 2) }} <i class="fas fa-coins"></i>
                </div>
                
                <div class="float-right" id="live-info">
                    <img width="10" src="{{ asset('images/green.png') }}" alt="">
                    <small>Live</small>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-1">

            <div class="workspace">

                <video id="analistVideo" autoplay muted></video>

            </div>

        </div>
    </div>

    
    <div class="row">
        <div class="col-md-12">
            <input id="optionAlertWhenNewClientComming" type="checkbox" id="scales" name="scales" > Avisar <i class="fas fa-volume-up"></i>

            <div id="statistic">
                <div id="control-buttons">
                    <div id="private-session-message">Você está em uma sessão privada <i class="fas fa-eye-slash"></i></div>
                    <button id="btnStopPrivateSession" class="btn btn-outline-danger btn-sm float-right">
                        Encerrar privado</button>
                </div>

                <div style="clear:both;"></div>

                <p>
                    <small id="socketOnlineClients">0 usuários online</small>
                </p>

                <div id="list-of-clients-active-in-your-chat" class="list-group"></div>

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
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.5/socket.io.min.js"></script>

<script type="text/javascript">
    const BASEURL = '{{ env("NODEAPI") }}';
    let token = '{{ $token }}'
    let slug = '{{ $myData->slug }}'
    const analistName = '{{ $myData->name }}'
    const analistLastname = '{{ $myData->lastname }}'
    let socket = null
    let globalQuantityOnlineClients = 0
</script>
<script src="{{ asset('js/peerAnalist.js') }}"></script>

@endsection
