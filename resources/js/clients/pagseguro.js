const PagseguroFormatCreditCard =
    require('./class/PagseguroFormatCreditCard')

$("#card_validate_message").hide()
$('#card_number').mask("0000 0000 0000 0000")
$('#card_expire').mask('00/00')
$('#card_cvv').mask('000')
$("#card_image").hide()
$("#card_cpf").mask('000.000.000-00', {
    reverse: true
})
$("#card_birthday").mask('00/00/0000')

jQuery(function ($) {
    $(document).ready(function () {


        if ($('#card_number').val()) {
            $('#card_number').validateCreditCard(function (result) {
                var cardNumber = $("#card_number").val()
                var cardNumberLength = cardNumber.length

                if (cardNumberLength < 19) {
                    $("#card_validate_message").hide()
                }

                if (cardNumberLength == 19 &&
                    (result.valid !== true ||
                        result.length_valid !== true ||
                        result.luhn_valid !== true)
                ) {
                    $("#card_validate_message").show()
                }

                if (result.card_type !== null && (result.card_type.name == 'mastercard' || result.card_type.name == 'visa')) {
                    $("#card_image").show()
                    $("#card_image").attr("src", "/images/creditcard/" + result.card_type.name + ".png")
                } else {
                    $("#card_image").hide()
                }

                if (result.card_type !== null) {
                    $("#card_brand").val(result.card_type.name)
                }
            })
        }



    })
})

$("#completeOrder").click(function () {
    $('#completeOrder').prop('disabled', true)

    var card_number = PagseguroFormatCreditCard.formatCreditCardNumber($("#card_number").val())
    var card_expire = PagseguroFormatCreditCard.formatCreditCardExpire($('#card_expire').val())
    var card_brand = $("#card_brand").val()
    var card_cvv = $("#card_cvv").val()
    var expireMonth = card_expire[0]
    var expireYear = '20' + card_expire[1]

    $("#client_token").val(token)
    $("#client-payment-form").submit();

})
