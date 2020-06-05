const axios = require('axios')

$("#btnTransactions").click(async function () {
    $('#modalTransactions').modal()

    let response
    response = await axios.get(BASEURL + '/api/client/transactions/' + token)
        .then(function (response) {
            return response
        })
        .catch(function (error) {
            throw new Error(error.message)
        })

    let output = "<tr><td><b>Codigo da transacao</b></td><td><b>Status</b></td><td class='text-center'><b>Creditos</b></td></tr>"
    response.data.forEach(function (item) {
        let transactionPagseguro = JSON.parse(item.trasaction)

        let transactionID = transactionPagseguro.id.replace("CHAR_", "")
        let status = ""
        if (transactionPagseguro.status == "PAID") {
            status = "Aprovado"
        } else if (transactionPagseguro.status == "AUTHORIZED") {
            status = "Em análise"
        } else {
            status = "Cancelada"
        }

        let value = transactionPagseguro.amount.value / 100

        output = output + "<tr><td>" + item._id + "</td><td>" + status + "</td><td class='text-center'>" + value + " <i class='fas fa-coins'></i></td></tr>"
    })

    $("#outputTransactions").html("<table class='table'>" + output + "</table>")
})
