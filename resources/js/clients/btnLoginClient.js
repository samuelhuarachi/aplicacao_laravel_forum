const axios = require('axios')
let ValidationLoginClient = require('./class/ValidationLoginClient')

$("#btnLoginClient").click(async function () {
    $('#btnLoginClient').prop('disabled', true)
    $("#div-message-login-client").hide()

    let classValidationLoginClient = new ValidationLoginClient.ValidationLoginClient()
    classValidationLoginClient.setEmail($("#inputEmailLogin"))
    classValidationLoginClient.setPassword($("#inputPasswordLogin"))

    try {
        const clientData = classValidationLoginClient.validate()

        const getLogin = await axios.post(BASEURL + '/api/client/auth-by-email-password', clientData)
            .then(function (response) {
                return response
            })
            .catch(function (error) {

                throw new Error(error.response.data.error)
            })

        window.location.replace("/camstream/garota/auth/" + getLogin.data.token)
    } catch (error) {
        $("#div-message-login-client").css("color", "red")
        $("#div-message-login-client").css("marginBottom", "10px")
        $("#div-message-login-client").show()
        $("#div-message-login-client").html(error)
    } finally {
        $('#btnLoginClient').prop('disabled', false)
    }
})
