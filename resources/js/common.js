


configureIsOnline = (isOnline) => {
    if (isOnline) {
        $("#isOnline").html("Está online")
    } else {
        $("#isOnline").html("Offline")
    }
}


module.exports = { 
    ConfigureIsOnline: configureIsOnline
}