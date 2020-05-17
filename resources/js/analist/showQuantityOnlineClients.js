const showQuantityOnlineClients = listActiveClients => {
    $("#socketOnlineClients").html(
        "Usuários online: " + listActiveClients.length.toString());
}

module.exports = {
    showQuantityOnlineClients
}
