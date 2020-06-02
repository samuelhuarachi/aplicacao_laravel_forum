class ValidationNewChallenge {
    setDo(do1) {
        this.do1 = do1
    }

    setPrice(price) {
        this.price = price
    }

    validate() {
        let do1 = this.do1.val().trim()
        let price = this.price.val().trim()

        if (!do1 || !price) {
            throw new Error("Todos os campos do formulários são obrigatórios")
        }

        if (isNaN(price)) {
            throw new Error("O valor precisa ser um numero")
        }

        do1 = do1.trim()
        price = price.trim()

        return {
            do1,
            price
        }
    }
}

module.exports = {
    ValidationNewChallenge
}
