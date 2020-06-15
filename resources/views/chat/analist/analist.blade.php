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

                <a href="{{ route('chat.analist.logout') }}" 
                    class="btn btn-primary btn-sm float-right">Sair</a>

                {{-- <a id="btnShowSessionsMenu"
                    class="btn btn-primary btn-sm float-right">Sessões</a> --}}
                <a target="_blank"
                    href="{{ route('chat.analist.report') }}"
                    class="btn btn-primary btn-sm float-right">Relatorio de Ganhos</a>

                <a id="btnChallenge"
                    class="btn btn-primary btn-sm float-right">Proposta</a>
                
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-4">
            <div id="analist-header">

                <div>
                    <h2>{{ $myData->name }} {{ $myData->lastname }}</h2>
                    
                </div>
                
                <div class="float-right">
                    <b>Ganhos:</b> {{ round($myData->gains, 2) }} <i class="fas fa-coins"></i>
                   
                </div>
            </div>
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="live-info">
               

                <div id="challengeInfo" class="column80 mb-3"></div>

                <div id="challenge_control_waiting" class="column80 mb-3">
                    <button id="btn_challenge_accept" class="btn btn-sm btn-outline-success">Aceitar oferta <i class="fas fa-check"></i></button>
                    <button id="btn_challenge_cancel" class="btn btn-sm btn-outline-danger float-right">Cancelar <i class="fas fa-times"></i></button>
                </div>

                <div id="challenge_control_finalize" class="column80 mb-3">
                    <button id="btn_challenge_finallize" 
                            class="btn btn-sm btn-outline-primary">
                                Finalizar <i class="far fa-calendar-check"></i></button>
                </div>

                <span id="session_cost_aproximate"></span>
                <span id="time_aproximate" class="ml-3"></span>

                <div class="float-right">
                    <img width="10" src="{{ asset('images/green.png') }}" alt="">
                    <small>Live</small>
                </div>
            </div>
        </div>
        <div class="col-md-12 mb-3">
            
            <div class="workspace">
                <video id="analistVideo" playsinline autoplay muted></video>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- <input type="checkbox" data-toggle="toggle" data-size="sm"> -->

            <input id="btnOnOff"
                    type="checkbox"
                    id="onOff" 
                    name="onOff"> <label for="btnOnOff">Online/Offline</label>

            <input id="optionAlertWhenNewClientComming"
                    type="checkbox" 
                    class="ml-3"
                    id="scales" 
                    name="scales" > <label for="optionAlertWhenNewClientComming">Avisar <i class="fas fa-volume-up"></i></label>

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

<div class="chat">
    <div id="history-messages" class="history"></div>
    <div class="message">
        <small>Digite sua mensagem</small>
        <textarea id="txtAreaMessage" name="textarea"></textarea>
        <button id="btnSend" class="btn btn-sm btn-primary" type="button">
            Enviar</button>
    </div>
</div>


@include('chat.analist.modal.sessions')
@include('chat.analist.modal.modalChallenge')


@endsection

@section('analist')
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.5/socket.io.min.js"></script>
<script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

<script type="text/javascript">
    const BASEURL = '{{ env("NODEAPI") }}';
    let token = '{{ $token }}'
    let slug = '{{ $myData->slug }}'
    const analistName = '{{ $myData->name }}'
    const analistLastname = '{{ $myData->lastname }}'
    let socket = null
    let globalQuantityOnlineClients = 0

    let analistPricePerHourGlobal = {{ $myData->pricePerHour }}
    
    let challengeDataGlobal
    @if(isset($challengeActive))
        challengeDataGlobal = JSON.parse('{!! $challengeActive !!}')
    @else
        challengeDataGlobal = null
    @endif
</script>
<script src="{{ asset('js/peerAnalist.js') }}"></script>

@endsection
