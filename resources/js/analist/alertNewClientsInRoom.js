const alertNewClientInRoom = () => {
    let alertSound = document.getElementById("alertNewClients")
    alertSound.pause()
    alertSound.play()
}

module.exports = {
    alertNewClientInRoom
}
