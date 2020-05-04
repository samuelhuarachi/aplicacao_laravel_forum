$('#btnPrivateSession').click(function () {
    $('#btnPrivateSession').prop('disabled', true)
    $('#btnStopPrivateSession').prop('disabled', false)
    socket.emit('private-session-request', token)
})
