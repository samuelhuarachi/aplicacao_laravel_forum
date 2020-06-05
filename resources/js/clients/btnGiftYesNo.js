const {
    Helper
} = require("./Helper")

$(".btnGiftYesNo").click((e) => {
    $("#btnGift").attr("data-value", e.currentTarget.dataset.value)
    $("#modalYesNoGiftMessage").html(`Quer mesmo enviar ${e.currentTarget.dataset.value}?`)
    $('#modalYesNoGift').modal()
})
