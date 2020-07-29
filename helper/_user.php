<?php

require('session.php');

if (isset($_POST["adduser"]) && !empty($_POST["adduser"])) {
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

if (isset($_POST["updateuser"]) && !empty($_POST["updateuser"])) {
    $UserId = testinput($_POST["UserId"]);
    $FullName = testinput($_POST["FullName"]);
    $Gender = testinput($_POST["Gender"]);
    $Mobile = testinput($_POST["Mobile"]);

    $sql = ' UPDATE tbl_user set FullName = :FullName, Gender = :Gender, Mobile = :Mobile  where UserId = :UserId ';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':FullName', $FullName, PDO::PARAM_STR);
    $stmt->bindParam(':Gender', $Gender, PDO::PARAM_STR);
    $stmt->bindParam(':Mobile', $Mobile, PDO::PARAM_STR);
    $stmt->bindParam(':UserId', $UserId, PDO::PARAM_INT);
    try {
        $stmt->execute();
        echo "1";
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

if (isset($_POST["changepassword"]) && !empty($_POST["changepassword"])) {
    $UserId = testinput($_POST["UserId"]);
    $Password = testinput($_POST["Password"]);
    $PasswordHash = password_hash($Password, PASSWORD_DEFAULT);

    $sql = ' UPDATE tbl_user set PasswordHash = :PasswordHash where UserId = :UserId ';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':UserId', $UserId, PDO::PARAM_INT);
    $stmt->bindParam(':PasswordHash', $PasswordHash, PDO::PARAM_STR);

    try {
        $stmt->execute();
        echo "1";
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}


if (isset($_GET["getusers"]) && !empty($_GET["getusers"])) {
    $sql = 'SELECT * from tbl_user ';
    if (isset($_GET["getstaff"])) {
        $sql .= 'where UserType = "Staff"';
    }
    if (isset($_GET["getstudent"])) {
        $sql .= 'where UserType = "Student"';
    }
    if (isset($_GET["getuserdetails"])) {
        $sql .= 'where UserId = ' . $_GET["UserId"];
    }
    $stmt = $conn->prepare($sql);
    try {
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        print_r(json_encode($results));
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
