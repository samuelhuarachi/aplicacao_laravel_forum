$('#btnPrivateSession').click(function () {

    if (!token) {
        $('#modalLoginOrRegisterHTML').modal()
        return
    }
    
    //$('#btnPrivateSession').prop('disabled', true)
    $('#btnStopPrivateSession').prop('disabled', false)
    socket.emit('private-session-request', token)
})
