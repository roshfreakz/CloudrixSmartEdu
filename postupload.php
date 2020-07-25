<?php
require('config.php');
session_start();

if (isset($_FILES["videofile"])) {
    if (0 < $_FILES['videofile']['error']) {
        echo 'Error: ' . $_FILES['videofile']['error'] . '<br>';
    } else {
        $RoomId = $_POST["RoomId"];
        $VideoName = $_POST["VideoName"];
        $filename = $VideoName . date('m-d-Y_hia') . ".webm";
        $VideoPath = 'uploads/' . $filename;
        move_uploaded_file($_FILES['videofile']['tmp_name'], $VideoPath);

        //db insert
        $sql = ' UPDATE tbl_room SET  VideoName = :VideoName, VideoPath = :VideoPath, Status = 0 where RoomId = :RoomId ';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':RoomId', $RoomId, PDO::PARAM_INT);
        $stmt->bindParam(':VideoName', $VideoName, PDO::PARAM_STR);
        $stmt->bindParam(':VideoPath', $VideoPath, PDO::PARAM_STR);

        try {
            $stmt->execute();
            echo $_FILES['videofile']['name'] . " Saved Successfully";
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

if (isset($_GET["getfiles"]) && !empty($_GET["getfiles"])) {
    $UserId = $_SESSION["UserId"];

    if ($_SESSION["UserType"] == "Admin") {
        $sql = 'SELECT * from tbl_room and Status = 0 order by CDate desc';
        $stmt = $conn->prepare($sql);
    } else if ($_SESSION["UserType"] == "Staff") {
        $sql = 'SELECT * from tbl_room where UserId = :UserId and Status = 0 order by CDate desc';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':UserId', $UserId, PDO::PARAM_INT);
    } else {
        $sql = 'SELECT * from tbl_room where RoomId in (select RoomId from tbl_assign where UserId = :UserId) and Status = 0 order by CDate desc';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':UserId', $UserId, PDO::PARAM_INT);
    }
    try {
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        print_r(json_encode($results));
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
