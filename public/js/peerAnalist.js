/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/peerAnalist.js":
/*!*************************************!*\
  !*** ./resources/js/peerAnalist.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// const BASEURL = 'http://localhost:3001';
// import io from 'socket.io-client';
// //var Peer = require('simple-peer')
// const socket = io(BASEURL);
// const axios = require('axios');
// const { ConfigureIsOnline } = require('./common')
// console.log(location);
// location.hash === '#init'
// // navigator.getUserMedia = (navigator.getUserMedia 
// //     || navigator.webkitGetUserMedia 
// //     || navigator.mozGetUserMedia 
// //     || navigator.msgGetUserMedia);
// // navigator.getUserMedia({video: true, audio: false}, function(stream) {
// //     var peer = new Peer({
// //         initiator: true,
// //         trickle: false,
// //         stream: stream,
// //         config: {
// //             iceServers: [{ 'url': 'stun:stun.l.google.com:19302' }]
// //         }
// //     })
//     // peer.on('signal', function (data) {
//     //     console.log("foi");
//     //     document.getElementById('analistID').value = JSON.stringify(data)
//     //     socket.emit('analist-id', JSON.stringify(data))
//     // })
//     // document.getElementById('connect').addEventListener('click', function() {
//     //     var otherID = JSON.parse(document.getElementById('clientID').value)
//     //     peer.signal(otherID)
//     // })
//     // document.getElementById('send').addEventListener('click', function() {
//     //     var yourMessage = document.getElementById('yourMessage').value
//     //     peer.send(yourMessage)
//     // })
//     // peer.on('data', function(data) {
//     //     document.getElementById('messages').textContent += data + '\n'
//     // })
//     // peer.on('stream', function(stream) {
//     //     var video = document.createElement('video')
//     //     document.body.appendChild(video)
//     //     video.srcObject = stream
//     //     video.play()
//     // })
// // }, function(err) {
// //     console.error(err)
// // })
// socket.on('connect', function() {
//     // $("#msg").append("connectd: " + socket.id + "<br>");
//     socket.emit('msg', 'I am connected ' + socket.id);
// })
// var url = BASEURL + '/analist/(19)%2092323-1300';
// axios.get(url)
// .then(response => {
//     // ConfigureIsOnline(response.data.isOnline)
//     console.log(response.data.isOnline)
// })
// .catch(function (error) {
//     // handle error
//     console.log(error);
// })
// // $("#onlineButton").click(function() {
// //     socket.emit('make-online', 'onlinedd v')
// // })
// /**
//  * 
//  * ddddddddddddddddddddddddddddddddddddddddddddddd
//  * 
//  */

/***/ }),

/***/ 1:
/*!*******************************************!*\
  !*** multi ./resources/js/peerAnalist.js ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /home/samuel/dev/forumt/forum/resources/js/peerAnalist.js */"./resources/js/peerAnalist.js");


/***/ })

/******/ });