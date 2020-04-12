let validateEmail = require("email-validator")

class ValidationRegisterNewUser
{

    setNickName(nickname) {  
        this.nickname = nickname
    }

    setEmail(email) {  
        this.email = email
    }

    setPassword(password) {  
        this.password = password
    }

    validate() {
        let nickname = this.nickname.val().trim()
        let email = this.email.val().trim()
        let password = this.password.val().trim()

        if (!nickname || !email || !password) {
            throw new Error("Todos os campos do formulários são obrigatórios")
        }

        if (!validateEmail.validate(email)) {
            throw new Error("E-mail inválido") 
        }

        if (!grecaptcha.getResponse(0)) {
            throw new Error("reCaptcha inválido") 
        }

        nickname = nickname.trim()
        email = email.trim()
        password = password.trim()
        response = grecaptcha.getResponse(0)

        return {
            nickname,
            email,
            password,
            response
        }
    }
}

module.exports = { 
    ValidationRegisterNewUser
}