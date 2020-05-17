const listOfClientsActiveInYourChatFunction = listActiveClients => {

    let htmlRender = '';

    listActiveClients.forEach(function (client) {

        let loggedInfo = "Visitante"
        let credits = 0
        let logged = client.logged

        if (logged) {
            loggedInfo = "Logado"
            credits = client.credits
        }

        htmlRender = htmlRender + `<div 
        class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">${client.nickname}</h5>
                <small>${credits.toFixed(2)} <i class="fas fa-coins"></i></small>
            </div>
            <p class="mb-1"></p>
            <small>${loggedInfo}</small>

            <button type="button" class="btn btn-outline-primary btn-sm float-right">
                    Bloquear <i class="fas fa-lock"></i></button>
        </div>`
    })

    $("#list-of-clients-active-in-your-chat").html(htmlRender)
}

module.exports = {
    listOfClientsActiveInYourChatFunction
}
