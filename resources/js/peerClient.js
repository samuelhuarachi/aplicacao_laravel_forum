// const BASEURL = 'https://quiet-beach-73356.herokuapp.com'
// const BASEURL = 'http://localhost:3001'

function checkBrowser() {
    let c = navigator.userAgent.search("Chrome");
    let f = navigator.userAgent.search("Firefox");
    let m8 = navigator.userAgent.search("MSIE 8.0");
    let m9 = navigator.userAgent.search("MSIE 9.0");
    let browser;
    if (c > -1) {
        browser = "Chrome";
    } else if (f > -1) {
        browser = "Firefox";
    } else if (m9 > -1) {
        browser = "MSIE 9.0";
    } else if (m8 > -1) {
        browser = "MSIE 8.0";
    }
    return browser;
}

function listItensPublicPrice() {
    historyMessageAdd('Bem vindo ao chat')
}

listItensPublicPrice()

let browserGlobal = checkBrowser();

import io from "socket.io-client";

require("./clients/btnCredits");
require("./clients/btnCreditsGreen");
require("./clients/btnCreateAccoundBlue");
require("./clients/btnRegisterNewClient");
require("./clients/btnLoginClient");
require("./clients/btnClientAccount");
require("./clients/btnLogoutClient");
require("./clients/btnLoginRegister");
require("./clients/goPayment");
require("./clients/pagseguro");
require("./clients/btnStopPrivateSession");
require("./clients/btnTransactions");
require("./clients/linkForgotPassword");
require("./clients/btnForgotLogin");
require("./clients/btnRedefinePassword");
require("./clients/linkForgotPasswordBack");
require("./clients/btnSessions");
require("./clients/btnGift");
require("./clients/btnGiftYesNo");
require("./clients/btnMinimizeChat");
require("./clients/btnMaximizeChat");

$("#changeClientPassword").val("");

const {
    UpdateChallgenteInfo
} = require("./clients/class/UpdateChallgenteInfo");


const DisplayCostSessionEstimate = require("./clients/class/DisplayCostSessionEstimate");
const DisplayTimeEstimate = require("./clients/class/DisplayTimeEstimate");
let displayCostSessionEstimate = new DisplayCostSessionEstimate.DisplayCostSessionEstimate(
    analistPricePerHourGlobal
);
let displayTimeEstimate = new DisplayTimeEstimate.DisplayTimeEstimate();
const {
    CamgirlTabs
} = require("./clients/class/CamgirlTabs");

new CamgirlTabs();

const {
    ListGirlTabsControl
} = require("./clients/class/ListGirlTabsControl");

new ListGirlTabsControl();

const {
    Helper
} = require("./clients/Helper");

let helperInstace = new Helper();
helperInstace.ajustPlayButton();

if (browserGlobal == "Firefox") {
    $("#playImage").hide();
}

if (browserGlobal !== "Firefox") {
    window.addEventListener("resize", function () {
        helperInstace.ajustPlayButton();
    });
}

$("#message-default-client").click(function () {
    $("#message-default-client").css("display", "none");
});

$(".alert").click(function () {
    $(this).hide();
});

const updateCreditsValue = require("./clients/updateCreditsValue");

$(".toast").toast("show");

// Load Recaptcha
var onloadCallback = function () {
    const recaptchaRegister = document.getElementById("recaptchaRegister");
    const recaptchaLogin = document.getElementById("recaptchaLogin");
    const recaptchaForgotLogin = document.getElementById(
        "recaptchaForgotLogin"
    );
    const redefinePassword = document.getElementById("redefinePassword");

    if (recaptchaRegister) {
        grecaptcha.render("recaptchaRegister", {
            sitekey: "6LcSuugUAAAAACy-8wrNOLoQOLcL1cMxQScS-oeW"
        });
    }

    if (recaptchaLogin) {
        grecaptcha.render("recaptchaLogin", {
            sitekey: "6LcSuugUAAAAACy-8wrNOLoQOLcL1cMxQScS-oeW"
        });
    }

    if (recaptchaForgotLogin) {
        grecaptcha.render("recaptchaForgotLogin", {
            sitekey: "6LcSuugUAAAAACy-8wrNOLoQOLcL1cMxQScS-oeW"
        });
    }

    if (redefinePassword) {
        grecaptcha.render("redefinePassword", {
            sitekey: "6LcSuugUAAAAACy-8wrNOLoQOLcL1cMxQScS-oeW"
        });
    }
};

window.onloadCallback = onloadCallback;

function connectSocket() {
    if (!socket) {
        socket = io(BASEURL).connect();
    }
    socket.on("connect", function () {
        socket.emit("join-in-room", {
            token,
            clientRoom
        });
        const clientID = socket.id;

    });
}

