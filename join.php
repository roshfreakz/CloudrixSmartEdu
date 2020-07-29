<?php

if (!isset($_POST["RoomId"])) {
    echo "<script>alert('Class Room Closed!'); window.location.href='room.php';</script>";
}

?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('_header.php'); ?>

<body>

    <div class="wrapper">
        <a class="page-title" href="room.php">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-arrow-left menu-icon"></i>
            </span>
            Back
        </a>
        <?php if ($_SESSION["UserType"] == "Student") { ?>
            <div class="row mt-4">
                <div class="col">
                    <div class="video-box">
                        <video class="staffvideo" id="staffvideo"></video>
                    </div>
                </div>
            </div>
        <?php }
        if ($_SESSION["UserType"] == "Staff") { ?>
            <div class="videoGrid mt-4" id="videoGrid">

            </div>
        <?php } ?>
    </div>

    <?php require_once('_modal.php'); ?>

    <footer>
        <?php if ($_SESSION["UserType"] == "Staff") { ?>
            <div class="btn-section">
                <button class="btn btn-gradient-danger" id="btnEndCall">
                    <i class="mdi mdi-video-off"></i>
                    End Class
                </button>
            </div>
        <?php } ?>
        <video class="selfvideo" id="selfvideo"></video>
    </footer>

    <?php require_once('_footer.php'); ?>
    <script src="js/adapter.js"></script>
    <script src="js/peer.min.js"></script>
    <script>
        $(function() {

            let mediaRecorder;
            let recordedBlobs;

            //Self Details
            let PeerId = "<?php echo $_SESSION["PeerId"]; ?>";
            let FullName = "<?php echo $_SESSION["FullName"]; ?>";
            let UserType = "<?php echo $_SESSION["UserType"]; ?>";

            //Room Details
            let RoomId = "<?php echo $_POST["RoomId"]; ?>";
            let RoomName = "<?php echo $_POST["RoomName"]; ?>";
            let RoomType = "<?php echo $_POST["RoomType"]; ?>";

            //Staff Details
            let StaffId = "<?php echo $_POST["StaffId"]; ?>";
            let StaffName = "<?php echo $_POST["StaffName"]; ?>";



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

            peer.on('open', function(id) {
                console.log(id + " - " + UserType);
                if (UserType == "Staff" && RoomType == "Screen Class") GetLocalScreen();
                else GetLocalvideo();
            });

            peer.on('error', function(err) {
                console.log("Error");
                console.log(err);
                if (err.type == "unavailable-id") {
                    alert("User Already have an active session! Logging Out");
                } else if (err.type == "peer-unavailable") {
                    alert("Class not started. Please come back later");
                    window.location.href = "room.php";
                } else {
                    alert("Error: " + err.type);
                }
            });

            //Staff
            peer.on('call', function(call) {
                call.answer(window.localStream);
                const video = document.createElement('video');
                call.on('stream', function(stream) {
                    addVideoStream(video, stream);
                    console.log("Call Started");
                });
                call.on('close', function() {
                    console.log("Call Ended");
                    video.remove();
                });
                call.on('error', function(err) {
                    console.log("Error in Stream" + err);
                    video.remove();
                });
            });

            //Student
            function ConnectCall() {
                console.log(StaffId);
                let conncall = peer.call(StaffId, window.localStream, {
                    metadata: {
                        FullName: FullName
                    }
                });
                const video = document.getElementById('staffvideo');
                conncall.on('stream', function(stream) {
                    console.log("Call Started");
                    addVideoStream(video, stream);
                });
                conncall.on('close', function() {
                    alert("Class Ended");
                    window.location.href = "room.php";
                });
                conncall.on('error', function(err) {
                    console.log("Error in Call" + err);
                    ConnectCall();
                });
            }

            $('#btnEndCall').on('click', function() {
                mediaRecorder.stop();
                window.localStream.getTracks().forEach(function(track) {
                    track.stop();
                });
            });

            function mute() {
                window.localStream.getTracks().forEach(track => track.enabled = !track.enabled);
            }

            function GetLocalvideo() {
                if (navigator.mediaDevices === undefined) {
                    navigator.mediaDevices = {};
                }

                if (navigator.mediaDevices.getUserMedia === undefined) {
                    navigator.mediaDevices.getUserMedia = function(constraints) {
                        let getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
                        if (!getUserMedia) {
                            return Promise.reject(new Error('Camera is not available at this moment'));
                        }
                        return new Promise(function(resolve, reject) {
                            getUserMedia.call(navigator, constraints, resolve, reject);
                        });
                    }
                }

                navigator.mediaDevices.getUserMedia({
                    audio: {
                        echoCancellation: true
                    },
                    video: true
                }).then(function(mediaStream) {
                    window.localStream = mediaStream;
                    onReceivelocalstream(mediaStream);
                }).catch(function(err) {
                    console.log(err.name + ": " + err.message);
                    alert(err.name + ": " + err.message);
                });
            }

            function GetLocalScreen() {
                if (navigator.mediaDevices === undefined) {
                    navigator.mediaDevices = {};
                }

                if (navigator.mediaDevices.getDisplayMedia === undefined) {
                    navigator.mediaDevices.getDisplayMedia = function(constraints) {
                        let getDisplayMedia = navigator.getDisplayMedia;
                        if (!getDisplayMedia) {
                            return Promise.reject(new Error('Screen Sharing not supported in this device'));
                        }
                        return new Promise(function(resolve, reject) {
                            getDisplayMedia.call(navigator, constraints, resolve, reject);
                        });
                    }
                }

                navigator.mediaDevices.getDisplayMedia({
                    video: true
                }).then(function(mediaStream) {
                    window.localStream = mediaStream;
                    onReceivelocalstream(mediaStream);
                }).catch(function(err) {
                    console.log(err.name + ": " + err.message);
                    alert(err.name + ": " + err.message);
                });
            }

            function onReceivelocalstream(mediaStream) {
                let video = document.getElementById('selfvideo');
                video.srcObject = mediaStream;
                video.muted = true;
                video.onloadedmetadata = function(e) {
                    video.play();
                };
                if (UserType == "Staff") startRecording();
                if (UserType == "Student") ConnectCall();
            }

            function addVideoStream(video, stream) {
                console.log(video);
                video.srcObject = stream
                video.addEventListener('loadedmetadata', () => {
                    video.play()
                });
                if (UserType == "Staff") {
                    let videoGrid = document.getElementById('videoGrid');
                    videoGrid.append(video)
                }
            }

            //Recording Phase
            function startRecording() {
                recordedBlobs = [];
                try {
                    mediaRecorder = new MediaRecorder(window.localStream);
                } catch (e) {
                    console.error('Exception while creating MediaRecorder:', e);
                }
                mediaRecorder.start();
                console.log('MediaRecorder started', mediaRecorder);
                mediaRecorder.ondataavailable = (event) => {
                    if (event.data && event.data.size > 0) {
                        recordedBlobs.push(event.data);
                    }
                };
                mediaRecorder.onstop = (event) => {
                    console.log('Recorder stopped: ', event);
                    UploadStreamFile(recordedBlobs);
                };
            }

            //Upload Recording
            function UploadStreamFile(blob) {
                $('#LoadingModel').modal('show');
                var objfile = new File(recordedBlobs, RoomName, {
                    type: "video/webm",
                    lastModified: new Date()
                })
                var formData = new FormData();
                formData.append('videofile', objfile);
                formData.append('VideoName', RoomName);
                formData.append('RoomId', RoomId);
                $.ajax({
                    url: 'helper/_video.php',
                    type: 'POST',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    beforeSend: ShowLoadingFn
                }).always(function(result) {
                    setTimeout(() => {
                        HideLoadingFn();
                        alert(result);
                        window.location.href = "room.php";
                    }, 1000);
                });
            }


        })
    </script>
</body>

</html>