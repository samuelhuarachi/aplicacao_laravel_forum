class DisplayCostSessionEstimate {

    constructor(analistPricePerHourGlobal) {
        this.updateValueInterval = null
        this.analistPricePerHourGlobal = analistPricePerHourGlobal
    }

    start() {
        $("#session_cost_aproximate").show()
        let seconds = 1;

        this.updateValueInterval = setInterval(function (analistPricePerHourGlobal) {

            if (analistPricePerHourGlobal) {
                let price = 0;
                let pricePerSeconds = (analistPricePerHourGlobal / 60) / 60

                if (seconds <= 60) {
                    price = pricePerSeconds * 60
                    $("#session_cost_aproximate").html("Aproximado: +" + price.toFixed(2).toString() + ' <i class="fas fa-coins"></i>')
                } else {
                    price = seconds * pricePerSeconds
                    $("#session_cost_aproximate").html("Aproximado: +" + price.toFixed(2).toString() + ' <i class="fas fa-coins"></i>')
                }

                seconds = seconds + 1
            }
        }, 1000, this.analistPricePerHourGlobal);
    }

    stop() {
        $("#session_cost_aproximate").hide()
        clearInterval(this.updateValueInterval)
    }

}

module.exports = {
    DisplayCostSessionEstimate
}
