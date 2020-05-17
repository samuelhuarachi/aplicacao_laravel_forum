const axios = require('axios')

const gainstUpdate = () => {
    axios
        .get(BASEURL + '/api/analist/get-data', {
            headers: {
                Authorization: "Bearer " + token
            }
        })
        .then(function (response) {

            $("#analistGainsInfo").html('Ganhos ' + response.data.gains.toFixed(2) + ' <i class="fas fa-coins"></i>');

        })
        .catch(function (error) {
            throw new Error(error.response.data.message)
        })
}

module.exports = {
    gainstUpdate
}
