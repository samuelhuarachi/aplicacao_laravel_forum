class ValidationRedefine {
    setEmail(password) {
        this.password = password
    }

    validate() {
        let password = this.password.val().trim()

        if (!password) {
            throw new Error("Preencha a senha")
        }

        if (!grecaptcha.getResponse(3)) {
            throw new Error("reCaptcha inválido")
        }

        return {
            password
        }
    }
}

module.exports = {
    ValidationRedefine
}
