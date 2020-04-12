const BASEURL = 'https://quiet-beach-73356.herokuapp.com'

// const BASEURL = 'http://localhost:3001'

import io from 'socket.io-client'
let socket = null
connectSocket()

var analistVideo = document.getElementById("analistVideo")
var yourId = Math.floor(Math.random()*1000000000)
var servers = {'iceServers': [
    {'urls': 'stun:stun.l.google.com:19305'},
    {'urls': 'stun:stun1.l.google.com:19305'},
    {'urls': 'stun:stun2.l.google.com:19305'},
    {'urls': 'stun:stun3.l.google.com:19305'},
]};

// var pc;
var myConnections = [];
let saveActiveStream = null;

navigator.getUserMedia = (navigator.getUserMedia 
    || navigator.webkitGetUserMedia 
    || navigator.mozGetUserMedia 
    || navigator.msgGetUserMedia);



// Generate offer afeter 5 seconds
// setTimeout(function(){
//     console.log("beleza passou 5 seg")
// }, 5000);

navigator.mediaDevices.getUserMedia({audio:false, video:true})
    .then(stream => {
        analistVideo.srcObject = stream
        saveActiveStream = stream
    })


function storageMySDPInServer(data) {
    console.log(data)
    socket.emit('analistSDPandID', data)
}

// Answers aacho que eh aqui
socket.on('receiveClientSDP', function(data) {
    
    let msg = JSON.parse(data)
    let pc = myConnections[msg.clientId]

    console.log("Registrando a responsta de " + msg.clientId)
    pc.setRemoteDescription(new RTCSessionDescription(msg.sdp))
})

socket.on('receiveClientICE', function(data) {
    // console.log(data)
    // let msg = JSON.parse(data)
    let pc = myConnections[data.clientId];

    //console.log(msg.ice)

    pc.addIceCandidate(new RTCIceCandidate(data.ice));
    //console.log("ICE FOI")
})

socket.on('generateAnalistOffer', function(clientId) {
    myConnections[clientId] = new RTCPeerConnection(servers);
    let pc = myConnections[clientId];

    pc.onicecandidate = (
        event => {
            // console.log("My ICE Analist, client ID " + clientId)
            // console.log(event.candidate);

            if (event.candidate) {
                socket.emit('sendAnalistICE', 
                    JSON.stringify({'clientId': clientId,'ice': event.candidate}))
            } else {
                //console.log("Sent all Analist ice")
            }
        })

    pc.addStream(saveActiveStream)
    
    setTimeout(function(){
        console.log("Gerando oferta para " + clientId )

        pc.createOffer()
        .then(offer => pc.setLocalDescription(offer))
        .then(() => {
            socket.emit('sendNewAnalistOffer', 
                JSON.stringify({'clientId': clientId, 'sdp': pc.localDescription}))
        })
        console.log("Oferta enviada")
    }, 1000)
})

socket.on('onlineClients', onlineClients => {
    $("#socketOnlineClients").html(onlineClients + " usuários online")
})

socket.on('disconnectClient', clientId => {
    let pc = myConnections[clientId];
    pc.close(); 
    pc.onicecandidate = null; 
    pc.onaddstream = null; 
})

socket.on('client-message', message => {
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


$("#btnSend").click(function() {
    let message = $("#txtAreaMessage").val()
    $("#txtAreaMessage").val('')

    message = message.trim()

    if (message != "") {
        let history = $("#history-messages").html()
        history = history + '<br><b class="analistHistory">'+ analistName + ' ' + analistLastname +':</b> ' + message
        $("#history-messages").html(history)
        $("#history-messages").animate({ scrollTop: 9999 }, 'slow')

        socket.emit('analistMessage', JSON.stringify({
            token: token,
            message: message
        }))
    }
})

// socket.on('connect', function() {
//     const sessionID = socket.socket.sessionid
//     console.log(sessionID)
// });


// ######################################################################

function connectSocket() {

    if (!socket) {
        socket = io(BASEURL).connect()
    }

    socket.on('connect', function() {
        const analistID = socket.id;
    
        // socket.emit('sendAnalistSessionID', analistSessionID)
        console.log(analistID)
    
        
        console.log("entrou na sala")
        // socket.emit('join-in-room', slug)
        socket.emit('registerAnalist', 
                JSON.stringify({'id': analistID,'slug': slug}))
    })
}
