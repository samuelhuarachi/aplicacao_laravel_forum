$('#btnStopPrivateSession').click(function () {
    $('#btnStopPrivateSession').prop('disabled', true)
    socket.emit('analist-request-stop-private-session', token)
})
