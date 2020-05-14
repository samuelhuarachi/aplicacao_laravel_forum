let ValidationRedefine = require('./class/ValidationRedefine')
const axios = require('axios')

$("#btnRedefinePassword").click(async () => {
    $('#btnRedefinePassword').prop('disabled', true)

    try {
        let validationRedefine = new ValidationRedefine.ValidationRedefine()
        validationRedefine.setEmail($("#inputNewPassword"))

        const newPassword = validationRedefine.validate()

        const nicknameHidden = $("#nicknameHidden").val().trim()
        const tokenHidden = $("#tokenHidden").val().trim()

        let redfineData = {
            nickname: nicknameHidden,
            forgot_token: tokenHidden,
            newPassword: newPassword.password
        }

        let messageReponse = await axios.put(BASEURL + '/api/client/redefine-password', redfineData)
            .then(function (response) {
                return response.data.messge
            })
            .catch(function (error) {
                throw new Error(error.response.data.message)
            })

        $("#div-message-redefine-password-client").show()
        $("#div-message-redefine-password-client").html(messageReponse)
        $("#div-message-redefine-password-client").fadeOut(4000)

        window.location.replace("/chat");

    } catch (error) {
        $("#div-message-redefine-password-client").show()
        $("#div-message-redefine-password-client").html(error)
        $("#div-message-redefine-password-client").fadeOut(4000)
    } finally {
        $('#btnRedefinePassword').prop('disabled', false)
    }
})
