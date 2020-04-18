



$(".btnPayment").click(function() {
    const value = $(this).data("value")

    $('#modalAddCredits').modal('hide')
    $('#modalPayment').modal('show')

    $("#final-value").html('R$ ' + value.toString() + ' <i class="fas fa-coins">')
})





