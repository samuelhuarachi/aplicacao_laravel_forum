socket.on('_client-recept-error', function (data) {

    $("#message-default-client").css("display", "block")
    $("#message-default-client").html(data.message + '<i style="padding-top: 4px; cursor:pointer;" class="fas fa-times float-right"></i>')

    switch (data.type) {
        case 'INSUFICIENT_CREDITS':
            $('#btnPrivateSession').prop('disabled', false)
            break;
        case 'OPENNED_SESSION_READY':
            $('#btnPrivateSession').prop('disabled', false)
            break;
        default:

    }
})
