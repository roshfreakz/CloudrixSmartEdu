<?php

if (!isset($_POST["RoomId"])) {
    echo "<script>alert('Class Room Closed!');" .
        "window.location.href='classrooms.php';</script>";
}

?>
<!DOCTYPE html>
<html lang="en">
<?php require('header.php'); ?>

<body>
    <input type="hidden" id="hdnPeerId" value="<?php echo $_SESSION["PeerId"]; ?>">
    <input type="hidden" id="hdnUserId" value="<?php echo $_SESSION["UserId"]; ?>">
    <input type="hidden" id="hdnFullName" value="<?php echo $_SESSION["FullName"]; ?>">
    <input type="hidden" id="hdnUserType" value="<?php echo $_SESSION["UserType"]; ?>">
    <input type="hidden" id="hdnRoomId" value="<?php echo $_POST["RoomId"]; ?>">
    <input type="hidden" id="hdnStaffPeerId" value="<?php echo $_POST["StaffPeerId"]; ?>">
    <input type="hidden" id="hdnStaffName" value="<?php echo $_POST["StaffName"]; ?>">
    <div class="wrapper">
        <a class="page-title mb-4" href="classrooms.php">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-arrow-left menu-icon"></i>
            </span>
            Back
        </a>
        <?php if ($_SESSION["UserType"] == "Student") { ?>
            <div class="row">
                <div class="col video-box">
                    <video class="staffvideo" id="staffvideo"></video>
                </div>
            </div>
        <?php }
        if ($_SESSION["UserType"] == "Staff") { ?>
            <div class="row" id="videoContainer">

            </div>
            <div class="row">

            </div>
        <?php } ?>
    </div>

    <footer>
        <div class="btn-section">
            <!-- <button class="btn btn-gradient-primary" id="btnScreenShare">
                <i class="mdi mdi-airplay"></i>
            </button>          
            <button class="btn btn-gradient-primary">
                <i class="mdi mdi-microphone"></i>
            </button> -->
            <button class="btn btn-gradient-danger" id="btnEndCall">
                <i class="mdi mdi-video-off"></i>
                End Call
            </button>
        </div>
        <video class="selfvideo" id="selfvideo"></video>
    </footer>


    <?php require('footer.php'); ?>
    <script src="js/adapter.js"></script>
    <script src="js/peer.min.js"></script>
    <script src="js/join.js"></script>
</body>

</html>