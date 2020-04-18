<div class="modal fade" id="modalClientAccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
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
                                        placeholder="Nova senha">
                            </div>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>