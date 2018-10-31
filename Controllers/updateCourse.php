<?php

require_once '../DBCalls/DBcalls.php';

require_once '../Models/Course.php';

$number = trim($_POST["Cphone"]);

$uploadedFile = "";

//check if fields are empty - custome phone/name/file validation

if (($_POST['description'] != "") && ($_POST['Cname'] != "") && ($_POST['Cphone'] != "")) {
    $maxsize = 55000;
    if (strlen($number) < 10 || strlen($number) > 10) {
        echo "phoneErr";
    } else if (strlen($_POST['Cname']) > 20) {
        echo "nameErr";
    } else if ((isset($_FILES["file"]["size"]))&&($_FILES["file"]["size"] >= $maxsize)) {
        echo "fileErr";
    } else {
        
          // if image uploaded check extensions and save to uploadedFile - save post values to class Course and update if form is validated - echo ok if update succeed.
        
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
                $name = $_POST['Cname'];
                $phone = $_POST['Cphone'];
                $description = $_POST['description'];

                $newCourse = new Course($id, $name, $phone, $description, $uploadedFile);

                $insert = updateCourse($newCourse);

                echo $insert ? 'ok' : 'err';
            }
            
                //if no image uploaded save defualt image.
            
        }else {
                      
                $id = $_POST["id"];
                $name = $_POST['Cname'];
                $phone = $_POST['Cphone'];
                $description = $_POST['description'];
                $uploadedFile = "defualt.png";
                
                $newCourse = new Course($id, $name, $phone, $description, $uploadedFile);

                $insert = updateCourse($newCourse);

                echo $insert ? 'ok' : 'err';
        }
    }
} else {
    echo "err";
}



