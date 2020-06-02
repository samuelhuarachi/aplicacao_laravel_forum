class ListenerUpdateChallange {


    activate() {
        console.log("ativeiiii")
        this.listener = setInterval(function () {
            console.log("verificando proposta ...")
        }, 3000)
    }

    stop() {
        clearInterval(this.listener)
    }

}

module.exports = {
    ListenerUpdateChallange
}
