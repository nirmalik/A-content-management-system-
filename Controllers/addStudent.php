<?php

require_once '../DBCalls/DBcalls.php';

require_once '../Models/Student.php';

if (!isset($_POST["Courselist"])) {
    $_POST["Courselist"] = [];
}

$number = trim($_POST["Sphone"]);

$uploadedFile = "";

//check if fields are empty - custome phone/name/email/file validation

if (($_POST['Sname'] !== "") && ($_POST['Sphone'] !== "") && ($_POST['Semail'] !== "")&& ($_POST['Courselist'] !== [])) {
    $maxsize = 55000;
    if (strlen($number) < 10 || strlen($number) > 10) {
        echo "phoneErr";
    } else if (strlen($_POST['Sname']) > 20) {
        echo "nameErr";
    }else if (!filter_var($_POST['Semail'], FILTER_VALIDATE_EMAIL)) {
        echo "emailErr";
    } else if ((isset($_FILES["file"]["size"]))&&($_FILES["file"]["size"] >= $maxsize))  {
        echo "fileErr";
    } else {
        
           // if image uploaded check extensions and save to uploadedFile - save post values to class Student and create if form is validated - echo ok if it is.
        
        if (!empty($_FILES["file"]["type"])) {
            $fileName = $_FILES['file']['name'];
            $valid_extensions = array("jpeg", "jpg", "png");
            $temporary = explode(".", $_FILES["file"]["name"]);
            $file_extension = end($temporary);
            if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)) {
                $sourcePath = $_FILES['file']['tmp_name'];
                $targetPath = "../uploads/" . $fileName;
                $uploadedFile = $fileName;

                $id = "";
                $name = $_POST['Sname'];
                $phone = $_POST['Sphone'];
                $email = $_POST['Semail'];
                $coursesArray = $_POST['Courselist'];

                $newStudent = new Student($id, $name, $phone, $email, $uploadedFile);

                $createStudent = createStudent($newStudent);
                $createStudentCourses = createStudentCourses($newStudent, $coursesArray);

                if (($createStudent) && ($createStudentCourses)) {
                    echo 'ok';
                } else {
                    echo "err";
                }
            }
            
              //if no image uploaded save defualt image.
            
        } else {
            $id = "";
            $name = $_POST['Sname'];
            $phone = $_POST['Sphone'];
            $email = $_POST['Semail'];
            $uploadedFile = "defualt.png";
            $coursesArray = $_POST['Courselist'];

            $newStudent = new Student($id, $name, $phone, $email, $uploadedFile);

            $createStudent = createStudent($newStudent);
            $createStudentCourses = createStudentCourses($newStudent, $coursesArray);

            if (($createStudent) && ($createStudentCourses)) {
                echo 'ok';
            } else {
                echo "err";
            }
        }
    }
} else {
    echo "err";
}



