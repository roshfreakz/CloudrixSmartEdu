<?php

require('config.php');
session_start();

if (isset($_POST["addroom"]) && !empty($_POST["addroom"])) {
    $UserId = $_SESSION["UserId"];
    $PeerId = $_SESSION["PeerId"];
    $FullName = $_SESSION["FullName"];
    $RoomName = testinput($_POST["RoomName"]);
    $RoomType = testinput($_POST["RoomType"]);
    $SDate = testinput($_POST["SDate"]);
    $Status = "1";

    $sql = ' INSERT INTO tbl_room ' .
        ' (  UserId,  PeerId,  FullName,  RoomName,  RoomType,  SDate,  Status,  CDate) VALUES ' .
        ' ( :UserId, :PeerId, :FullName, :RoomName, :RoomType, :SDate, :Status,  Now()) ';

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':UserId', $UserId, PDO::PARAM_INT);
    $stmt->bindParam(':PeerId', $PeerId, PDO::PARAM_STR);
    $stmt->bindParam(':FullName', $FullName, PDO::PARAM_STR);
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
    $UserId = $_SESSION["UserId"];

    if ($_SESSION["UserType"] == "Admin") {
        $sql = 'SELECT * from tbl_room order by CDate desc';
        $stmt = $conn->prepare($sql);
    } else if ($_SESSION["UserType"] == "Staff") {
        $sql = 'SELECT * from tbl_room where UserId = :UserId order by CDate desc';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':UserId', $UserId, PDO::PARAM_INT);
    } else {
        $sql = 'SELECT * from tbl_room where RoomId in (select RoomId from tbl_assign where UserId = :UserId) order by CDate desc';
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

if (isset($_GET["getdashboard"]) && !empty($_GET["getdashboard"])) {

    $sql = ' select (select count(*) from tbl_room where Status = 1) as Active, ';
    $sql .= ' (select count(*) from tbl_room where Status = 0) as Closed, ';
    $sql .= ' (select count(*) from tbl_user where UserType = "Staff") as Staff, ';
    $sql .= ' (select count(*) from tbl_user where UserType = "Student") as Student; ';

    $stmt = $conn->prepare($sql);
    try {
        $stmt->execute();
        $results = $stmt->fetch();
        print_r(json_encode($results));
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
