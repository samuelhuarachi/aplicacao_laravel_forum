// const BASEURL = 'http://localhost:3001'
// const BASEURL = 'https://quiet-beach-73356.herokuapp.com'
let ValidationRegisterNewUser = require('./class/ValidationRegisterNewUser')
const axios = require('axios')

$("#registerNewClient").click(async function () {
    $('#registerNewClient').prop('disabled', true)

    let classValidationNewClient = new ValidationRegisterNewUser.ValidationRegisterNewUser()

    classValidationNewClient.setNickName($("#inputNicknameRegister"))
    classValidationNewClient.setEmail($("#inputEmailRegister"))
    classValidationNewClient.setPassword($("#inputPasswordRegister"))

    try {
        const clientData = classValidationNewClient.validate()

        response = await axios.post(BASEURL + '/api/client/new-client', clientData)
            .then(function (response) {
                return response
            })
            .catch(function (error) {
                throw new Error(error.response.data.message)
            })

        $('#modalLoginOrRegisterHTML').modal('hide')

        window.location.replace("/camstream/client/auth/" + response.data.token)

        $('#registerNewClient').prop('disabled', false)
    } catch (error) {
        $('#registerNewClient').prop('disabled', false)
        $("#div-message-register-new-client").show()
        $("#div-message-register-new-client").html(error)
        $("#div-message-register-new-client").fadeOut(4000)
    }
})
