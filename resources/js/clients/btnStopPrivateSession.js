$('#btnStopPrivateSession').click(function () {
    $('#btnStopPrivateSession').prop('disabled', true)
    socket.emit('client-request-stop-private-session', token)
})
