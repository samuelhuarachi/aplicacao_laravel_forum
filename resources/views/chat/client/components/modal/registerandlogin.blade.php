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

                                <div class="googleRecaptcha" id="recaptchaLogin"></div>
                                <button id="btnLoginClient" type="button" 
                                    class="btn btn-sm btn-danger btn-block">
                                        Login <i class="fas fa-sign-in-alt"></i></button>
                            
                                <div id="div-message-login-client"></div>

                                <a id="linkForgotPassword" href="#">Esqueci minha senha</a>
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
                                <div class="googleRecaptcha" id="recaptchaRegister"></div>
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