let validateEmail = require("email-validator")

class ValidationFogotLogin {
    setEmail(email) {
        this.email = email
    }

    validate() {
        let email = this.email.val().trim()

        if (!email) {
            throw new Error("Preencha o email")
        }

        if (!validateEmail.validate(email)) {
            throw new Error("E-mail inválido")
        }

        if (!grecaptcha.getResponse(2)) {
            throw new Error("reCaptcha inválido")
        }

        email = email.trim()

        return {
            email
        }
    }
}

module.exports = {
    ValidationFogotLogin
}
