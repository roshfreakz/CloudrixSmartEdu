var peer;
var UserId;
var Username;
var peerconn;
var conncall = [];
var connarrlst = [];
var AutoId;
var usrlst = [];

$(document).ready(function () {
    AutoId = $('#hdnAutoId').val();
    UserId = $('#hdnUserId').val();
    Username = $('#hdnName').val();

    peer = new Peer(UserId, {
        host: "quipersoft.com",
        path: 'peerserver/peerjs',
        debug: 3,
        config: { 'iceServers': [{ url: 'stun:stun1.l.google.com:19302' }, { url: 'turn:numb.viagenie.ca', credential: 'muazkh', username: 'webrtc@live.com' }] }
    });

    peer.on('open', function (id) {
        console.log("My ID: " + id);
        GetActiveUsers();
        ConnectActiveUsers();
    });

    peer.on('error', function (err) {
        console.log("Error");
        console.log(err);
        if (err.type == "unavailable-id") {
            alert("User Already have an active session! Logging Out");
            UpdateUserId();
        } else if (err.type == "peer-unavailable") {
            alert("User is not available at this moment. Please try again.");
            GetActiveUsers();
        } else {
            alert("Error: " + err.type);
        }
    });

    peer.on('connection', function (conn) {
        peerconn = conn;
        GetActiveUsers();
        $('#ChatArea').show();
        console.log('Connected to ' + conn.label);
        conn.on('data', handleMessage);
        conn.on('close', function () {
            console.log("remote conn closed");
            var chkelem = document.getElementById('Connsection' + conn.peer);
            if (chkelem) chkelem.remove();
        });
    });

    peer.on('call', function (call) {
        if (call.metadata.Type == "Video") {
            if (confirm('Accept Incoming Video Call?')) {
                requestLocalVideo({
                    success: function (stream) {
                        window.localStream = stream;
                        document.getElementById('localvideo').srcObject = stream;
                        call.answer(stream);
                    },
                    error: function (err) {
                        console.log("Cannot get access to your camera and video. Error: " + err);
                    }
                });
            }
        }
        else if (call.metadata.Type == "Audio") {
            if (confirm('Accept Incoming Audio Call?')) {
                requestLocalAudio({
                    success: function (stream) {
                        document.getElementById('localaudio').srcObject = stream;
                        call.answer(stream);
                    },
                    error: function (err) {
                        console.log("Cannot get access to your camera and video. Error: " + err);
                    }
                });
            }
        }
        else {
            if (confirm('Accept Incoming ScreenShare?')) {
                call.answer();
            }
        }
        call.on('stream', function (stream) {
            var Id = call.metadata.AutoId;
            conncall[Id] = call;
            var chkelem = document.getElementById('video' + call.peer);
            if (!chkelem) CreateVideoElem(call.peer, call.metadata.Name);
            console.log("Call Started");
            $('.btn-conn').hide();
            $('.btn-danger').show();
            if (call.metadata.Type == "Audio") {
                onReceiveStream(stream, call.peer, "audio");
            } else {
                onReceiveStream(stream, call.peer);
            }
        });
        call.on('close', function () {
            console.log("Call Ended");
            $('.btn-conn').show();
            $('.btn-danger').hide();
            var chkelem = document.getElementById('videobox' + call.peer);
            if (chkelem) chkelem.hidden = true;
            if (call.metadata.Type == "Video") {
                window.localStream.getTracks().forEach(function (track) { track.stop(); });
                document.getElementById('localvideo').srcObject = null;
            }
        });
        call.on('error', function (err) {
            console.log("Error in Stream" + err);
        });
    });
});

