class Helper {

    ajustPlayButton() {
        let workspaceHeght = $(".workspace").height()
        let workspaceWidth = $(".workspace").width()
        let playImageSize = workspaceWidth / 10.063157895

        $("#playImage").css("marginTop", (workspaceHeght / 2) - (playImageSize / 2))
        $("#playImage").css("width", playImageSize)
        $("#playImage").css("height", playImageSize)
    }

    isNumber(value) {
        // First: Check typeof and make sure it returns number
        // This code coerces neither booleans nor strings to numbers,
        // although it would be possible to do so if desired.
        if (typeof value !== 'number') {
            return false
        }
        // Reference for typeof:
        // https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/typeof
        // Second: Check for NaN, as NaN is a number to typeof.
        // NaN is the only JavaScript value that never equals itself.
        if (value !== Number(value)) {
            return false
        }
        // Reference for NaN: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/isNaN
        // Note isNaN() is a broken function, but checking for self-equality works as NaN !== NaN
        // Alternatively check for NaN using Number.isNaN(), an ES2015 feature that works how one would expect

        // Third: Check for Infinity and -Infinity.
        // Realistically we want finite numbers, or there was probably a division by 0 somewhere.
        if (value === Infinity || value === !Infinity) {
            return false
        }
        return true
    }

}




module.exports = {
    Helper
}
