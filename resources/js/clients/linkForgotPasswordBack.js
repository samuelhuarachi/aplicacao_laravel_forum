$('#linkForgotPasswordBack').click(function (e) {
    e.preventDefault()

    $('#forgotPassword').modal('hide')
    $('#modalLoginOrRegisterHTML').modal('show')
})
