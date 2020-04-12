let validateEmail = require("email-validator")

class ValidationLoginClient
{
    setEmail(email) {  
        this.email = email
    }

    setPassword(password) {  
        this.password = password
    }

    validate() {
        console.log("validando")
        let email = this.email.val().trim()
        let password = this.password.val().trim()

        if (!email || !password) {
            throw new Error("Todos os campos do formulários são obrigatórios")
        }

        if (!validateEmail.validate(email)) {
            throw new Error("E-mail inválido") 
        }

        email = email.trim()
        password = password.trim()

        return {
            email,
            password
        }
    }
}

module.exports = { 
    ValidationLoginClient
}