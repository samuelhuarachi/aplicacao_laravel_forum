class DisplayTimeEstimate {

    constructor() {
        this.updateValueInterval = null
    }

    myTime(time) {
        var hr = ~~(time / 3600);
        var min = ~~((time % 3600) / 60);
        var sec = time % 60;
        var sec_min = "";
        if (hr > 0) {
            sec_min += "" + hr + ":" + (min < 10 ? "0" : "");
        }
        sec_min += "" + min + ":" + (sec < 10 ? "0" : "");
        sec_min += "" + sec;
        return sec_min + " min";
    }

    start() {
        $("#time_aproximate").show()
        let seconds = 1;
        let time = "";

        this.updateValueInterval = setInterval(function (myTime) {
            time = myTime(seconds)
            $("#time_aproximate").html('<i class="fas fa-clock"></i> ' + time)
            seconds = seconds + 1
        }, 1000, this.myTime);
    }

    stop() {
        $("#time_aproximate").hide()
        clearInterval(this.updateValueInterval)
    }



}

module.exports = {
    DisplayTimeEstimate
}
