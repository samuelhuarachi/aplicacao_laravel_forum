const PagseguroFormatCreditCard =
    require('./class/PagseguroFormatCreditCard')

const { ValidatePaymentCreditCardForm } =
    require('./class/ValidatePaymentCreditCardForm')


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

        if ($('#card_number').length > 0) {
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

    let card_number = PagseguroFormatCreditCard.formatCreditCardNumber($("#card_number").val())
    let card_expire = PagseguroFormatCreditCard.formatCreditCardExpire($('#card_expire').val())
    let card_brand = $("#card_brand").val()
    let card_cvv = $("#card_cvv").val()
    let expireMonth = card_expire[0]
    let expireYear = '20' + card_expire[1]

    $("#client_token").val(token)
    
    const validatePaymentCreditCardForm = new ValidatePaymentCreditCardForm();
    validatePaymentCreditCardForm.setCreditCardNumber(card_number)
    validatePaymentCreditCardForm.setExpirateDate($('#card_expire').val())
    validatePaymentCreditCardForm.setCVV(card_cvv)
    validatePaymentCreditCardForm.setName($("#card_name").val())
    validatePaymentCreditCardForm.setCPF($("#card_cpf").val())
    validatePaymentCreditCardForm.setBirthday($("#card_birthday").val())

    try {
        validatePaymentCreditCardForm.validate()

        $("#client-payment-form").submit()
    } catch (error) {
        $("#div-message-creditcard-client").show()
        $("#div-message-creditcard-client").html(error.message)
        
    } finally {
        $('#completeOrder').prop('disabled', false)
    }
    
})
