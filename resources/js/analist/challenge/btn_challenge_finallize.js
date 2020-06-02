$('#btn_challenge_finallize').click(function () {
    $('#btn_challenge_finallize').prop('disabled', true)
    socket.emit('challenge_finalize', token)
})
