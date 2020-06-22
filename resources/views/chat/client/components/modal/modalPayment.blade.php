<div class="modal fade" id="modalPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                {!! Form::open([
                'route' => 'chat.client.payment',
                'id' => 'client-payment-form',
                'method' => 'post'])
                !!}
                <div class="row">
                    <div class="col-md-12">
                        <h3>Dados do Cartão</h3>
                    </div>
                    <div class="col">
                        <img class="float-right" width="30" id="card_image"
                            src="{{ asset('images/creditcard/mastercard.png') }}" alt="">

                        <div class="form-group">
                            <label for="card_number">Número do Cartão</label>
                            <input class="form-control" name="card_number"
                                placeholder="1234 5678 9012 3456" id="card_number" type="text">
                            <input class="form-control" name="card_brand" id="card_brand" type="hidden">
                        </div>
                    </div>

                    <div class="col">

                        <div class="form-group">
                            <label for="card_expire">Data de expiração</label>
                            <input class="form-control" id="card_expire" name="card_expire"
                                placeholder="mm/yy" type="text">

                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col">
                        <div class="form-group">
                            <label for="card_cvv">CVV</label>
                            <input class="form-control" id="card_cvv" name="card_cvv" placeholder="123"
                                type="text">
                        </div>
                    </div>


                    <div class="col">
                        <div class="form-group">
                            <label for="card_name">Nome Impresso no Cartão</label>
                            <input id="card_name" class="form-control" name="card_name" type="text">

                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="card_cpf">CPF</label>
                            <input id="card_cpf" class="form-control" name="card_cpf"
                                placeholder="132.456.789-01" type="text">
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="card_birthday">Data aniversário</label>
                            <input id="card_birthday" class="form-control" name="card_birthday"
                                placeholder="dd/mm/yyyy" type="text">
                        </div>
                    </div>

                    <input id="client_token" name="client_token" type="hidden">
                    <input id="credits_total" name="credits_total" type="hidden">

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button id="completeOrder" type="button" class="btn btn-primary btn-sm">
                            Adquirir créditos</button>
                        <div id="div-message-creditcard-client" class="message_error_bf"></div>
                        <div class="float-right" id="final-value"></div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>