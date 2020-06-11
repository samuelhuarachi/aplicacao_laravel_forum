const {
    ValidationNewChallenge
} = require("./class/ValidationNewChallenge")

const {
    ListenerUpdateChallange
} = require("./class/ListenerUpdateChallange")

const axios = require("axios")

$("#newChallenge").click(async function () {
    $('#newChallenge').prop('disabled', true)

    let classValidationNewChallenge = new ValidationNewChallenge()
    classValidationNewChallenge.setDo($("#inputChallengeDo"))
    classValidationNewChallenge.setPrice($("#inputChallengePrice"))

    try {
        const challengeData = classValidationNewChallenge.validate()

        let responseNewChallenge = await axios.post(BASEURL + '/api/analist/new-challenge',
                challengeData, {
                    headers: {
                        Authorization: "Bearer " + token
                    }
                })
            .then(function (response) {
                return response
            })
            .catch(function (error) {
                throw new Error(error.response.data.error)
            })

        // const classListenerUpdateChallange = new ListenerUpdateChallange()
        // classListenerUpdateChallange.activate()

        socket.emit("listen_for_challenge", JSON.stringify({
            type: "analist",
            token
        }))

        $('#modalChallenge').modal("toggle")
    } catch (error) {
        $("#div-message-new-challenge").css("color", "red")
        $("#div-message-new-challenge").css("marginBottom", "10px")
        $("#div-message-new-challenge").show()
        $("#div-message-new-challenge").html(error)
        $("#div-message-new-challenge").delay(4000).hide()
    } finally {
        $('#newChallenge').prop('disabled', false)
    }
})
