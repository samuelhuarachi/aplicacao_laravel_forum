const axios = require("axios");

$("#btnSessions").click(async function () {
    $("#modalSessions").modal();

    let response;
    response = await axios
        .get(BASEURL + "/api/client/sessions/" + token)
        .then(function (response) {
            return response.data;
        })
        .catch(function (error) {
            console.log(error);
            throw new Error(error.message);
        });

    let output = `<br>`;
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
                    Garota: ${data.analist.name} ${data.analist.lastname} 
                </div>
                <div class="col-sm text-center">
                        ${streamTotalTimeInMinutes.toFixed(2)} min
                </div>
                <div class="col-sm text-right">
                    Créditos: -${data.session.clientDebit.toLocaleString(
                        "pt-br",
                        { minimumFractionDigits: 2 }
                    )}
                </div>
            </div>`;
    });

    $("#outputSessions").html(output);

    // let output = "<tr><td><b>Codigo da transacao</b></td><td><b>Status</b></td><td class='text-center'><b>Creditos</b></td></tr>"
    // response.data.forEach(function (item) {
    //     let transactionPagseguro = JSON.parse(item.trasaction)

    //     let transactionID = transactionPagseguro.id.replace("CHAR_", "")
    //     let status = ""
    //     if (transactionPagseguro.status == "PAID") {
    //         status = "Aprovado"
    //     } else if (transactionPagseguro.status == "AUTHORIZED") {
    //         status = "Em análise"
    //     } else {
    //         status = "Cancelada"
    //     }

    //     let value = transactionPagseguro.amount.value / 100

    //     output = output + "<tr><td>" + transactionID + "</td><td>" + status + "</td><td class='text-center'>" + value + " <i class='fas fa-coins'></i></td></tr>"
    // })

    //$("#outputSessions").html("<table class='table'>" + output + "</table>")
});
