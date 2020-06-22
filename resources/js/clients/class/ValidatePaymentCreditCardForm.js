

class ValidatePaymentCreditCardForm {

    setCreditCardNumber(number) {
        this.number = number.toString().trim()
    }

    setExpirateDate(expirate) {
        this.expirateDate = expirate.toString().trim()
    }

    setCVV(cvv) {
        this.cvv = cvv.toString().trim()
    }

    setName(name) {
        this.name = name.toString().trim()
    }

    setCPF(cpf) {
        this.cpf = cpf.toString().trim()
    }

    setBirthday(birthday) {
        this.birthday = birthday.toString().trim()
    }

    validate() {
        
        if (!this.number) {
            throw new Error("O numero do cartao de crédito é obrigatório")
        }
        
        if (!this.expirateDate) {
            throw new Error("A data de expiração é obrigatória")
        }
        
        if (!this.cvv) {
            throw new Error("O CVV é obrigatório")
        }

        if (!this.name) {
            throw new Error("O nome é obrigatório")
        }

        if (!this.cpf) {
            throw new Error("O CPF é obrigatório")
        }

        if (!this.birthday) {
            throw new Error("A data de aniversário é obrigatório")
        }

        return true
    }
}

module.exports = {
    ValidatePaymentCreditCardForm
}
