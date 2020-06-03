<div class="modal fade" id="modalClientAccount" tabindex="-1" 
                role="dialog" 
                aria-labelledby="exampleModalLabel" 
                aria-hidden="true">
    <div  style="max-width: 380px;" class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" 
                            data-dismiss="modal" 
                            aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3>Minha Conta</h3>
                
                <div class="row">
                    <div  class="col-md-12">
                        <p>Nickname: {{ $reponseAuthClient->nickname }}</p>
                        <p>E-mail: {{ $reponseAuthClient->email }}</p>
                        <form>
                            <div class="form-group">
                                <label for="changeClientPassword">Mudar senha</label>
                                <input type="password" class="form-control" 
                                        id="changeClientPassword" 
                                        aria-describedby="emailHelp" 
                                        placeholder="Nova senha"
                                        autocomplete="off">
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>