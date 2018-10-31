<?php


require_once '../DBCalls/DBcalls.php';

require_once '../Models/Admin.php';

$newOwner=true;

// if user session role is owner and when editing himself he changed his role and he entered a new owner than setNewOwner function avtivates - returns true or false.

if (($_SESSION['userRole'] === "owner")&&($_POST['Arole'] !== "owner")&&($_POST['newOwner'] !== "")) {
    $newOwner= setNewOwner($_POST["newOwner"]);
}

$number = trim($_POST["Aphone"]);

$uploadedFile = "";

//check if fields are empty - custome phone/name/email/file/admin validation - if setNewOwner returns false than it echos admin error.

if (($_POST['Aemail'] !== "") && ($_POST['Aname'] !== "") && ($_POST['Aphone'] !== "") && ($_POST['Arole'] !== "")) {
    $maxsize = 55000;
    if (strlen($number) < 10 || strlen($number) > 10) {
        echo "phoneErr";
    } else if (strlen($_POST['Aname']) > 20) {
        echo "nameErr";
    } else if (!filter_var($_POST['Aemail'], FILTER_VALIDATE_EMAIL)) {
        echo "emailErr";
    } else if ((isset($_FILES["file"]["size"]))&&($_FILES["file"]["size"] >= $maxsize)) {
        echo "fileErr";
    } else if ((!$newOwner)) {
        echo "adminErr";
    } else {
        
           // if image uploaded check extensions and save to uploadedFile - save post values to class Admin and update if form is validated - echo ok if update succeed.
        
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
                $password = "";


                $newAdmin = new Admin($id, $name, $phone, $email, $uploadedFile, $role, $password);

                $insert = updateAdmin($newAdmin);

                echo $insert ? 'ok' : 'err';
            }
        }
            //if no image uploaded save defualt image.
        
        else {
            $id = $_POST["id"];
            $name = $_POST['Aname'];
            $phone = $_POST['Aphone'];
            $email = $_POST['Aemail'];
            $role = $_POST['Arole'];
            $password = "";
            $uploadedFile = "defualt.png";

            $newAdmin = new Admin($id, $name, $phone, $email, $uploadedFile, $role, $password);

            $insert = updateAdmin($newAdmin);

            echo $insert ? 'ok' : 'err';
        }
    }
} else {
    echo "err";
}






