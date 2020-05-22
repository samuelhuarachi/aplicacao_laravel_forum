<div class="modal fade" id="forgotPassword" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div id="form-forgot-message"></div>
                <div id="form-forgot-content">
                    <h3>Esqueci minha senha</h3>
                    <a id="linkForgotPasswordBack"><i class="fas fa-long-arrow-alt-left"></i> Voltar</a>
                    <br>
                    <br>
                    <p>Preencha seu e-mail abaixo, que enviaremos o link para
                        redefinição no seu e-mail</p>

                    <input class="form-control" type="email" id="inputForgotEmail">
                    <br>
                    <div class="googleRecaptcha" id="recaptchaForgotLogin"></div>
                    <button id="btnForgotLogin" type="button" class="btn btn-sm btn-danger">
                        Enviar link de verificacao
                        <i class="fas fa-paper-plane"></i></button>

                    <div id="div-message-forgot-login-client"></div>
                </div>
            </div>
        </div>
    </div>
</div>
