$(function () {
    GetLocalvideo();

    var PeerId = $('#hdnPeerId').val();

    var peer = new Peer(PeerId, {
        host: "cloudrix-server.herokuapp.com",
        path: '/peerjs',
        debug: 3,
        config: {
            'iceServers': [{
                url: 'stun:stun1.l.google.com:19302'
            }, {
                url: 'turn:numb.viagenie.ca',
                credential: 'muazkh',
                username: 'webrtc@live.com'
            }]
        }
    });

    peer.on('open', function (id) {
        console.log("My ID: " + id);
        
    });
})

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


function GetLocalvideo() {
    var constraints = {
        audio: false,
        video: true
    };

    navigator.mediaDevices.getUserMedia(constraints)
        .then(function (mediaStream) {
            window.localStream = mediaStream;
            var video = document.querySelector('#localvideo');
            video.srcObject = mediaStream;
            video.onloadedmetadata = function (e) {
                video.play();
            };
        })
        .catch(function (err) {
            console.log(err.name + ": " + err.message);
        });
}

function CreateElement(arg) {
    var dhtml = '<div class="video-box" id="videobox' + arg + '"><video id="remvideo' + arg + '"></video></div>';
    $('#shortvideo').html();
}