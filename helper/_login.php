<?php
require_once('config.php');
require_once('PHPMailer.php');
require_once('Exception.php');
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST["registeruser"]) && !empty($_POST["registeruser"])) {
    $PeerId = GetRandomString(6);
    $FullName = testinput($_POST["FullName"]);
    $Email = testinput($_POST["Email"]);
    $Username = testinput($_POST["Username"]);
    $Password = testinput($_POST["Password"]);
    $PasswordHash = password_hash($Password, PASSWORD_DEFAULT);

    $sql = ' INSERT INTO tbl_user ' .
        ' ( PeerId,  FullName,  Email,  UserType,  Username,  PasswordHash, CDate) VALUES ' .
        ' (:PeerId, :FullName, :Email, "Student", :Username, :PasswordHash, Now()) ';

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':PeerId', $PeerId, PDO::PARAM_STR);
    $stmt->bindParam(':FullName', $FullName, PDO::PARAM_STR);
    $stmt->bindParam(':Email', $Email, PDO::PARAM_STR);
    $stmt->bindParam(':Username', $Username, PDO::PARAM_STR);
    $stmt->bindParam(':PasswordHash', $PasswordHash, PDO::PARAM_STR);

    try {
        $stmt->execute();
        echo "1";
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
                $_SESSION['PeerId'] = $row["PeerId"];
                $_SESSION['FullName'] = $row["FullName"];
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


if (isset($_POST["checkemail"]) && !empty($_POST["checkemail"])) {
    $Email = testinput($_POST["Email"]);
    $sql = 'SELECT * from tbl_user WHERE Email = :Email';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':Email', $Email, PDO::PARAM_STR);
    try {
        $stmt->execute();
        $row = $stmt->fetch();
        if ($row) {
            $Password = GetRandomString(6);
            $PasswordHash = password_hash($Password, PASSWORD_DEFAULT);
            $sql = ' UPDATE tbl_user SET PasswordHash = :PasswordHash WHERE UserId = :UserId ';
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':UserId', $row["UserId"], PDO::PARAM_INT);
            $stmt->bindParam(':PasswordHash', $PasswordHash, PDO::PARAM_STR);

            try {
                $stmt->execute();
                $bodytext = "<p>Your Password has been successfully reset.</p>";
                $bodytext .= "<p>Your New Password is: " . $Password . "</p>";

                $email = new PHPMailer(true);
                $email->SetFrom('admin@cloudrix.in', 'Admin');
                $email->Subject = 'Password Reset';
                $email->IsHTML(true);
                $email->Body = $bodytext;
                $email->AddAddress($Email);

                try {
                    $email->send();
                    echo "1";
                } catch (Exception $e) {
                    echo "Mailer Error: " . $email->ErrorInfo;
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        } else {
            echo "2";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
