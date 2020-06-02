$('#btn_challenge_cancel').click(function () {

    $('#btn_challenge_cancel').prop('disabled', true)
    socket.emit('challenge_cancel', token)
})
