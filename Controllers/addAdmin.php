<?php

require_once '../DBCalls/DBcalls.php';

require_once '../Models/Admin.php';

if (!isset($_POST["id"])) {
    $_POST["id"] = "";
}


$number = trim($_POST["Aphone"]);

$uploadedFile="";

//check if fields are empty - custome phone/name/password/email/file validation

if (($_POST['Aemail'] !== "") && ($_POST['Aname'] !== "") && ($_POST['Aphone'] !== "") && ($_POST['Arole'] !== "") && ($_POST['Apassword'] !== "")) {
    $maxsize = 55000;
    if (strlen($number) < 10 || strlen($number) > 10) {
        echo "phoneErr";
    } else if (strlen($_POST['Aname']) > 20) {
        echo "nameErr";
    } else if ((strlen($_POST['Apassword']) < 9) || (strlen($_POST['Apassword']) > 15)) {
        echo "passErr";
    } else if (!filter_var($_POST['Aemail'], FILTER_VALIDATE_EMAIL)) {
        echo "emailErr";
    } else if ((isset($_FILES["file"]["size"]))&&($_FILES["file"]["size"] >= $maxsize)) {
        echo "fileErr";
    } else {
        
        // if image uploaded check extensions and save to uploadedFile - save post values to class Admin and create if form is validated - echo ok if it is.
        
        if (!empty($_FILES["file"]["type"])) {
            $fileName = $_FILES['file']['name'];
            $valid_extensions = array("jpeg", "jpg", "png");
            $temporary = explode(".", $_FILES["file"]["name"]);
            $file_extension = end($temporary);
            if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)) {
                $sourcePath = $_FILES['file']['tmp_name'];
                $targetPath = "../uploads/" . $fileName;
                $uploadedFile = $fileName;

                $id = $_POST["id"];
                $name = $_POST['Aname'];
                $phone = $_POST['Aphone'];
                $email = $_POST['Aemail'];
                $role = $_POST['Arole'];
                $salt = "random salt text";
                $password = $_POST["Apassword"] . $salt;
                $password = sha1($password);

                $newAdmin = new Admin($id, $name, $phone, $email, $uploadedFile, $role, $password);

                $insert = createAdmin($newAdmin);

                echo $insert ? 'ok' : 'err';
            }
            
            //if no image uploaded save defualt image.
        } else {
            
                $id = $_POST["id"];
                $name = $_POST['Aname'];
                $phone = $_POST['Aphone'];
                $email = $_POST['Aemail'];
                $role = $_POST['Arole'];
                $salt = "random salt text";
                $password = $_POST["Apassword"] . $salt;
                $password = sha1($password);
                $uploadedFile = "defualt.png";

                $newAdmin = new Admin($id, $name, $phone, $email, $uploadedFile, $role, $password);

                $insert = createAdmin($newAdmin);

                echo $insert ? 'ok' : 'err';
        }
    }
} else {
    echo "err";
}



