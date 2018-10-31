<?php

require_once '../DBCalls/DBcalls.php';

require_once '../Models/Course.php';

require_once '../Models/Student.php';

//Post request for Course id and retrieve course details to Dom.

 $id = $_POST["id"];

 showCourseDetails($id);


