class UpdateChallgenteInfo {

    render(challengeInfo) {

        const price = challengeInfo.price
        const collected = challengeInfo.collected
        const status = challengeInfo.status
        let collectedPercent = null
        let statusText

        if (collected > 0) {
            collectedPercent = (collected * 100) / price

            if (collectedPercent < 1) {
                collectedPercent = 1
            }

            collectedPercent = collectedPercent.toFixed(2).toString()
        } else {
            collectedPercent = 1
        }

        if (status == 0) {
            statusText = "Aguardando ofertas"

            $("#challengeInfo").show()
            $("#challenge_control_waiting").show()
            $("#challenge_control_finalize").hide()

            $('#btn_challenge_accept').prop('disabled', false)
            $('#btn_challenge_cancel').prop('disabled', false)
            $('#btn_challenge_finallize').prop('disabled', true)
        } else if (status == 1) {

            statusText = "Valor atingido"

            $("#challengeInfo").show()
            $("#challenge_control_waiting").hide()
            $("#challenge_control_finalize").show()

            $('#btn_challenge_finallize').prop('disabled', false)
            $('#btn_challenge_accept').prop('disabled', true)
            $('#btn_challenge_cancel').prop('disabled', true)

        } else if (status == -1 || status == 2) {
            $("#challengeInfo").hide()
            $("#challenge_control_waiting").hide()
            $("#challenge_control_finalize").hide()

            $('#btn_challenge_accept').prop('disabled', true)
            $('#btn_challenge_cancel').prop('disabled', true)
            $('#btn_challenge_finallize').prop('disabled', true)
            return
        }

        $("#challengeInfo").html(`
            
            <h3>${challengeInfo.do1} por ${challengeInfo.price} <i class="fas fa-coins"></i></h3>
            <p>${challengeInfo.collected} até o momento</p>
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: ${collectedPercent}%;" aria-valuenow="${collectedPercent}" aria-valuemin="0" aria-valuemax="100">${collectedPercent}%</div>
            </div>
            <p><b>Status:</b> ${statusText}</p>
        `)

    }

}

module.exports = {
    UpdateChallgenteInfo
}
