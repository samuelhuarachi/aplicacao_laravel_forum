const axios = require('axios')

const go = () => {

    axios
        .post(BASEURL + '/api/client/get-data-by-token', {
            token
        })
        .then(function (response) {
            console.log(response)
            $("#creditsTopStreamVideo").html(
                `<i class="fas fa-coins mr-1"></i> ${response.data.credits.toFixed(2)} 
                <i class="fas fa-ban ml-3"></i> ${response.data.credits_blocked.toFixed(2)}`);
        })
        .catch(function (error) {
            throw new Error(error)
        })
}

module.exports = {
    go
}
