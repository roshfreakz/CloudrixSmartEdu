<?php

require('config.php');
session_start();

if (isset($_POST["addroom"]) && !empty($_POST["addroom"])) {
    $UserId = $_SESSION["UserId"];
    $RoomName = testinput($_POST["RoomName"]);
    $RoomType = testinput($_POST["RoomType"]);
    $SDate = testinput($_POST["SDate"]);
    $Status = "1";

    $sql = ' INSERT INTO tbl_room ' .
        ' (  UserId,  RoomName,  RoomType,  SDate,  Status,  CDate) VALUES ' .
        ' ( :UserId, :RoomName, :RoomType, :SDate, :Status,  Now()) ';

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':UserId', $UserId, PDO::PARAM_INT);
    $stmt->bindParam(':RoomName', $RoomName, PDO::PARAM_STR);
    $stmt->bindParam(':RoomType', $RoomType, PDO::PARAM_STR);
    $stmt->bindParam(':SDate', $SDate, PDO::PARAM_STR);
    $stmt->bindParam(':Status', $Status, PDO::PARAM_STR);

    try {
        $stmt->execute();
        echo "1";
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

if (isset($_GET["getroom"]) && !empty($_GET["getroom"])) {
    $sql = 'SELECT * from tbl_room order by CDate desc';
    $stmt = $conn->prepare($sql);
    try {
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        print_r(json_encode($results));
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

