const axios = require('axios')

const onOffCheck = () => {
    
    axios
        .get(BASEURL + '/api/analist/get-data', {
            headers: {
                Authorization: "Bearer " + token
            }
        })
        .then(function (response) {
            const isOnline = response.data.isOnline

            if (isOnline) {
                $("#btnOnOff").prop('checked', true)
            } else {
                $("#btnOnOff").prop('checked', false)
            }

        })
        .catch(function (error) {
            throw new Error(error.response.data.message)
        }).finally(function() {
            $('#btnOnOff').prop('disabled', false)
        })
}

module.exports = {
    onOffCheck
}
