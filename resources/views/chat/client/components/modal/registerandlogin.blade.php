<div class="modal fade" id="modalLoginOrRegisterHTML" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <div class="modal-body">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <div class="row">
                    <div  class="col-md-6">
                        <h3>Login</h3>
                        <div >
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

                                <div class="googleRecaptcha" id="recaptchaLogin"></div>
                                <button id="btnLoginClient" type="button" 
                                    class="btn btn-sm btn-primary">
                                        Login</button>
                            
                                <div id="div-message-login-client" class="message_error_bf"></div>

                                <a id="linkForgotPassword" href="#">Esqueci minha senha</a>
                            </form>
                        </div>
                    </div>
                    <div  class="col-md-6">
                        <h3>Novo Usuário</h3>
                        <div>
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
                                
                                <div class="googleRecaptcha" id="recaptchaRegister"></div>

                                <p style="margin-bottom: 5px; margin-top: -11px;">
                                    Estou de acordo com os 
                                    <a style="color:blue" 
                                        href="{{ route('chat.termos_de_uso') }}">Termos de Uso</a></p>
                                
                                <button id="registerNewClient" type="button" 
                                    class="btn btn-sm btn-primary"
                                    >
                                   Registrar</button>

                                
                                <div id="div-message-register-new-client" class="message_error_bf"></div>
                            </form>
                        </div>
                    </div> 
                </div>
      </div>
    </div>
  </div>
</div>