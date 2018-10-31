<?php

session_start();

require 'connect.php';

//check user in table function when trying to login - selects email and password values and returns boolean as response.

function loginIfUserExist($userEmail, $userPassword) {
    $conn = $GLOBALS["connection"];
    $sql = "SELECT email FROM administrators where email='" . $userEmail . "'";
    $sql2 = "SELECT password FROM administrators where email='" . $userEmail . "'";
    $result = $conn->query($sql);
    $result2 = $conn->query($sql2);
    if (($result->num_rows > 0) && ($result2->num_rows > 0)) {
        while (($row = $result2->fetch_assoc())) {
            if ($row['password'] === $userPassword) {
                return true;
            }
        }
    } else {
        return false;
    }
}

//if loginIfUserExist returned true than setUserSession runs and create session role and session name.

function setUserSession($userEmail) {
    $conn = $GLOBALS["connection"];
    $statement = $conn->prepare("SELECT name, role, image FROM administrators where email='" . $userEmail . "'");
    $statement->execute();
    $statement->bind_result($name, $role, $image);
    if ($statement->fetch()) {
        $_SESSION['userName'] = $name;
        $_SESSION['userRole'] = $role;
        $_SESSION['userImage'] = $image;
    }
    $statement->close();
    $conn->close();
}

//create admin function - get values from class and prepear insert to table - return true.

function createAdmin($admin) {
    $conn = $GLOBALS["connection"];
    $adminN = $admin->name;
    $adminPa = $admin->password;
    $adminP = $admin->phone;
    $adminE = $admin->email;
    $adminI = $admin->image;
    $adminR = $admin->role;
    $stmt = $conn->prepare("INSERT INTO administrators (name, phone, email, image, role, password) VALUES (?, ?, ?, ?,?,?)");
    if ($stmt) {
        $stmt->bind_param("ssssss", $adminN, $adminP, $adminE, $adminI, $adminR, $adminPa);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        return true;
    }
}

//show admin details function - gets value from admin id, select from table - create admin class and echo response.

function showAdminDetails($id) {
    $conn = $GLOBALS["connection"];
    $sql = "SELECT * FROM administrators where id='" . $id . "'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while (($row = $result->fetch_assoc())) {
            $admin = new Admin($row['id'], $row['name'], $row['phone'], $row['email'], $row['image'], $row['role'], $row['password']);
        }
    }
    echo json_encode($admin);
}

//update admin function - get values from class, update table and return boolean.

function updateAdmin($admin) {
    $worked = true;
    $conn = $GLOBALS["connection"];
    $adminN = $admin->name;
    $adminP = $admin->phone;
    $adminE = $admin->email;
    $adminI = $admin->image;
    $adminR = $admin->role;
    $sqlUpAdmin = ("UPDATE administrators SET name='$adminN', email='$adminE', image='$adminI', phone='$adminP',role='$adminR' WHERE id='" . $admin->id . "'");
    $result = $conn->query($sqlUpAdmin);
    if ($result === TRUE) {
        return $worked;
    } else {
        echo "Error updating Admin: " . $conn->error;
        $worked = false;
    }
    return $worked;
}

//delete admin function - get value from admin id and delete from table - return boolean.

function deleteAdmin($id) {
    $worked = true;
    $conn = $GLOBALS["connection"];
    $sql = "DELETE FROM administrators WHERE id='" . $id . "'";
    $result = $conn->query($sql);
    if ($result === TRUE) {
        return $worked;
    } else {
        echo "Error updating record: " . $conn->error;
        $worked = false;
    }
    return $worked;
}

//set new owner function - gets admin name from input and selects him from table - if he doesn't exists it returns false otherwise returns true.

function setNewOwner($name) {
    $worked = true;
    $conn = $GLOBALS["connection"];
    $sql = "SELECT name FROM administrators where name='" . $name . "'";
    $result2 = $conn->query($sql);
    $sqlUpAdmin = ("UPDATE administrators SET role='owner' WHERE name='" . $name . "'");
    $result = $conn->query($sqlUpAdmin);
    if ($result2->num_rows > 0) {
        return $worked;
    } else {
        $worked = false;
        return $worked;
    }
}

//show all admins function - select from table, create ckass and echo response.

function showAllAdmins() {
    $adminArray = array();
    $conn = $GLOBALS["connection"];
    $sql = "SELECT * FROM administrators";
    $result = $conn->query($sql);
    if (($result->num_rows > 0)) {
        while (($row = $result->fetch_assoc())) {

            $admin = new Admin($row['id'], $row['name'], $row['phone'], $row['email'], $row['image'], $row['role'], $row['password']);

            array_push($adminArray, $admin);
        }
        echo json_encode($adminArray);
    }
}

//create course function - gets values from class course and inserts to courses table.

