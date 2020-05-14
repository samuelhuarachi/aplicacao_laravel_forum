$('#linkForgotPassword').click(function (e) {

    e.preventDefault();

    $('#modalLoginOrRegisterHTML').modal('hide')
    $('#forgotPassword').modal('show')

    $("#form-forgot-content").show()
    $("#form-forgot-message").hide()
})
