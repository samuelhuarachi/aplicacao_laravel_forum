// const BASEURL = 'https://quiet-beach-73356.herokuapp.com'
// const BASEURL = 'http://localhost:3001'
import io from 'socket.io-client'

require('./clients/btnCredits')
require('./clients/btnRegisterNewClient')
require('./clients/btnLoginClient')
require('./clients/btnClientAccount')
require('./clients/btnLogoutClient')
require('./clients/goPayment')
require('./clients/pagseguro')
require('./clients/btnStopPrivateSession')
require('./clients/btnTransactions')
require('./clients/linkForgotPassword')
require('./clients/btnForgotLogin')
require('./clients/btnRedefinePassword')
require('./clients/linkForgotPasswordBack')
const updateCreditsValue = require('./clients/updateCreditsValue')



//const { ConfigureIsOnline } = require('./common')
// const axios = require('axios');

$('.toast').toast('show')

// Load Recaptcha
var onloadCallback = function () {

    const recaptchaRegister = document.getElementById('recaptchaRegister')
    const recaptchaLogin = document.getElementById('recaptchaLogin')
    const recaptchaForgotLogin = document.getElementById('recaptchaForgotLogin')
    const redefinePassword = document.getElementById('redefinePassword')

    if (recaptchaRegister) {
        grecaptcha.render('recaptchaRegister', {
            'sitekey': '6LcSuugUAAAAACy-8wrNOLoQOLcL1cMxQScS-oeW'
        })
    }

    if (recaptchaLogin) {
        grecaptcha.render('recaptchaLogin', {
            'sitekey': '6LcSuugUAAAAACy-8wrNOLoQOLcL1cMxQScS-oeW'
        })
    }

    if (recaptchaForgotLogin) {
        grecaptcha.render('recaptchaForgotLogin', {
            'sitekey': '6LcSuugUAAAAACy-8wrNOLoQOLcL1cMxQScS-oeW'
        })
    }

    if (redefinePassword) {
        grecaptcha.render('redefinePassword', {
            'sitekey': '6LcSuugUAAAAACy-8wrNOLoQOLcL1cMxQScS-oeW'
        })
    }
}

window.onloadCallback = onloadCallback

function connectSocket() {
    if (!socket) {
        socket = io(BASEURL).connect()
    }
    socket.on('connect', function () {
        socket.emit('join-in-room', {
            token,
            clientRoom
        })
        const clientID = socket.id
    })
}

if (typeof (clientRoom) != "undefined" && clientRoom) {
    connectSocket()
}

require('./clients/_client-recept-error')

var friendsVideo = document.getElementById("friendsVideo");

const clientId = uuidv4();
let time = 0;

var servers = {
    'iceServers': [{
            'urls': 'stun:stun.l.google.com:19305'
        },
        {
            'urls': 'stun:stun1.l.google.com:19305'
        },
        {
            'urls': 'stun:stun2.l.google.com:19305'
        },
        {
            'urls': 'stun:stun3.l.google.com:19305'
        }
    ]
};

var pc = new RTCPeerConnection(servers);

pc.onicecandidate = (
    event => {
        if (event.candidate) {
            socket.emit('sendClientICE',
                JSON.stringify({
                    'ice': event.candidate
                }))
        } else {

        }
    });


pc.onaddstream = (event => friendsVideo.srcObject = event.stream);

setTimeout(function () {
    if (typeof (clientRoom) != "undefined" && clientRoom) {
        socket.emit('INeedAnalistOffer', clientId)
    }
}, 1000);


socket.on('receiveAnalistICE', function (data) {
    let msg = JSON.parse(data)
    pc.addIceCandidate(new RTCIceCandidate(msg.ice))
})

require('./clients/btnPrivateSession')


socket.on('sendAnalistOfferToClient', data => {
    var msg = data;
    msg = JSON.parse(msg)

    if (time == 0) {
        pc.setRemoteDescription(new RTCSessionDescription(msg.sdp))
            .then(() => pc.createAnswer())
            .then(answer => pc.setLocalDescription(answer))
            .then(() => socket.emit('sendClientSDP',
                JSON.stringify({
                    'clientId': msg.clientId,
                    'sdp': pc.localDescription
                })))

        time = 1;
    }
})

function uuidv4() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
        var r = Math.random() * 16 | 0,
            v = c == 'x' ? r : (r & 0x3 | 0x8);
        return v.toString(16);
    });
}

$("#btnSend").click(function () {
    let message = $("#txtAreaMessage").val()
    $("#txtAreaMessage").val('')

    message = message.trim()

    if (message != "") {
        let history = $("#history-messages").html()
        history = history + '<br><b>Eu:</b> ' + message
        $("#history-messages").html(history)
        $("#history-messages").animate({
            scrollTop: 9999
        }, 'slow')

        const messageObject = {
            message,
            token
        }

        socket.emit('clientMessage', messageObject)
    }
})

socket.on('receive-client-message', message => {
    updateHistoryMessages(message)
})

socket.on('client-private-session-started', response => {
    if (response) {
        // esconder botao que inicou a sessao
        $('#btnPrivateSession').css('display', 'none')
        // habilita o botao de encerrar a live
        $('#btnStopPrivateSession').css('display', 'block')
        listenerClientIsOnline()
    }
})

let listenerClientIsOnlineInterval = null
let listenerClientIsOnline = function () {
    clearInterval(listenerClientIsOnlineInterval)
    listenerClientIsOnlineInterval = setInterval(function () {
        // Avisa o sistema que o client esta online
        socket.emit("client-listener-is-online", {
            token
        })
    }, 20000)
}

socket.on('client-stop-session', () => {
    $('#btnPrivateSession').css('display', 'block')
    $('#btnStopPrivateSession').css('display', 'none')
    $('#btnPrivateSession').prop('disabled', false)
    clearInterval(listenerClientIsOnline)
    updateCreditsValue.go()
})

socket.on("analist-request-stop-session", function () {
    $('#btnStopPrivateSession').prop('disabled', true)
    $("#btnStopPrivateSession").css("display", "none")
    $('#btnPrivateSession').prop('disabled', false)
    $("#btnPrivateSession").css("display", "block")
    clearInterval(listenerClientIsOnline)
    updateCreditsValue.go()
})

function updateHistoryMessages(message) {
    message = message.trim()

    if (message != "") {
        let history = $("#history-messages").html()
        history = history + '<br>' + message
        $("#history-messages").html(history)
        $("#history-messages").animate({
            scrollTop: 9999
        }, 'slow')
    }
}

socket.on("message-default-to-client", message => {
    $("#message-default-client").css("display", "block")
    $("#message-default-client").html(message + '<button type="button" class="close"><span aria-hidden="true">&times;</span></button>')
    //$("#message-default-client").alert()
})

$("#message-default-client").click(function () {
    $("#message-default-client").css("display", "none")
})

socket.on('reconnect', function () {
    if (typeof (clientRoom) != "undefined" && clientRoom) {
        socket.emit('join-in-room', {
            token,
            clientRoom
        })
    }
});