if (typeof clientRoom != "undefined" && clientRoom) {
    connectSocket();
}

let friendsVideo = document.getElementById("friendsVideo");

/**
 * cria objeto de video
 */
// let streamAnalistVideo = document.createElement('video');
// document.getElementById('streamAnalist').appendChild(streamAnalistVideo)

/**
 * essa variavel acho que precisa tirar, ela se torna inutil pelo m
 * meu ver
 */
const clientId = uuidv4();
let time = 0;

let servers = {
    iceServers: [
        // {
        //     urls: 'stun:stun.l.google.com:19305'
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
        // {
        //     urls: "turn:numb.viagenie.ca:3478",
        //     credential: "abc123321",
        //     username: "batman.batmann@gmail.com"
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

let pc = new RTCPeerConnection(servers);

pc.onicecandidate = event => {
    if (event.candidate) {
        //iceList.push(event.candidate)
        socket.emit(
            "sendClientICE",
            JSON.stringify({
                ice: event.candidate
            })
        );
    } else {
        //iceReady = true
    }
};

// setInterval(function () {
//     console.log(iceList)
// }, 5000);

// socket.on('analist_need_client_ice', function (data) {
//     if (iceReady) {
//         socket.emit('client_send_ice_to_analist',
//             JSON.stringify({
//                 iceList
//             }))
//     }
// })

// pc.onaddstream = (event => {
//     console.log(event)
//     friendsVideo.srcObject = event.stream
// })

let inboundStream = null;
let streamRemoteSave = null;

$("#playImage").click(function () {
    $("#playImage").fadeOut();
    let tryVideo = setInterval(function () {
        if (streamRemoteSave) {
            friendsVideo.srcObject = streamRemoteSave;
            clearInterval(tryVideo);
        } else {
            //console.log("tentando")
        }
    }, 500);
});

pc.onaddstream = event => {
    if (event.stream) {
        streamRemoteSave = event.stream;
        //friendsVideo.srcObject = event.stream
        if (browserGlobal == "Firefox") {
            friendsVideo.srcObject = event.stream;
        }
    }
};

// pc.ontrack = ev => {
//     if (ev.streams && ev.streams[0]) {
//         streamRemoteSave = ev.streams[0];
//         if (browserGlobal == "Firefox") {
//             //if (friendsVideo.srcObject) return;
//             friendsVideo.srcObject = ev.streams[0];
//         }
//     }
//     // } else {
//     //     if (!inboundStream) {
//     //         inboundStream = new MediaStream();
//     //         friendsVideo.srcObject = inboundStream;
//     //     }
//     //     inboundStream.addTrack(ev.track);
//     // }
// };

setTimeout(function () {
    if (typeof clientRoom != "undefined" && clientRoom) {
        socket.emit("INeedAnalistOffer", clientId);
    }
}, 500);

require("./clients/btnPrivateSession");

function uuidv4() {
    return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g, function (c) {
        var r = (Math.random() * 16) | 0,
            v = c == "x" ? r : (r & 0x3) | 0x8;
        return v.toString(16);
    });
}

$("#btnSend").click(function () {

    if (!token) {
        $('#modalLoginOrRegisterHTML').modal()
        return
    }

    let message = $("#txtAreaMessage").val();

    $("#txtAreaMessage").val("");

    message = message.trim();

    if (message != "") {
        // let history = $("#history-messages").html();


        // history = history + "<br><b>Eu:</b> " + escapeHtml(message);
        // $("#history-messages").html(history);
        // $("#history-messages").animate({
        //         scrollTop: 9999
        //     },
        //     "slow"
        // );

        historyMessageAdd("<br><b>Eu:</b> " + escapeHtml(message))

        const messageObject = {
            message,
            token
        };

        socket.emit("clientMessage", messageObject);
    }
});

function historyMessageAdd(message) {
    let history = $("#history-messages").html();

    history = history + message;
    $("#history-messages").html(history);
    $("#history-messages").animate({
            scrollTop: 9999
        },
        "slow"
    );
}

function updateHistoryMessages(message) {
    message = message.trim();

    if (message != "") {
        let history = $("#history-messages").html();
        history = history + "<br>" + escapeHtml(message);
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

let listenerClientIsOnlineInterval = null;
let listenerClientIsOnline = function () {
    clearInterval(listenerClientIsOnlineInterval);
    listenerClientIsOnlineInterval = setInterval(function () {
        // Avisa o sistema que o client esta online
        socket.emit("client-listener-is-online", {
            token
        });
    }, 5000);
};

// const aproximateCostLoad = () => {
//     $("#session_cost_aproximate").show()
//     let seconds = 1;
//     setInterval(function () {
//         if (analistPricePerHourGlobal) {

//             let price = 0;
//             let pricePerSeconds = (analistPricePerHourGlobal / 60) / 60

//             if (seconds <= 60) {
//                 price = pricePerSeconds * 60
//                 $("#session_cost_aproximate").html("Aproximado: -" + price.toFixed(2).toString())
//             } else {
//                 price = seconds * pricePerSeconds
//                 $("#session_cost_aproximate").html("Aproximado: -" + price.toFixed(2).toString())
//             }

//             seconds = seconds + 1
//         }

//     }, 1000)
// }

if (challengeDataGlobal) {
    const classUpdateChallgenteInfo = new UpdateChallgenteInfo()
    classUpdateChallgenteInfo.render(challengeDataGlobal)
}

if (socket) {
    require("./clients/_client-recept-error");


    socket.on("challenge_info", data => {
        const classUpdateChallgenteInfo = new UpdateChallgenteInfo()

        classUpdateChallgenteInfo.render(data)

        updateCreditsValue.go();
    })

    socket.on("client-stop-session", () => {
        $("#btnPrivateSession").css("display", "block");
        $("#btnStopPrivateSession").css("display", "none");
        $("#btnPrivateSession").prop("disabled", false);
        clearInterval(listenerClientIsOnline);
        updateCreditsValue.go();
        displayCostSessionEstimate.stop();
        displayTimeEstimate.stop();
    });

    socket.on("analist-request-stop-session", function () {
        $("#btnStopPrivateSession").prop("disabled", true);
        $("#btnStopPrivateSession").css("display", "none");
        $("#btnPrivateSession").prop("disabled", false);
        $("#btnPrivateSession").css("display", "block");
        clearInterval(listenerClientIsOnline);
        updateCreditsValue.go();
        displayCostSessionEstimate.stop();
        displayTimeEstimate.stop();
    });

    socket.on("sendAnalistOfferToClient", data => {
        var msg = data;
        msg = JSON.parse(msg);

        if (time == 0) {
            pc.setRemoteDescription(new RTCSessionDescription(msg.sdp))
                .then(() => pc.createAnswer())
                .then(answer => pc.setLocalDescription(answer))
                .then(() =>
                    socket.emit(
                        "sendClientSDP",
                        JSON.stringify({
                            clientId: msg.clientId,
                            sdp: pc.localDescription
                        })
                    )
                );

            time = 1;
        }
    });

    socket.on("message-default-to-client", message => {
        $("#message-default-client").css("display", "block");
        $("#message-default-client").html(
            message +
            '<button style="margin-top:3px;" type="button" class="close"><span aria-hidden="true">&times;</span></button>'
        );
        
        let body = $("html, body");
        body.stop().animate({
            scrollTop: 0
        }, 500, 'swing', function () {});
    });

    socket.on("reconnect", function () {
        if (typeof clientRoom != "undefined" && clientRoom) {
            socket.emit("join-in-room", {
                token,
                clientRoom
            });
        }
    });

    socket.on("receiveAnalistICE", function (data) {
        let msg = JSON.parse(data);
        //console.log(pc)
        // console.log(msg)
        pc.addIceCandidate(new RTCIceCandidate(msg.ice));
    });

    socket.on("receive-client-message", message => {
        updateHistoryMessages(message);
    });

    socket.on("client-private-session-started", response => {
        if (response) {
            // esconder botao que inicou a sessao
            $("#btnPrivateSession").css("display", "none");
            // habilita o botao de encerrar a live
            $("#btnStopPrivateSession").css("display", "block");
            listenerClientIsOnline();
            displayCostSessionEstimate.start();
            displayTimeEstimate.start();
        }
    });

    socket.on("update_credits", () => {
        updateCreditsValue.go();
    })

    // socket.on("challengeInfoClient", function (data) {

    //     $("#challangeInfo").html(`
    //         <div class="mb-3">
    //             <button class="btn btn-outline-primary">enviar 10 <i class="fas fa-gem"></i></button>
    //             <button class="btn btn-outline-primary">enviar 20 <i class="fas fa-gem"></i></button>
    //             <button class="btn btn-outline-primary">enviar 30 <i class="fas fa-gem"></i></button>
    //             <button class="btn btn-outline-primary">enviar 50 <i class="fas fa-gem"></i></button>
    //             <button class="btn btn-outline-primary">enviar 100 <i class="fas fa-gem"></i></button>
    //             <button class="btn btn-outline-primary">enviar 200 <i class="fas fa-gem"></i></button>
    //             <button class="btn btn-outline-primary">Outro valor <i class="fas fa-gem"></i></button>
    //         </div>

    //         <p>Mostro os peitos por 100 creditos (25 recebidos até o momento)</p>
    //         <div class="progress">
    //             <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
    //         </div>
    //     `)
    // })
}