function createCourse($Course) {
    $conn = $GLOBALS["connection"];
    $CourseN = $Course->name;
    $CourseP = $Course->phone;
    $CourseD = $Course->description;
    $CourseI = $Course->image;
    $stmt = $conn->prepare("INSERT INTO courses (name, phone, description, image) VALUES (?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssss", $CourseN, $CourseP, $CourseD, $CourseI);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        return true;
    }
}

//update course function - gets values from class course and inserts to courses table.

function updateCourse($Course) {
    $worked = true;
    $conn = $GLOBALS["connection"];
    $CourseN = $Course->name;
    $CourseP = $Course->phone;
    $CourseD = $Course->description;
    $CourseI = $Course->image;
    $sqlUpCourse = ("UPDATE courses SET name='$CourseN', description='$CourseD', image='$CourseI', phone='$CourseP' WHERE id='" . $Course->id . "'");
    $result = $conn->query($sqlUpCourse);
    if ($result === TRUE) {
        return $worked;
    } else {
        echo "Error updating record: " . $conn->error;
        $worked = false;
    }
    return $worked;
}

//delete course function - get course id value and delete it from courses table.

function deleteCourse($id) {
    $worked = true;
    $conn = $GLOBALS["connection"];
    $sql = "DELETE FROM courses WHERE id='" . $id . "'";
    $result = $conn->query($sql);
    if ($result === TRUE) {
        return $worked;
    } else {
        echo "Error updating record: " . $conn->error;
        $worked = false;
    }
    return $worked;
}

//show all courses function - select all from courses table insert to class and echo response.

function showAllCourses() {
    $courseArray = array();
    $conn = $GLOBALS["connection"];
    $sql = "SELECT * FROM courses";
    $result = $conn->query($sql);
    if (($result->num_rows > 0)) {
        while (($row = $result->fetch_assoc())) {

            $course = new Course($row['id'], $row['name'], $row['phone'], $row['description'], $row['image']);

            array_push($courseArray, $course);
        }
        echo json_encode($courseArray);
    }
};

//show all students function - select all from students table insert to class and echo response.

function showAllStudents() {
    $studentsArray = array();
    $conn = $GLOBALS["connection"];
    $sql = "SELECT * FROM students";
    $result = $conn->query($sql);
    if (($result->num_rows > 0)) {
        while (($row = $result->fetch_assoc())) {

            $student = new Student($row['id'], $row['name'], $row['phone'], $row['email'], $row['image']);

            array_push($studentsArray, $student);
        }
        echo json_encode($studentsArray);
    }
};

/*show course details function - select student id from shared table(overview), select attending students from students table -
  select course from courses via the id value - push all data to the selected course arrays(attending students details/course details) - echo response.
*/

function showCourseDetails($id) {
    $allstudents = array();
    $coursesArray = array();
    $conn = $GLOBALS["connection"];
    $sql = "SELECT student_id FROM overview where course_id='" . $id . "'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while (($row = $result->fetch_assoc())) {
            $studentId = $row['student_id'];
            $sql2 = "SELECT * FROM students where id='" . $studentId . "'";
            $result2 = $conn->query($sql2);
            if ($result2->num_rows > 0) {
                while ($row2 = $result2->fetch_assoc()) {
                    $student = new Student($row2['id'], $row2['name'], $row2['phone'], $row2['email'], $row2['image']);
                    array_push($allstudents, $student);
                }
            }
        }
    }

    $sql3 = "SELECT * FROM courses where id='" . $id . "'";
    $result3 = $conn->query($sql3);
    if ($result3->num_rows > 0) {
        while (($row3 = $result3->fetch_assoc())) {

            $course = new Course($row3['id'], $row3['name'], $row3['phone'], $row3['description'], $row3['image']);
        }
    }
    array_push($coursesArray, $course);
    array_push($coursesArray, $allstudents);
    echo json_encode($coursesArray);
}

/*show student details function - select course id from shared table(overview), select attending courses from courses table -
  select student from students via the id value - push all data to the selected students arrays(attending courses details/student details) - echo response.
*/

function showStudentDetails($id) {
    $allstudents = array();
    $coursesArray = array();
    $conn = $GLOBALS["connection"];
    $sql = "SELECT * FROM students where id='" . $id . "'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while (($row = $result->fetch_assoc())) {
            $student = new Student($row['id'], $row['name'], $row['phone'], $row['email'], $row['image']);
        }
    }

    $sql2 = "SELECT course_id FROM overview where student_id='" . $id . "'";
    $result2 = $conn->query($sql2);
    if ($result2->num_rows > 0) {
        while ($row2 = $result2->fetch_assoc()) {
            $courseId = $row2['course_id'];
            $sql3 = "SELECT * FROM courses where id='" . $courseId . "'";
            $result3 = $conn->query($sql3);
            if ($result3->num_rows > 0) {
                while (($row3 = $result3->fetch_assoc())) {
                    $course = new Course($row3['id'], $row3['name'], $row3['phone'], $row3['description'], $row3['image']);
                    array_push($coursesArray, $course);
                }
            }
        }
    }
    array_push($allstudents, $student);
    array_push($allstudents, $coursesArray);
    echo json_encode($allstudents);
}

