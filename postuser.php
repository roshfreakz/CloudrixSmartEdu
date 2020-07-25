<?php

require('config.php');
session_start();

if (isset($_POST["registeruser"]) && !empty($_POST["registeruser"])) {
    $PeerId = GetRandomString(6);
    $FullName = testinput($_POST["FullName"]);
    $Gender = testinput($_POST["Gender"]);
    $Mobile = testinput($_POST["Mobile"]);
    $Email = testinput($_POST["Email"]);
    $UserType = testinput($_POST["UserType"]);
    $Username = testinput($_POST["Username"]);
    $Password = testinput($_POST["Password"]);
    $PasswordHash = password_hash($Password, PASSWORD_DEFAULT);

    $sql = ' INSERT INTO tbl_user ' .
        ' ( PeerId,  FullName,  Gender,  Mobile,  Email,  UserType,  Username,  PasswordHash, CDate) VALUES ' .
        ' (:PeerId, :FullName, :Gender, :Mobile, :Email, :UserType, :Username, :PasswordHash, Now()) ';

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':PeerId', $PeerId, PDO::PARAM_STR);
    $stmt->bindParam(':FullName', $FullName, PDO::PARAM_STR);
    $stmt->bindParam(':Gender', $Gender, PDO::PARAM_STR);
    $stmt->bindParam(':Mobile', $Mobile, PDO::PARAM_STR);
    $stmt->bindParam(':Email', $Email, PDO::PARAM_STR);
    $stmt->bindParam(':UserType', $UserType, PDO::PARAM_STR);
    $stmt->bindParam(':Username', $Username, PDO::PARAM_STR);
    $stmt->bindParam(':PasswordHash', $PasswordHash, PDO::PARAM_STR);

    try {
        $stmt->execute();
        echo "1";
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

if (isset($_GET["getusers"]) && !empty($_GET["getusers"])) {
    $sql = 'SELECT * from tbl_user';
    $stmt = $conn->prepare($sql);
    try {
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        print_r(json_encode($results));
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}



if (isset($_POST["checklogin"]) && !empty($_POST["checklogin"])) {
    $Username = testinput($_POST["Username"]);
    $Password = testinput($_POST["Password"]);
    $sql = 'SELECT * from tbl_user WHERE Username = :Username';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':Username', $Username, PDO::PARAM_STR);
    try {
        $stmt->execute();
        $row = $stmt->fetch();
        if ($row) {
            $passwordHash = $row["PasswordHash"];
            if (password_verify($Password, $passwordHash)) {
                $_SESSION['UserId'] = $row["UserId"];
                $_SESSION['FullName'] = $row["FullName"];
                $_SESSION['PeerId'] = $row["PeerId"];
                $_SESSION['UserType'] = $row["UserType"];
                echo "1";
            } else {
                echo "2";
            }
        } else {
            echo "3";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
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


if (isset($_GET["getstaff"]) && !empty($_GET["getstaff"])) {
    $UserType = 'Staff';
    $sql = 'SELECT * from tbl_user where UserType = :UserType';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':UserType', $UserType, PDO::PARAM_STR);
    try {
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        print_r(json_encode($results));
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

if (isset($_GET["getstudent"]) && !empty($_GET["getstudent"])) {
    $UserType = 'Student';
    $sql = 'SELECT * from tbl_user where UserType = :UserType';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':UserType', $UserType, PDO::PARAM_STR);
    try {
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        print_r(json_encode($results));
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
