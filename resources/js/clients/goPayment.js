$(".btnPayment").click(function () {
    const value = $(this).data("value")

    $('#modalAddCredits').modal('hide')
    $('#modalPayment').modal('show')

    $('#credits_total').val(value.toString())
    $("#final-value").html('R$ ' + value.toString() + ' <i class="fas fa-coins">')
})
