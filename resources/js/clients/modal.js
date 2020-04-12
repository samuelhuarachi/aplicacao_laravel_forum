

const showLoginRegisterModal = () => {
    $("#overlay").css("display", "block");
    $("#modalLoginOrRegisterHTML").css("display", "block")
    console.log("show login modal")
}

module.exports = { 
    showLoginRegisterModal
}