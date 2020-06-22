let ValidationFogotLogin = require('./class/ValidationFogotLogin')
const axios = require('axios')

$("#btnForgotLogin").click(async () => {
    $('#btnForgotLogin').prop('disabled', true)


    try {
        let validationFogotLogin = new ValidationFogotLogin.ValidationFogotLogin()
        validationFogotLogin.setEmail($("#inputForgotEmail"))

        const forgotEmailData = validationFogotLogin.validate()

        let messageReponse = await axios
            .post(BASEURL + '/api/client/forgot-password', forgotEmailData)
            .then(function (response) {
                return response.data.messge
            })
            .catch(function (error) {
                throw new Error(error.response.data.message)
            })

        $("#form-forgot-content").hide()
        $("#form-forgot-message").show()
        $("#form-forgot-message").html("Enviamos o link para redefinição de senha no seu e-mail")

    } catch (error) {
        $("#div-message-forgot-login-client").show()
        $("#div-message-forgot-login-client").html(error)
    } finally {
        $('#btnForgotLogin').prop('disabled', false)
    }
})
