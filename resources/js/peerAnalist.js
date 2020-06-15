// const BASEURL = 'https://quiet-beach-73356.herokuapp.com'

// const BASEURL = "http://localhost:3001";

import io from "socket.io-client";

connectSocket();

require("./analist/btnStopPrivateSession")
require("./analist/btnShowSessionsMenu")
require("./analist/btnChallenge")
require("./analist/newChallenge")
require("./analist/challenge/btn_challenge_accept")
require("./analist/challenge/btn_challenge_cancel")
require("./analist/challenge/btn_challenge_finallize")
require("./analist/btnOnOff")
const onOffCheckJS = require("./analist/onOffCheck")

$("#challenge_control_waiting").hide()
$("#challenge_control_finalize").hide()

$('#btnOnOff').prop('disabled', true)
onOffCheckJS.onOffCheck()

const {
    UpdateChallgenteInfo
} = require("./analist/class/UpdateChallgenteInfo");
const listOfClientsActiveInYourChatFunction = require("./analist/listOfClientsActiveInYourChatFunction");
const showQuantityOnlineClients = require("./analist/showQuantityOnlineClients");
const alertNewClientInRoom = require("./analist/alertNewClientsInRoom");
const gainstUpdate = require("./analist/gainstUpdate");
const DisplayCostSessionEstimate = require("./analist/DisplayCostSessionEstimate");
const DisplayTimeEstimate = require("./clients/class/DisplayTimeEstimate");
var analistVideo = document.getElementById("analistVideo");
let displayCostSessionEstimate = new DisplayCostSessionEstimate.DisplayCostSessionEstimate(
    analistPricePerHourGlobal
);
let displayTimeEstimate = new DisplayTimeEstimate.DisplayTimeEstimate();

var servers = {
    iceServers: [
        // {
        //     urls: "stun:stun.l.google.com:19305"
        // },
        // {
        //     urls: "stun:stun1.l.google.com:19305"
        // },
        // {
        //     urls: "stun:stun2.l.google.com:19305"
        // },
        // {
        //     urls: "stun:stun3.l.google.com:19305"
        // },
        // {
        //     urls: "stun:stun4.l.google.com:19305"
        // }
        //     {
        //         urls: 'turn:numb.viagenie.ca:3478',
        //         credential: 'abc123321',
        //         username: 'batman.batmann@gmail.com'
        //     }
        // {
        //     urls: 'turn:global.turn.twilio.com:3478?transport=tcp',
        //     credential: 'mSvKTrMLm+71NtAH1IxKcGorSv/wYN4J7dpoBImUFgg=',
        //     username: '420708da7be43194a4148c7c4320ee5cb477e53fd5ad5e067e5d417bd9536ac9'
        // }
        {
            urls: "stun:global.stun.twilio.com:3478?transport=udp"
        },
        {
            urls: "turn:global.turn.twilio.com:3478?transport=udp",
            credential: "/f5kC5ZjPnwFwHKJzTGLkGbmgdhgFZRpwFsiAgf0Zxc=",
            username: "5fe6df6fc0112c24f0f0e2954d2a17ac5c400eef396f6eb2c20cf17b71c0a24f"
        },
        {
            urls: "turn:global.turn.twilio.com:3478?transport=tcp",
            credential: "/f5kC5ZjPnwFwHKJzTGLkGbmgdhgFZRpwFsiAgf0Zxc=",
            username: "5fe6df6fc0112c24f0f0e2954d2a17ac5c400eef396f6eb2c20cf17b71c0a24f"
        },
        {
            urls: "turn:global.turn.twilio.com:443?transport=tcp",
            credential: "/f5kC5ZjPnwFwHKJzTGLkGbmgdhgFZRpwFsiAgf0Zxc=",
            username: "5fe6df6fc0112c24f0f0e2954d2a17ac5c400eef396f6eb2c20cf17b71c0a24f"
        }
    ]
};

// var pc;
var myConnections = [];
let saveActiveStream = null;

// navigator.getUserMedia =
//     navigator.getUserMedia ||
//     navigator.webkitGetUserMedia ||
//     navigator.mozGetUserMedia ||
//     navigator.msgGetUserMedia;

