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
</div>