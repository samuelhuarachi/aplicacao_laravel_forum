class UpdateChallgenteInfo {

    render(challengeInfo) {


        const price = challengeInfo.price
        const collected = challengeInfo.collected
        const status = challengeInfo.status
        let collectedPercent = null

        $("#challengeInfo").show()
        if (status == -1 || status == 2) {
            $("#challengeInfo").hide()
            return
        }

        if (collected > 0) {
            collectedPercent = (collected * 100) / price

            if (collectedPercent < 1) {
                collectedPercent = 1
            }
        } else {
            collectedPercent = 1
        }

        $("#challengeInfo").html(`
            
            <h3>${challengeInfo.do1} por ${challengeInfo.price} <i class="fas fa-coins"></i></h3>
            <p>Recebidos ${challengeInfo.collected} até o momento</p>
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: ${collectedPercent}%;" aria-valuenow="${collectedPercent}" aria-valuemin="0" aria-valuemax="100">${collectedPercent.toFixed(2)}%</div>
            </div>
        `)

    }

}

module.exports = {
    UpdateChallgenteInfo
}
