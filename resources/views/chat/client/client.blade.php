@extends('chat.client.base')

@section('head')

@endsection

@section('content')

<div class="container">
    <div class="row">
        <div id="full-menu" class="col-md-12 mb-3">
            <div id="menu-area">
                <div id="logo-live"><i style="margin-right: 10px;" class="fas fa-stream"></i> Boneca Forum - Cam stream</div>
                
                <button id="btnCredits" class="btn btn-danger btn-sm" 
                            data-toggle="tooltip" data-placement="bottom" 
                            title="Ao adicionar crédito, voce podera iniciar uma sessao privada. Os creditos serao descontados proporcionalmente ao tempo permanecido, de acordo com o valor/hora da garota.">
                    <i class="fas fa-coins"></i> Créditos <i class="fas fa-plus"></i></button>

                @if($tokenClient)
                <button id="btnClientAccount" type="button" class="btn btn-link btn-sm">
                    <i class="fas fa-address-card"></i> Minha Conta</button>

                <button id="btnLogoutClient" class="btn btn-link btn-sm">
                    <i class="fas fa-power-off"></i> Sair</button>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="column80">
                @if ($tokenClient && isset($reponseAuthClient) && $reponseAuthClient->email_verified == false)
                    @include('chat.client.components.messages.verifiedemail')
                @endif
                @if($tokenClient && isset($reponseAuthClient) && $reponseAuthClient->nickname)
                <small>Nickname: {{ $reponseAuthClient->nickname }}</small> <br>
                <small>E-mail: {{ $reponseAuthClient->email }}</small> <br>
                <br>
                @endif

                <h2 class="float-left">{{ $analistExists->name }} {{ $analistExists->lastname }}</h2>
            </div>
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

    <!-- <div class="row">
        <div  class="col-md-12 mb-3">
            <div id="statistic">
                <h2>Dados</h2>
                <p>
                    sdafsafdsafds
                </p>
            </div>
        </div>
    </div> -->

</div>


<div class="chat">
    <div id="history-messages" class="history"></div>
    <div class="message">
        <small>Digite sua mensagem</small>
        <textarea id="txtAreaMessage" name="textarea"></textarea>
        <button id="btnSend" class="btn btn-sm btn-primary" type="button">
            <i class="fas fa-th"></i> Enviar</button> 
    </div>
</div>


@if(!$tokenClient)
    @include('chat.client.components.modal.registerandlogin')
@endif

