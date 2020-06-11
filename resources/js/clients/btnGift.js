const {
    Helper
} = require("./Helper")

const updateCreditsValue = require("./updateCreditsValue")

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

        updateCreditsValue.go()
    }


})
