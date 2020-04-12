
let ValidationLoginClient = require('./class/ValidationLoginClient')

$("#btnLoginClient").click(function() {

    let classValidationLoginClient = new ValidationLoginClient.ValidationLoginClient()
    classValidationLoginClient.setEmail($("#inputEmailLogin"))
    classValidationLoginClient.setPassword($("#inputPasswordLogin"))

    try {
        classValidationLoginClient.validate()
        grecaptcha.getResponse(1)
        
     }
     catch (error) {
        $("#div-message-login-client").show()
        $("#div-message-login-client").html(error.message)
        $("#div-message-login-client").fadeOut(4000)
     }
})



