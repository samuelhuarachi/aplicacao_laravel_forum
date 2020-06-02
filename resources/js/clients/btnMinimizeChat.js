
$('#btnMinimizeChat').click(function () {
    $("#btnMinimizeChat").hide();
    $("#btnMaximizeChat").show();

    $('#primary_chat').removeClass("showChat")
    $('#primary_chat').addClass("hiddenChat")
})