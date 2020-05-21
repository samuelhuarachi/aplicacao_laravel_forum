class Helper {

    ajustPlayButton() {
        let workspaceHeght = $(".workspace").height()
        let workspaceWidth = $(".workspace").width()

        let playImageSize = workspaceWidth / 10.063157895


        $("#playImage").css("marginTop", (workspaceHeght / 2) - (playImageSize / 2))

        $("#playImage").css("width", playImageSize)
        $("#playImage").css("height", playImageSize)
    }

}


module.exports = {
    Helper
}
