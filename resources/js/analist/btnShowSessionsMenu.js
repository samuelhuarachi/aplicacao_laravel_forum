const axios = require("axios");

$('#btnShowSessionsMenu').click(async function () {
    $("#modalSessions").modal();

    let response = await axios
        .get(BASEURL + "/api/analist/sessions", {
            headers: {
                Authorization: "Bearer " + token
            }
        })
        .then(function (response) {
            return response.data;
        })
        .catch(function (error) {
            console.log(error);
            throw new Error(error.message);
        });

    let output = `<br>`;
    let totalGains = 0;
    response = response.reverse()
    response.forEach(function (data) {
        let start = new Date(data.session.startSession);
        let finish = new Date(data.session.endSession);

        let streamTotalTime = finish - start;
        let streamTotalTimeInMinutes = streamTotalTime / 1000 / 60;

        output =
            output +
            `
            <div class="row">
                <div class="col-sm">
                    ${data.client.nickname}
                </div>
                <div class="col-sm text-center">
                        ${streamTotalTimeInMinutes.toFixed(2)} min
                </div>
                <div class="col-sm text-right">
                    +${data.session.analistGains.toLocaleString(
                        "pt-br",
                        { minimumFractionDigits: 2 }
                    )} <i class="fas fa-coins"></i>
                </div>
            </div>`;

        totalGains = totalGains + data.session.analistGains
    })

    $("#modalSessionTotalGains").html(totalGains.toLocaleString(
        "pt-br", {
            minimumFractionDigits: 2
        }
    ))
    $("#outputSessions").html(output);
})
