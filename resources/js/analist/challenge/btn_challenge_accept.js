$('#btn_challenge_accept').click(function () {

    $('#btn_challenge_accept').prop('disabled', true)
    socket.emit('challenge_accept', token)
})
