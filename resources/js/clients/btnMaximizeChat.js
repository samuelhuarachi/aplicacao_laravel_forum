
$('#btnMaximizeChat').click(function () {

    $("#btnMinimizeChat").show();
    $("#btnMaximizeChat").hide();

    $('#primary_chat').addClass("showChat")
    $('#primary_chat').removeClass("hiddenChat")
})