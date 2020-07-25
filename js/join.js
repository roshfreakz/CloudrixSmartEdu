$(function () {
    GetLocalvideo();

    let RoomId = $('#hdnRoomId').val();
    let UserId = $('#hdnUserId').val();
    let PeerId = $('#hdnPeerId').val();
    let UserType = $('#hdnUserType').val();
    let StaffId = $('#hdnStaffPeerId').val();
    let FullName = $('#hdnFullName').val();
    let StaffName = $('#hdnStaffName').val();
    let mediaRecorder;
    let recordedBlobs;

    let peer = new Peer(PeerId, {
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
        console.log(UserType);
        if (UserType == "Student") ConnectwithStaff();
        
    });

    peer.on('error', function (err) {
        console.log("Error");
        console.log(err);
        if (err.type == "unavailable-id") {
            alert("User Already have an active session! Logging Out");
        } else if (err.type == "peer-unavailable") {
            alert("Class not started. Please come back later");
            window.location.href = "classrooms.php";
        } else {
            alert("Error: " + err.type);
        }
    });

    peer.on('connection', function (conn) {
        console.log('Connected to ' + conn.label);
        conn.on('close', function () {
            console.log("remote conn closed");
        });
    });

    peer.on('call', function (call) {
        call.answer(window.localStream);
        call.on('stream', function (stream) {
            onReceiveStudentStream(stream, call.peer);
            console.log("Call Started");
        });
        call.on('close', function () {
            console.log("Call Ended");
        });
        call.on('error', function (err) {
            console.log("Error in Stream" + err);
        });
    });

    function ConnectwithStaff() {
        let peerconn = peer.connect(StaffId, {
            label: FullName
        });
        peerconn.on('open', function () {
            console.log('Connected to ' + StaffName);
            ConnectCall();
        });
    }

    function ConnectCall() {
        let conncall = peer.call(StaffId, window.localStream, {
            metadata: {
                UserId: UserId,
                FullName: FullName
            }
        });
        conncall.on('stream', function (stream) {
            onReceiveStaffStream(stream);
            console.log("Call Started");
        });
        conncall.on('close', function () {
            console.log("Call Ended");
        });
        conncall.on('error', function (err) {
            console.log("Error in Call" + err);
            ConnectCall();
        });
    }

    $('#btnEndCall').on('click', function () {
        mediaRecorder.stop();
        window.localStream.getTracks().forEach(function (track) {
            track.stop();
        });

    });



    function GetLocalvideo() {
        if (navigator.mediaDevices === undefined) {
            navigator.mediaDevices = {};
        }

        if (navigator.mediaDevices.getUserMedia === undefined) {
            navigator.mediaDevices.getUserMedia = function (constraints) {
                let getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
                if (!getUserMedia) {
                    return Promise.reject(new Error('getUserMedia is not implemented in this browser'));
                }
                return new Promise(function (resolve, reject) {
                    getUserMedia.call(navigator, constraints, resolve, reject);
                });
            }
        }

        navigator.mediaDevices.getUserMedia({
            audio: {
                echoCancellation: true
            },
            video: true
        }).then(function (mediaStream) {
            window.localStream = mediaStream;
            let video = document.getElementById('selfvideo');
            video.srcObject = mediaStream;
            video.muted = true;
            video.onloadedmetadata = function (e) {
                video.play();
            };
            if (UserType == "Staff") startRecording();
        }).catch(function (err) {
            console.log(err.name + ": " + err.message);
        });
    }

    function mute() {
        window.localStream.getTracks().forEach(track => track.enabled = !track.enabled);
    }

    $('#btnScreenShare').on('click', function () {
        if (navigator.mediaDevices === undefined) {
            navigator.mediaDevices = {};
        }

        if (navigator.mediaDevices.getDisplayMedia === undefined) {
            navigator.mediaDevices.getDisplayMedia = function (constraints) {
                let getDisplayMedia = navigator.getDisplayMedia;
                if (!getDisplayMedia) {
                    return Promise.reject(new Error('getDisplayMedia is not implemented in this browser'));
                }
                return new Promise(function (resolve, reject) {
                    getDisplayMedia.call(navigator, constraints, resolve, reject);
                });
            }
        }

        navigator.mediaDevices.getDisplayMedia({
            video: true
        }).then(function (mediaStream) {
            window.localStream = mediaStream;
        }).catch(function (err) {
            console.log(err.name + ": " + err.message);
        });
    });

    function onReceiveStaffStream(mediaStream) {
        let video = document.getElementById('staffvideo');
        video.srcObject = mediaStream;
        video.onloadedmetadata = function (e) {
            video.play();
        };
    }

    function onReceiveStudentStream(mediaStream, id) {
        if (!document.getElementById("videobox" + id)) {
            let videobox = document.getElementById('videoContainer');
            let videocontainer = document.createElement('div');
            let video = document.createElement('video');
            videocontainer.className = "col-lg-3 col-6 video-box";
            video.className = "uservideo";
            videocontainer.id = "videobox" + id;
            video.id = "video" + id;
            videocontainer.appendChild(video);
            videobox.appendChild(videocontainer);
            video.srcObject = mediaStream;
            video.onloadedmetadata = function (e) {
                video.play();
            };
        } else {
            let video = document.getElementById('video' + id);
            video.srcObject = mediaStream;
            video.onloadedmetadata = function (e) {
                video.play();
            };
        }
    }

    function startRecording() {
        recordedBlobs = [];
        let options = {
            mimeType: 'video/webm;codecs=vp9,opus'
        };
        if (!MediaRecorder.isTypeSupported(options.mimeType)) {
            console.error(`${options.mimeType} is not supported`);
            options = {
                mimeType: 'video/webm;codecs=vp8,opus'
            };
            if (!MediaRecorder.isTypeSupported(options.mimeType)) {
                console.error(`${options.mimeType} is not supported`);
                options = {
                    mimeType: 'video/webm'
                };
                if (!MediaRecorder.isTypeSupported(options.mimeType)) {
                    console.error(`${options.mimeType} is not supported`);
                    options = {
                        mimeType: ''
                    };
                }
            }
        }

        try {
            mediaRecorder = new MediaRecorder(window.localStream, options);
        } catch (e) {
            console.error('Exception while creating MediaRecorder:', e);
            return;
        }

        mediaRecorder.onstop = (event) => {
            console.log('Recorder stopped: ', event);
            console.log('Recorded Blobs: ', recordedBlobs);
            UploadStreamFile(recordedBlobs);
        };
        mediaRecorder.ondataavailable = handleDataAvailable;
        mediaRecorder.start();
        console.log('MediaRecorder started', mediaRecorder);
    }

    function handleDataAvailable(event) {
        if (event.data && event.data.size > 0) {
            recordedBlobs.push(event.data);
        }
    }

    function UploadStreamFile(blob) {
        let filename = prompt("File Name");
        var objfile = new File(recordedBlobs, filename, {
            type: "video/webm",
            lastModified: new Date()
        })
        var formData = new FormData();
        formData.append('videofile', objfile);
        formData.append('VideoName', filename);
        formData.append('RoomId', RoomId);
        $.ajax({
            url: 'postupload.php',
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            type: 'post',
            success: function (result) {
                alert(result);
            }
        });
    }



})