//create student function - gets values from class and inserts to table.

function createStudent($student) {
    $conn = $GLOBALS["connection"];
    $StudentN = $student->name;
    $StudentP = $student->phone;
    $StudentE = $student->email;
    $StudentI = $student->image;
    $stmt = $conn->prepare("INSERT INTO students (name, phone, email, image) VALUES (?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssss", $StudentN, $StudentP, $StudentE, $StudentI);
        $stmt->execute();
        $stmt->close();
        return true;
    }
    $conn->close();
}

//creates the attending courses for a student via student details(student class) and the courses array from the courses checkboxes in index.php.

function createStudentCourses($student, $coursesArray) {
    $coursesId = array();
    $worked = true;
    $conn = $GLOBALS["connection"];
    
    //retrieves atteding courses id and pushes to courseId array.

    foreach ($coursesArray as &$value) {
        $sqlCourses = "SELECT id FROM courses where name='" . $value . "'";
        $result1 = $conn->query($sqlCourses);
        if ($result1->num_rows > 0) {
            while (($row = $result1->fetch_assoc())) {
                array_push($coursesId, $row['id']);
            }
        }
    }
    
    //after student was created (createStudent function) selects the student id.

    $sqlStudent = "SELECT id FROM students where name='" . $student->name . "'";
    $result2 = $conn->query($sqlStudent);
    if ($result2->num_rows > 0) {
        while (($row = $result2->fetch_assoc())) {
            $studentId = $row['id'];
        }
    }

    
    //loops threw coursesId array and inserts to shared table (overview) student id and course id - returns boolean.
    
    foreach ($coursesId as &$value) {
        $stmt = $conn->prepare("INSERT INTO overview (student_id, course_id) VALUES (?,?)");
        if ($stmt) {
            $stmt->bind_param("ss", $studentId, $value);
            $stmt->execute();
            $stmt->close();
        }
    }
    if ($result1) {
        return $worked;
    } else {
        echo "Error adding course: " . $conn->error;
        $worked = false;
    }
    $conn->close();
    return $worked;
}

//update student function - gets values from class and update table.

function updateStudent($student) {
    $worked = true;
    $conn = $GLOBALS["connection"];
    $studentN = $student->name;
    $studentP = $student->phone;
    $studentE = $student->email;
    $studentI = $student->image;
    $sqlUpStudent = ("UPDATE students SET name='$studentN', email='$studentE', image='$studentI', phone='$studentP' WHERE id='" . $student->id . "'");
    $result = $conn->query($sqlUpStudent);
    if ($result === TRUE) {
        return $worked;
    } else {
        echo "Error updating Student: " . $conn->error;
        $worked = false;
    }
    return $worked;
}

//updates the attending courses for a student via student details(student class) and the courses array from the courses checkboxes in index.php.

function updateStudentCourses($student, $coursesArray) {
    $coursesId = array();
    $worked = true;
    
    //deletes all attending courses from selected student than re-inserts them with new details from update student form.
    
    $conn = $GLOBALS["connection"];
    $sqlDelCourses = ("DELETE from overview WHERE student_id='" . $student->id . "'");
    $result = $conn->query($sqlDelCourses);
    
    //retrieves attending courses id and pushes to courseId array.
    
    foreach ($coursesArray as &$value) {
        $sql = "SELECT id FROM courses where name='" . $value . "'";
        $result1 = $conn->query($sql);
        if ($result1->num_rows > 0) {
            while (($row = $result1->fetch_assoc())) {
                array_push($coursesId, $row['id']);
            }
        }
    }
    
    //for each course in array  insert to shared table(overview) student id and course if - returns boolean.
    
    foreach ($coursesId as &$value) {
        $stmt = $conn->prepare("INSERT INTO overview (student_id, course_id) VALUES (?,?)");
        if ($stmt) {
            $stmt->bind_param("ss", $student->id, $value);
            $stmt->execute();
            $stmt->close();
        }
    }
    if ($result === TRUE) {
        return $worked;
    } else {
        echo "Error Deleting course: " . $conn->error;
        $worked = false;
    }
    $conn->close();
    return $worked;
}

//delete student via student id value - deletes all from shared table(overview) aswell.

function deleteStudent($id) {
    $worked = true;
    $conn = $GLOBALS["connection"];
    $sql = "DELETE FROM students WHERE id='" . $id . "'";
    $result = $conn->query($sql);
    if ($result === TRUE) {
        $worked = true;
    } else {
        echo "Error deleting student: " . $conn->error;
        $worked = false;
    }

    $sql2 = "DELETE FROM overview WHERE student_id='" . $id . "'";
    $result2 = $conn->query($sql2);
    if ($result2 === TRUE) {
        $worked = true;
    } else {
        echo "Error deleting from course: " . $conn->error;
        $worked = false;
    }
    return $worked;
}
