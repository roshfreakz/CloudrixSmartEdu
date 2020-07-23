<?php

require('config.php');

if (isset($_POST["addassign"]) && !empty($_POST["addassign"])) {
    $UserId = testinput($_POST["UserId"]);
    $PeerId = testinput($_POST["PeerId"]);
    $RoomId = testinput($_POST["RoomId"]);

    $sql = 'SELECT count(*) as cnt from tbl_assign where UserId = :UserId and RoomId = :RoomId';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':UserId', $UserId, PDO::PARAM_STR);
    $stmt->bindParam(':RoomId', $RoomId, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch();
   
    if ($row["cnt"] > 0) {
        echo "2";
    } else {

        $sql = ' INSERT INTO tbl_assign ' .
            ' (  UserId,  RoomId,  PeerId, CDate) VALUES ' .
            ' ( :UserId, :RoomId, :PeerId, Now()) ';

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':UserId', $UserId, PDO::PARAM_INT);
        $stmt->bindParam(':RoomId', $RoomId, PDO::PARAM_INT);
        $stmt->bindParam(':PeerId', $PeerId, PDO::PARAM_STR);

        try {
            $stmt->execute();
            echo "1";
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

if (isset($_GET["getassign"]) && !empty($_GET["getassign"])) {

    $RoomId = testinput($_GET["RoomId"]);
    $sql = 'SELECT u.* from tbl_assign a left outer join tbl_user u on u.UserId = a.UserId where a.RoomId = :RoomId';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':RoomId', $RoomId, PDO::PARAM_STR);
    try {
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        print_r(json_encode($results));
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

if (isset($_GET["getjoined"]) && !empty($_GET["getjoined"])) {

    $RoomId = testinput($_GET["RoomId"]);
    $sql = 'SELECT u.* from tbl_assign a left outer join tbl_user u on u.UserId = a.UserId where a.RoomId = :RoomId';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':RoomId', $RoomId, PDO::PARAM_STR);
    try {
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        print_r(json_encode($results));
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