// Generate offer afeter 5 seconds
// setTimeout(function(){
//     console.log("beleza passou 5 seg")
// }, 5000);

navigator.mediaDevices
    .getUserMedia({
        audio: false,
        video: true
    })
    .then(stream => {
        analistVideo.srcObject = stream;
        saveActiveStream = stream;
    });

function storageMySDPInServer(data) {
    socket.emit("analistSDPandID", data);
}

/**
 * se tiver uma challenge ativa, ele exibe
 */
if (challengeDataGlobal) {
    const classUpdateChallgenteInfo = new UpdateChallgenteInfo()
    classUpdateChallgenteInfo.render(challengeDataGlobal)

}

socket.on("challenge_info", function (data) {
    const classUpdateChallgenteInfo = new UpdateChallgenteInfo()
    classUpdateChallgenteInfo.render(data)
})

socket.on("private-session-started", function (clientSocketIDRequestedPrivate) {
    // vai desconectar todo mundo que nao faz parte da sessao privada
    disconnectAllFromPrivateSession(clientSocketIDRequestedPrivate);
    // habilita botao de encerrar sessao
    $("#btnStopPrivateSession").css("display", "block");
    $("#btnStopPrivateSession").prop("disabled", false);
    $("#private-session-message").css("display", "contents");
    listenerAnalistIsOnline();

    displayCostSessionEstimate.start();
    displayTimeEstimate.start();
});

// Mostra  os clientes ativos
// para a analista
socket.on("send-current-clients-active-in-room-to-analist", function (
    listClientsInMyRoom
) {
    /**
     * se entrar um cliente a mais na sala
     * ele emite um som
     */
    if (
        listClientsInMyRoom.length > globalQuantityOnlineClients &&
        document.getElementById("optionAlertWhenNewClientComming").checked ==
        true
    ) {
        alertNewClientInRoom.alertNewClientInRoom();
    }

    globalQuantityOnlineClients = listClientsInMyRoom.length;
    showQuantityOnlineClients.showQuantityOnlineClients(listClientsInMyRoom);
    listOfClientsActiveInYourChatFunction.listOfClientsActiveInYourChatFunction(
        listClientsInMyRoom
    );
});

let listenerAnalistIsOnlineInterval = null;
let listenerAnalistIsOnline = function () {
    clearInterval(listenerAnalistIsOnlineInterval);

    listenerAnalistIsOnlineInterval = setInterval(function () {
        // Avisa o sistema que o analista esta online
        socket.emit("analist-listener-is-online", {
            token
        });
    }, 5000);
};

/**
 *
 * vai desconectar todo mundo que nao faz parte da sessao privada
 */
function disconnectAllFromPrivateSession(clientSocketIDRequestedPrivate) {
    const keysInMyconnections = Object.keys(myConnections);
    keysInMyconnections.forEach(function (clientSocketID) {
        if (clientSocketIDRequestedPrivate !== clientSocketID) {
            disconnectPeerByClientSocketID(clientSocketID);
            socket.emit("message-default-to-client", {
                clientSocketID,
                message: "A garota entrou em uma sessão privada, volte mais tarde"
            });
        }
    });
}

socket.on("client-request-stop-session", () => {
    $("#btnStopPrivateSession").css("display", "none");
    $("#private-session-message").css("display", "none");
    clearInterval(listenerAnalistIsOnlineInterval);
    gainstUpdate.gainstUpdate();

    displayCostSessionEstimate.stop();
    displayTimeEstimate.stop();
});



socket.on("analist-stop-session", () => {
    $("#btnStopPrivateSession").css("display", "none");
    $("#private-session-message").css("display", "none");
    clearInterval(listenerAnalistIsOnlineInterval);
    gainstUpdate.gainstUpdate();

    displayCostSessionEstimate.stop();
    displayTimeEstimate.stop();
});

socket.on("update_gains", () => {
    gainstUpdate.gainstUpdate();
})

