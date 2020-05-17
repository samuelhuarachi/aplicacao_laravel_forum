const axios = require('axios')

const go = () => {

    axios
        .post(BASEURL + '/api/client/get-data-by-token', {
            token
        })
        .then(function (response) {
            $("#creditsTopStreamVideo").html('<i class="fas fa-donate mr-1"></i> ' + response.data.credits.toFixed(2));
        })
        .catch(function (error) {
            throw new Error(error)
        })
}

module.exports = {
    go
}
