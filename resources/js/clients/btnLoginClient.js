const axios = require('axios')
let ValidationLoginClient = require('./class/ValidationLoginClient')

$("#btnLoginClient").click(async function() {
    $('#btnLoginClient').prop('disabled', true)
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
                              throw new Error(error.message)
                           })

        window.location.replace("/chat/client/auth/" + getLogin.data.token)
     }
     catch (error) {
        $("#div-message-login-client").show()
        $("#div-message-login-client").html(error.message)
        $("#div-message-login-client").fadeOut(4000)
     }
})