@if($tokenClient)
    @include('chat.client.components.modal.account')

    @if($tokenClient && isset($reponseAuthClient) && $reponseAuthClient->email_verified == true)
    <div class="modal fade" id="modalAddCredits" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    
                    <div class="row creditsvaluesbox">
                            <div class="col-sm text-center">
                                <span class="creditvalue">10</span> <i class="fas fa-coins"></i>
                                <br>
                                <button data-value="10" class="btnPayment btn btn-success btn-sm">
                                    Comprar</button>
                            </div>
                            <div class="col-sm text-center">
                                <span class="creditvalue">20</span> <i class="fas fa-coins"></i>
                                <br>
                                <button data-value="20" class="btnPayment btn btn-success btn-sm">
                                        Comprar</button>
                            </div>
                            <div class="col-sm text-center">
                                <span class="creditvalue">30</span> <i class="fas fa-coins"></i>
                                <br>
                                <button data-value="30" class="btnPayment btn btn-success btn-sm">
                                    Comprar</button>
                            </div>
                    </div>
                    <div class="row creditsvaluesbox">
                        <div class="col-sm text-center">
                            <span class="creditvalue">50</span> <i class="fas fa-coins"></i>
                            <br>
                            <button data-value="50" class="btnPayment btn btn-success btn-sm">
                                Comprar</button>
                        </div>
                        <div class="col-sm text-center">
                            <span class="creditvalue">100</span> <i class="fas fa-coins"></i>
                            <br>
                            <button data-value="100" class="btnPayment btn btn-success btn-sm">
                                Comprar</button>
                        </div>
                        <div class="col-sm text-center">
                            <span class="creditvalue">200</span> <i class="fas fa-coins"></i>
                            <br>
                            <button data-value="200" class="btnPayment btn btn-success btn-sm">
                                Comprar</button>
                        </div>
                    </div>
                    <div class="row creditsvaluesbox">
                        <div class="col-sm text-center">
                            <span class="creditvalue">300</span> <i class="fas fa-coins"></i>
                            <br>
                            <button data-value="300" class="btnPayment btn btn-success btn-sm">
                                Comprar</button>
                        </div>
                        <div class="col-sm text-center">
                            <span class="creditvalue">400</span> <i class="fas fa-coins"></i>
                            <br>
                            <button data-value="400" class="btnPayment btn btn-success btn-sm">
                                Comprar</button>
                        </div>
                        <div class="col-sm text-center">
                            <span class="creditvalue">600</span> <i class="fas fa-coins"></i>
                            <br>
                            <button data-value="600" class="btnPayment btn btn-success btn-sm">
                                Comprar</button>
                        </div>
                    </div>
                    <div class="row creditsvaluesbox">
                        <div class="col-sm text-center">
                            <span class="creditvalue">1000</span> <i class="fas fa-coins"></i>
                            <br>
                            <button data-value="1000" class="btnPayment btn btn-success btn-sm">
                                Comprar</button>
                        </div>
                        <div class="col-sm text-center">
                            <span class="creditvalue">2000</span> <i class="fas fa-coins"></i>
                            <br>
                            <button data-value="2000" class="btnPayment btn btn-success btn-sm">
                                Comprar</button>
                        </div>
                        <div class="col-sm text-center">
                            <span class="creditvalue">3000</span> <i class="fas fa-coins"></i>
                            <br>
                            <button data-value="3000" class="btnPayment btn btn-success btn-sm">
                                Comprar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    {!! Form::open([
                        'route' => 'chat.client.payment',
                        'id' => 'client-payment-form',
                        'method' => 'post'])
                    !!}
                    <div class="row">
                        
                        <div  class="col">
                            <img class="float-right" width="30" id="card_image" src="{{ asset('images/creditcard/mastercard.png') }}" alt="">
                            
                            <div class="form-group">
                                <label for="card_number">Número do Cartão</label>
                                <input value="4563 5612 8336 2889" class="form-control" name="card_number" placeholder="1234 5678 9012 3456" id="card_number" type="text">
                                <input class="form-control" name="card_brand" id="card_brand" type="hidden">
                            </div>
                        </div>

                        <div  class="col">
                                
                            <div class="form-group">
                                <label for="card_expire">Data de expiração</label>
                                <input value="10/25" class="form-control" id="card_expire" name="card_expire" placeholder="mm/yy" type="text">

                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div  class="col">
                            <div class="form-group">
                                <label for="card_cvv">CVV</label>
                                <input value="568" class="form-control" id="card_cvv" name="card_cvv" placeholder="123" type="text">
                            </div>
                        </div>


                        <div  class="col">
                            <div class="form-group">
                                <label for="card_name">Nome Impresso no Cartão</label>
                                <input value="Sarah Daniel" class="form-control" name="card_name" type="text">

                            </div>
                        </div>
                    </div>
                    <div class="row">     

                        <div  class="col-md-6">
                                <div class="form-group">
                                    <label for="card_cpf">CPF</label>
                                    <input id="card_cpf" 
                                    value="694.196.350-66"
                                    class="form-control"
                                    name="card_cpf" 
                                    placeholder="132.456.789-01" 
                                    type="text">
                                </div>
                        </div>


                        <div  class="col-md-6">
                                <div class="form-group">
                                    <label for="card_birthday">Data aniversário</label>
                                    <input id="card_birthday" 
                                    value="21/06/1987"
                                    class="form-control"
                                    name="card_birthday" 
                                    placeholder="dd/mm/yyyy" 
                                    type="text">
                                </div>
                        </div>

                        <input id="client_token" name="client_token" type="hidden">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button 
                                id="completeOrder"
                                type="button"
                                class="btn btn-danger btn-sm">
                                Comprar</button>
                            <div class="float-right" id="final-value"></div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    @endif
@endif

@endsection

@section('client')


@include('chat.client._setupjavascript')

@endsection