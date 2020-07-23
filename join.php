<?php

if(!isset($_POST["RoomId"])){
    echo "<script>alert('Class Room Closed!');".
    "window.location.href='classrooms.php';</script>";
}

?>
<!DOCTYPE html>
<html lang="en">
<?php require('header.php'); ?>

<body>
    <input type="hidden" id="hdnRoomId" value="<?php echo $_POST["RoomId"]; ?>">
    <input type="hidden" id="hdnPeerId" value="<?php echo $_SESSION["PeerId"]; ?>">
    <div class="container-scroller joinroom">
        <?php require('navbar.php'); ?>
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <a class="page-title" href="index.php">
                            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                                <i class="mdi mdi-arrow-left-bold"></i>
                            </span>
                            Back
                        </a>
                    </div>
                    <div class="row videosection" id="videosection">
                        <div class="col-lg-9 col-12 grid-margin">
                            <div class="card">
                                <div class="card-body mainvideo-card">
                                    <div class="video-box">
                                        <video src="" id="localvideo"></video>
                                    </div>
                                    <div class="btn-section">
                                        <button class="btn btn-gradient-primary">
                                            <i class="mdi mdi-airplay"></i>
                                        </button>
                                        <button class="btn btn-gradient-primary">
                                            <i class="mdi mdi-phone"></i>
                                        </button>
                                        <button class="btn btn-gradient-primary">
                                            <i class="mdi mdi-microphone"></i>
                                        </button>
                                        <button class="btn btn-gradient-primary">
                                            <i class="mdi mdi-video"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-12 grid-margin">
                            <div class="card">
                                <div class="card-body shortvideo-card" id="shortvideo">
                                   
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php require('footer.php'); ?>
    <script src="js/adapter.js"></script>
    <script src="js/peer.min.js"></script>
    <script src="js/join.js"></script>
</body>

</html>