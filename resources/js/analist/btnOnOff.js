const axios = require('axios')
const onOffCheck = require("./onOffCheck")

$("#btnOnOff").change(async () => {
    $('#btnOnOff').prop('disabled', true)

    try {
        const onOffValue = $("#btnOnOff").is(":checked")

        let messageReponse = await axios
            .put(BASEURL + '/api/analist/on_off', {
                isOnline: onOffValue
            },{
                headers: {
                    Authorization: "Bearer " + token
                }
            })
            .then(function (response) {
                return response.data
            })
            .catch(function (error) {
                throw new Error(error.response)
            })
            
    } catch (error) {
        console.log(error)
    } finally {
        $('#btnOnOff').prop('disabled', false)
        onOffCheckJS.onOffCheck()
    }
})
