
$("#btnCreditsGreen").click(() => {
    
    if (!token) {
        $('#modalLoginOrRegisterHTML').modal()
    }

    if (token && !email_verified) {
        alert("Você precisa verificar seu e-mail antes de adquirir créditos")
    }

    if (token && email_verified) {
        $('#modalAddCredits').modal()
    }
    
})

