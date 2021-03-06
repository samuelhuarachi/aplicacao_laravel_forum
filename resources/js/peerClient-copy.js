const BASEURL = 'https://quiet-beach-73356.herokuapp.com'
// const BASEURL = 'http://localhost:3001'
import io from 'socket.io-client'

require('./clients/btnCredits')
require('./clients/btnRegisterNewClient')
require('./clients/btnLoginClient')
require('./clients/btnClientAccount')
require('./clients/btnLogoutClient')
require('./clients/goPayment')


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


    // {'urls': 'stun:stun.services.mozilla.com'},  
// {'urls': 'turn:numb.viagenie.ca','credential': 'sempre123','username': 'samuel.huarachi@gmail.com'}
    // {'urls': 'stun:stun.services.mozilla.com'}, 
    // {'urls': 'stun:stun.l.google.com:19302'}

// {'urls': 'turn:numb.viagenie.ca','credential': 'sempre123','username': 'samuel.huarachi@gmail.com'}

//     stun.l.google.com:19305
// stun1.l.google.com:19305
// stun2.l.google.com:19305
// stun3.l.google.com:19305
// stun4.l.google.com:19305

//     stun.l.google.com:19302
// stun1.l.google.com:19302
// stun2.l.google.com:19302
// stun3.l.google.com:19302
// stun4.l.google.com:19302
// stun01.sipphone.com
// stun.ekiga.net
// stun.fwdnet.net
// stun.ideasip.com
// stun.iptel.org
// stun.rixtelecom.se
// stun.schlund.de
// stunserver.org
// stun.softjoys.com
// stun.voiparound.com
// stun.voipbuster.com
// stun.voipstunt.com
// stun.voxgratia.org
// stun.xten.com

// slow repsonde
// stun01.sipphone.com
// stun.fwdnet.net
// stun.voxgratia.org
// stun.xten.com

// japan stun
// s1.taraba.net          203.183.172.196:3478
// s2.taraba.net          203.183.172.196:3478 
// s1.voipstation.jp          113.32.111.126:3478
// s2.voipstation.jp          113.32.111.127:3478

// https://gist.github.com/zziuni/3741933

var pc = new RTCPeerConnection(servers);

// pc.iceTransports = 'relay'

// pc.config.peerConnectionConfig.iceTransports = 'relay'

pc.onicecandidate = (
    event => {
        if (event.candidate) {
            //console.log(event.candidate)
            socket.emit('sendClientICE', 
                JSON.stringify({'ice': event.candidate}))
        } else {
            //console.log("Sent All Ice")
        }
});

// axios.get(url)
//     .then(response => {
//         var msg = response.data;
//         msg = JSON.parse((msg.sdpOffer))
//         let sdpClient = msg.sdp

//         // pc.setRemoteDescription(new RTCSessionDescription(msg))
//         //         .then(() => pc.createAnswer())
//         //         .then(answer => pc.setLocalDescription(answer))
//         //         .then(() => socket.emit('sendClientSDP',JSON.stringify({'sdp': pc.localDescription})))
//     })
//     .catch(function (error) {
//         // handle error
//         console.log(error);
//     })

pc.onaddstream = (event => friendsVideo.srcObject = event.stream);

setTimeout(function() {
    console.log("request analist offer")
    socket.emit('INeedAnalistOffer', clientId)
}, 1000);


socket.on('receiveAnalistICE', function(data) {
    let msg = JSON.parse(data)

    // let pc = myConnections[msg.clientId];
    // console.log(msg.ice)

    //if (msg.clientId == clientId) {
        pc.addIceCandidate(new RTCIceCandidate(msg.ice));
        console.log("ICE analist receive")
    //}
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
        console.log("e gerei uma resposta j?? enviei " + msg.clientId)
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



// *******************************************************************


$("#card_validate_message").hide()
$('#card_number').mask("0000 0000 0000 0000")
$('#card_expire').mask('00/00')
$('#card_cvv').mask('000')
$("#card_image").hide()
$("#card_cpf").mask('000.000.000-00', {reverse: true})
$("#card_birthday").mask('00/00/0000')

$('#card_number').validateCreditCard(function(result) {
    var cardNumber = $("#card_number").val();
    var cardNumberLength = cardNumber.length;

    if (cardNumberLength < 19) {
        $("#card_validate_message").hide();
    }

    if (cardNumberLength == 19
    && (result.valid !== true
    || result.length_valid !== true
    || result.luhn_valid !== true)
    ) {
        $("#card_validate_message").show();
    }
    
    if (result.card_type !== null && (result.card_type.name == 'mastercard' || result.card_type.name == 'visa')) {
        $("#card_image").show();
        $("#card_image").attr("src","/images/creditcard/" + result.card_type.name + ".png");
    } else {
        $("#card_image").hide();
    }

    if (result.card_type !== null) {
        $("#card_brand").val(result.card_type.name);
    }
    
    // $('.log').html('Card type: ' + (result.card_type == null ? '-' : result.card_type.name)
    //          + '<br>Valid: ' + result.valid
    //          + '<br>Length valid: ' + result.length_valid
    //          + '<br>Luhn valid: ' + result.luhn_valid);
});

// socket.on('send-status', function(message) {
//     var messageBox = $("#isOnline");
//     messageBox.html(message);
// })

// navigator.getUserMedia = (navigator.getUserMedia 
//     || navigator.webkitGetUserMedia 
//     || navigator.mozGetUserMedia 
//     || navigator.msgGetUserMedia);

// navigator.getUserMedia({video: true, audio: false}, function(stream) {
//     var peer = new Peer({
//         initiator: false,
//         trickle: false,
//         config: {
//             iceServers: [{ 'url': 'stun:stun.l.google.com:19302' }]
//         }
//     })

//     peer.on('signal', function (data) {
//         console.log("foi");
//         document.getElementById('analistID').value = JSON.stringify(data)
//     })

//     document.getElementById('connect').addEventListener('click', function() {
//         var otherID = JSON.parse(document.getElementById('clientID').value)
//         peer.signal(otherID)
//     })

//     document.getElementById('send').addEventListener('click', function() {
//         var yourMessage = document.getElementById('yourMessage').value
//         peer.send(yourMessage)
//     })

//     peer.on('data', function(data) {
//         document.getElementById('messages').textContent += data + '\n'
//     })
//     peer.on('stream', function(stream) {
//         var video = document.createElement('video')
//         document.body.appendChild(video)

        
//         video.srcObject = stream
//         video.play()
//     })
// }, function(err) {
//     console.error(err)
// })


// function verifyStatus()
// {
//     var url = BASEURL + '/analist/(19)%2092323-1300';
//     axios.get(url)
//         .then(response => {
//             ConfigureIsOnline(response.data.isOnline)
//             console.log(response.data.isOnline)
//         })
//         .catch(function (error) {
//             // handle error
//             console.log(error);
//         })
// }

// verifyStatus()