//User Connections
function GetActiveUsers() {
    $.ajax({
        url: $('#hdnURL').val() + "Home/DogetActiveUsers",
        method: "GET",
    }).done(function (result) {
        var data = result.data;
        var dhtml = "";
        for (var i = 0; i < data.length; i++) {
            if (data[i].Name != Username) {
                var chkelem = document.getElementById('Connsection' + data[i].UserId);
                if (!chkelem) {
                    dhtml += '<div class="alert alert-light connbtn" id="Connsection' + data[i].UserId + '">';
                    dhtml += '<p>' + data[i].Name + '</p>';
                    dhtml += '<button class="btn btn-success btn-conn btn-sm" id="btnvideocall' + data[i].UserId + '" onclick="LocalVideo(\'' + data[i].AutoId + '\',\'' + data[i].UserId + '\',\'' + data[i].Name + '\')"><i class="fa fa-video"></i></button>';
                    dhtml += '<button class="btn btn-info btn-conn btn-sm" id="btnaudiocall' + data[i].UserId + '" onclick="Localaudio(\'' + data[i].AutoId + '\',\'' + data[i].UserId + '\',\'' + data[i].Name + '\')"><i class="fa fa-microphone"></i></button>';
                    dhtml += '<button class="btn btn-primary btn-conn btn-sm" id="btnscreenshare' + data[i].UserId + '" onclick="ScreenShare(\'' + data[i].AutoId + '\',\'' + data[i].UserId + '\',\'' + data[i].Name + '\')"><i class="fa fa-chalkboard"></i></button>';
                    dhtml += '<button class="btn btn-danger btn-sm" id="btnendscreenshare' + data[i].UserId + '" onclick="EndCall(\'' + data[i].AutoId + '\')"><i class="fa fa-store-slash"></i></button>';
                    dhtml += '</div>';
                }
            }
        }
        if (data.length > 1) $('#Users_List').append(dhtml);
    });
}

function ConnectActiveUsers() {
    $.ajax({
        url: $('#hdnURL').val() + "Home/DogetActiveUsers",
        method: "GET",
    }).done(function (result) {
        var data = result.data;
        for (var i = 0; i < data.length; i++) {
            if (data[i].Name != Username) {
                ConnectUser(data[i].UserId, data[i].Name);
            }
        }
    });
}

function UpdateUserId() {
    $.ajax({
        url: $('#hdnURL').val() + "Home/DoUpdateUserId",
        method: "GET",
        data: ({ AutoId: AutoId }),
    }).done(function (result) {
        if (result.data != null) {
            window.location.href = $('#hdnURL').val() + "Login";
        }
    });
}

function ConnectUser(peerid, peername) {
    peerconn = peer.connect(peerid, { label: Username });
    peerconn.on('data', handleMessage);
    peerconn.on('open', function () {
        console.log('Connected to ' + peername);
        //handlestatus(peername + " Connected");
        $('#ChatArea').show();
    });
}

//Video
function LocalVideo(Id, peerid, peername) {
    requestLocalVideo({
        success: function (stream) {
            window.localStream = stream;
            document.getElementById('localvideo').srcObject = stream;
            ConnectCall(Id, peerid, peername, "Video")
        },
        error: function (err) {
            console.log("Cannot get access to your camera and video. Error: " + err);
        }
    });
}

function requestLocalVideo(callbacks) {
    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
    navigator.getUserMedia({
        audio: true,
        video: true
    }, callbacks.success, callbacks.error);
}

//Audio
function Localaudio(Id, peerid, peername) {
    requestLocalAudio({
        success: function (stream) {
            window.localStream = stream;
            document.getElementById('localaudio').srcObject = stream;
            ConnectCall(Id, peerid, peername, "Audio")
        },
        error: function (err) {
            console.log("Cannot get access to your camera and audio. Error: " + err);
        }
    });
}

function requestLocalAudio(callbacks) {
    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
    navigator.getUserMedia({
        audio: true,
        video: false
    }, callbacks.success, callbacks.error);
}

//ScreenShare
function ScreenShare(Id, peerid, peername) {
    requestScreenShare({
        success: function (stream) {
            window.localStream = stream;
            //document.getElementById('localvideo').srcObject = stream;
            ConnectCall(Id, peerid, peername, "Screen");
        },
        error: function (err) {
            console.log("Cannot get access to your Screen. Error: " + err);
        }
    });
}