// Answers aacho que eh aqui
socket.on("receiveClientSDP", function (data) {
    let msg = JSON.parse(data);
    let pc = myConnections[msg.clientId];
    pc.setRemoteDescription(new RTCSessionDescription(msg.sdp));

    /**
     *
     * avisa no server que precisamos dos ices
     */
    // socket.emit(
    //     "analist_need_client_ice",
    //     JSON.stringify({
    //         clientId: msg.clientId
    //     })
    // )

    // listCheckIceReceived[msg.clientId] = false
});

/**
 * recebe o ice do cliente
 */
socket.on("receiveClientICE", function (data) {
    console.log("receive ice client");
    let pc = myConnections[data.clientId];
    pc.addIceCandidate(new RTCIceCandidate(data.ice));
});


/**
 * gero a oferta
 */
socket.on("generateAnalistOffer", function (clientId) {
    let pc = myConnections[clientId];
    if (pc) {
        //disconnectPeerByClientSocketID(clientId)
    }

    myConnections[clientId] = new RTCPeerConnection(servers);
    pc = myConnections[clientId];
    pc.onicecandidate = event => {
        // console.log("My ICE Analist, client ID " + clientId)
        // console.log(event.candidate);

        if (event.candidate) {
            socket.emit(
                "sendAnalistICE",
                JSON.stringify({
                    clientId: clientId,
                    ice: event.candidate,
                    
                })
            );
        } else {
            //console.log("Sent all Analist ice")
        }
    };

    pc.addStream(saveActiveStream);

    // saveActiveStream.getTracks().forEach(
    //     track => {
    //         pc.addTrack(track, saveActiveStream)
    //         //console.log(track)
    //     })

    setTimeout(async function () {
        // try {

        //     let offer = await pc.createOffer();

        //     let description = await pc.setLocalDescription(offer)

        //     socket.emit(
        //         "sendNewAnalistOffer",
        //         JSON.stringify({
        //             clientId: clientId,
        //             sdp: pc.localDescription
        //         })
        //     )

        // } catch (e) {
        //     console.log(e)
        // }

        pc.createOffer()
            .then(offer => pc.setLocalDescription(offer))
            .then(() => {
                socket.emit(
                    "sendNewAnalistOffer",
                    JSON.stringify({
                        clientId: clientId,
                        sdp: pc.localDescription,
                        slug
                    })
                );
            });
    }, 1000);
});

socket.on("disconnectClient", clientId => {
    let pc = myConnections[clientId];
    if (pc) {
        pc.close();
        pc.onicecandidate = null;
        pc.onaddstream = null;
    }
});

function disconnectPeerByClientSocketID(clientId) {
    let pc = myConnections[clientId];
    if (pc) {
        pc.close();
        pc.onicecandidate = null;
        pc.onaddstream = null;
        delete myConnections[clientId];
    }
    return true;
}

socket.on("client-message", message => {
    updateHistoryMessages(message);
});

function updateHistoryMessages(message) {
    message = message.trim();
    if (message != "") {
        let history = $("#history-messages").html();
        history = history + "<br> " + escapeHtml(message);
        $("#history-messages").html(history);
        $("#history-messages").animate({
                scrollTop: 9999
            },
            "slow"
        );
    }
}

function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

$("#btnSend").click(function () {
    let message = $("#txtAreaMessage").val();
    $("#txtAreaMessage").val("");

    message = message.trim();

    if (message != "") {
        let history = $("#history-messages").html();
        history =
            history +
            '<br><b class="analistHistory">' +
            analistName +
            " " +
            analistLastname +
            ":</b> " +
            escapeHtml(message);
        $("#history-messages").html(history);
        $("#history-messages").animate({
                scrollTop: 9999
            },
            "slow"
        );

        socket.emit(
            "analistMessage",
            JSON.stringify({
                token: token,
                message: message
            })
        );
    }
});

function connectSocket() {
    if (!socket) {
        socket = io(BASEURL).connect();
    }

    socket.on("connect", function () {
        const analistID = socket.id;

        /**
         * isso daqui eh bom mudar
         * enviar o token do analita, e registrar
         */
        socket.emit(
            "registerAnalist",
            JSON.stringify({
                token
            })
        );
    });
}
