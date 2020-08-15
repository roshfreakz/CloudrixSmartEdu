<?php

$conn = new PDO('mysql:host=localhost;dbname=smartedu', 'root', '');
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function testinput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = addslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function GetRandomString($len)
{
    global $conn;
    do {
        $PeerId = substr(md5(time()), 0, $len);
        $sql = 'SELECT * from tbl_user WHERE PeerId = :PeerId';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':PeerId', $PeerId, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch();
    } while ($row);
    return $PeerId;
}