function requestScreenShare(callbacks) {
    var displayMediaStreamConstraints = { video: true };
    if (navigator.mediaDevices.getDisplayMedia) {
        navigator.mediaDevices.getDisplayMedia(displayMediaStreamConstraints)
            .then(callbacks.success)
            .catch(callbacks.error);
    } else {
        navigator.getDisplayMedia(displayMediaStreamConstraints)
            .then(callbacks.success)
            .catch(callbacks.error);
    }
}

//Call
function ConnectCall(Id, peerid, peername, Type) {
    conncall[Id] = peer.call(peerid, window.localStream, { metadata: { AutoId: AutoId, Name: Username, Type: Type } });
    var chkelem = document.getElementById('video' + peerid);
    if (!chkelem) CreateVideoElem(peerid, peername);
    if (Type == "Screen") {
        $('.btn-conn').hide();
        $('.btn-danger').show();
    }
    conncall[Id].on('stream', function (stream) {
        if (Type == "Audio") {
            onReceiveStream(stream, peerid, "audio");
        } else if (Type == "Video") {
            onReceiveStream(stream, peerid);
        }
        console.log("Call Started");
        $('.btn-conn').hide();
        $('.btn-danger').show();
    });
    conncall[Id].on('close', function () {
        console.log("Call Ended");
        $('.btn-conn').show();
        $('.btn-danger').hide();
        var chkelem = document.getElementById('videobox' + peerid);
        if (chkelem) chkelem.hidden = true;
        window.localStream.getTracks().forEach(function (track) { track.stop(); });
        document.getElementById('localvideo').srcObject = null;
    });
    conncall[Id].on('error', function (err) {
        console.log("Error in Call" + err);
    });
}

function EndCall(Id) {
    window.localStream.getTracks().forEach(function (track) { track.stop(); });
    document.getElementById('localaudio').srcObject = null;
    conncall[Id].close();
}

//Element
function CreateVideoElem(id, name) {
    var videobox = document.getElementById('videoContainer');
    var videocontainer = document.createElement('div');
    var video = document.createElement('video');
    var audio = document.createElement('audio');
    var textelam = document.createElement('span');
    textelam.innerHTML = name;
    textelam.className = "videotext";
    videocontainer.className = "col-md-3 col-sm-6 col-12 p-0";
    videocontainer.id = "videobox" + id;
    video.className = "videoelem";
    video.id = "video" + id;
    audio.id = "audio" + id;
    var img = $('#hdnURL').val() + "Content/Images/user1.jpg";
    video.setAttribute('poster', img);
    videocontainer.appendChild(video);
    videocontainer.appendChild(audio);
    videocontainer.appendChild(textelam);
    videobox.appendChild(videocontainer);
}

function onReceiveStream(stream, id, type) {
    if (type == "audio") {
        var audio = document.getElementById("audio" + id);
        audio.srcObject = stream;
        audio.autoplay = true;
        audio.muted = false;
        //audio.controls = true;

    } else {
        var video = document.getElementById("video" + id);
        video.srcObject = stream;
        video.autoplay = true;
        video.muted = false;
    }
    var chkelem = document.getElementById('videobox' + id);
    if (chkelem) chkelem.hidden = false;
}

//TextMessages
function SendMessage() {
    var Message = $('#Message').val();
    if (Message != "") {
        var data = {
            from: Username,
            text: Message
        };
        peerconn.send(data);
        handleMessage(data);
        $('#Message').val('');
    } else {
        $('#Message').addClass('is-invalid');
    }
}

function handleMessage(data) {
    var messageHTML = "";
    if (data.from == Username) {
        messageHTML = '<div class="list-group-item text-right">';
        messageHTML += '<p>You</p><h4>' + data.text + '</h4></div>';
    } else {
        messageHTML = '<div class="list-group-item text-left">';
        messageHTML += '<p>' + data.from + '</p><h4>' + data.text + '</h4></div>';
    }
    $("#MsgBox").append(messageHTML);
}

function handlestatus(data) {
    var messageHTML = '<div class="list-group-item text-right"><p>' + data + '</p></div>';
    $("#MsgBox").append(messageHTML);
}
