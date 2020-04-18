const BASEURL = 'https://quiet-beach-73356.herokuapp.com'
// const BASEURL = 'http://localhost:3001'
import io from 'socket.io-client'

require('./clients/btnCredits')
require('./clients/btnRegisterNewClient')
require('./clients/btnLoginClient')
require('./clients/btnClientAccount')
require('./clients/btnLogoutClient')
require('./clients/goPayment')
require('./clients/pagseguro')


//const { ConfigureIsOnline } = require('./common')
// const axios = require('axios');

// Load Recaptcha
var onloadCallback = function() {

    const recaptchaRegister = document.getElementById('recaptchaRegister')
    const recaptchaLogin = document.getElementById('recaptchaLogin')
    
    if (recaptchaRegister) {
        grecaptcha.render('recaptchaRegister', {
            'sitekey' : '6LcSuugUAAAAACy-8wrNOLoQOLcL1cMxQScS-oeW'
        })
    }
    
    if (recaptchaLogin) {
        grecaptcha.render('recaptchaLogin', {
            'sitekey' : '6LcSuugUAAAAACy-8wrNOLoQOLcL1cMxQScS-oeW'
        })
    }
}

window.onloadCallback = onloadCallback

let socket = null

function connectSocket() {

    if (!socket) {
        socket = io(BASEURL).connect()
    }

    socket.on('connect', function() {
        socket.emit('join-in-room')
        const clientID = socket.id
        console.log("SocketID " + clientID)
    })
}

connectSocket()

var friendsVideo = document.getElementById("friendsVideo");

const clientId = uuidv4();
let time = 0;

var servers = {'iceServers': [
        {'urls': 'stun:stun.l.google.com:19305'},
        {'urls': 'stun:stun1.l.google.com:19305'},
        {'urls': 'stun:stun2.l.google.com:19305'},
        {'urls': 'stun:stun3.l.google.com:19305'}
    ]};

var pc = new RTCPeerConnection(servers);

pc.onicecandidate = (
    event => {
        if (event.candidate) {
            socket.emit('sendClientICE', 
                JSON.stringify({'ice': event.candidate}))
        } else {

        }
});


pc.onaddstream = (event => friendsVideo.srcObject = event.stream);

setTimeout(function() {
    console.log("request analist offer")
    socket.emit('INeedAnalistOffer', clientId)
}, 1000);


socket.on('receiveAnalistICE', function(data) {
    let msg = JSON.parse(data)
    pc.addIceCandidate(new RTCIceCandidate(msg.ice))
})


socket.on('sendAnalistOfferToClient', data => {
    var msg = data;
    msg = JSON.parse(msg)

    console.log("2x ????")
    
    if (time == 0) {
        console.log("Recebi a oferta " + msg.clientId)
        pc.setRemoteDescription(new RTCSessionDescription(msg.sdp))
                    .then(() => pc.createAnswer())
                    .then(answer => pc.setLocalDescription(answer))
                    .then(() => socket.emit('sendClientSDP',
                            JSON.stringify({'clientId': msg.clientId,'sdp': pc.localDescription})))

        time = 1;
        console.log("e gerei uma resposta já enviei " + msg.clientId)
    }
})

function uuidv4() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
        return v.toString(16);
    });
}

$("#btnSend").click(function() {
    let message = $("#txtAreaMessage").val()
    $("#txtAreaMessage").val('')

    message = message.trim()

    if (message != "") {
        let history = $("#history-messages").html()
        history = history + '<br><b>Eu:</b> ' + message
        $("#history-messages").html(history)
        $("#history-messages").animate({ scrollTop: 9999 }, 'slow')

        socket.emit('clientMessage', message)
    }
})

socket.on('receive-client-message', message => {
    updateHistoryMessages(message)
})

function updateHistoryMessages(message)
{
    message = message.trim()

    if (message != "") {
        let history = $("#history-messages").html()
        history = history + '<br>' + message
        $("#history-messages").html(history)
        $("#history-messages").animate({ scrollTop: 9999 }, 'slow')
    }
}

