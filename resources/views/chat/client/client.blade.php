@extends('chat.client.base')

@section('content')

<div class="container">
    <div class="row">
        <div id="full-menu" class="col-md-12 mb-3">
            <div id="menu-area">
                <div id="logo-live"><i style="margin-right: 10px;" class="fas fa-stream"></i> Boneca Forum - Cam stream</div>
                <!-- <button class="btn btn-danger btn-sm">Sair</button> -->
                <button id="btnCredits" class="btn btn-danger btn-sm" 
                            data-toggle="tooltip" data-placement="bottom" 
                            title="Ao adicionar crédito, voce podera iniciar uma sessao privada. Os creditos serao descontados proporcionalmente ao tempo permanecido, de acordo com o valor/hora da garota.">
                    <i class="fas fa-coins"></i> Créditos <i class="fas fa-plus"></i></button>
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


<!-- Modal -->
<div class="modal fade" id="modalLoginOrRegisterHTML" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <div class="modal-body">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <div class="row">
                    <div  class="col-md-6">
                        <h3>Faça o login</h3>
                        <div class="space-area">
                            <form>
                                <div class="form-group">
                                    <label for="inputEmailLogin">E-mail</label>
                                    <input class="form-control" 
                                        type="email" id="inputEmailLogin" 
                                                aria-describedby="emailHelp" 
                                                >
                                
                                </div>
                                <div class="form-group">
                                    <label for="inputPasswordLogin">Senha</label>
                                    <input class="form-control" 
                                        type="password" 
                                        id="inputPasswordLogin" 
                                        >
                                </div>

                                <div id="recaptchaLogin"></div>
                                <button id="btnLoginClient" type="button" 
                                    class="btn btn-sm btn-danger btn-block">
                                        Login <i class="fas fa-sign-in-alt"></i></button>
                            
                                <div id="div-message-login-client"></div>
                            </form>
                        </div>
                    </div>
                    <div  class="col-md-6">
                        <h3>Faça o registro</h3>
                        <div class="space-area">
                            <form id="form-register-new-client">
                                <div class="form-group">
                                    <label for="inputNicknameRegister">Nickname</label>
                                    <input class="form-control" type="text" id="inputNicknameRegister" 
                                                aria-describedby="emailHelp" 
                                                >
                                </div>
                                <div class="form-group">
                                    <label for="inputEmailRegister">E-mail</label>
                                    <input class="form-control" type="email" id="inputEmailRegister" 
                                                aria-describedby="emailHelp" 
                                                >
                                
                                </div>
                                <div class="form-group">
                                    <label for="inputPasswordRegister">Senha</label>
                                    <input class="form-control" type="password" 
                                        id="inputPasswordRegister" 
                                        >
                                </div>
                                <!-- <div class="g-recaptcha" data-sitekey="6LcSuugUAAAAACy-8wrNOLoQOLcL1cMxQScS-oeW"></div>
                                 -->
                                <div id="recaptchaRegister"></div>
                                <button id="registerNewClient" type="button" 
                                    class="btn btn-sm btn-danger btn-block"
                                    >
                                    <i class="fas fa-user-plus"></i> Registrar</button>

                                <div id="div-message-register-new-client"></div>
                            </form>
                        </div>
                    </div> 
                </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('client')

<script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="{{ asset('js/peerClient.js') }}"></script>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/fontawesome.min.js"></script>

<script>
@if($tokenClient)
const token = '{{ $tokenClient }}'
@else
const token = null
@endif
</script>

@endsection