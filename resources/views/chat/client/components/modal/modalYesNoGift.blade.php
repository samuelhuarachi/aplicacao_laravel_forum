<div class="modal fade" 
    id="modalYesNoGift" 
    tabindex="-1" 
    role="dialog" 
    aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div style="max-width: 300px;" class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h3 id="modalYesNoGiftMessage"></h3>
                <button id="btnGift" class="btn btn-success">Sim</button>
                <button onClick="$('#modalYesNoGift').modal('toggle');" 
                        class="btn btn-danger float-right">Não</button>
            </div>
        </div>
    </div>
</div>