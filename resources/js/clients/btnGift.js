const {
    Helper
} = require("./Helper")

$("#btnGift").click((e) => {
    $('#modalYesNoGift').modal('hide')

    if (!token) {
        $('#modalLoginOrRegisterHTML').modal()
        return
    }

    let value = parseFloat(e.currentTarget.dataset.value);
    const helper = new Helper()

    if (helper.isNumber(value) && value > 0) {
        socket.emit("send_gift", {
            value,
            token
        })
    }
})
