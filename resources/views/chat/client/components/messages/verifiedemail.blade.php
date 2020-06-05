<div class="alert alert-danger" role="alert">
    Enviamos um e-mail de verificação. 
    Verifique seu e-mail. Não recebeu? 
    <a href="{{ route('chat.client.resend-verified-mail', $tokenClient) }}">
                clique aqui</a>

    <button style="margin-top:3px;" type="button" class="close"><span aria-hidden="true">×</span></button>
</div>