<?php
session_start();
?>
<?php
if (isset($_SESSION['userRole'])) {
    ?>
    <html>
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="https://fonts.googleapis.com/css?family=Karla" rel="stylesheet">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
            <link rel="stylesheet" href="../css/index.css">
            <title></title>
        </head>
        <body>         

            <!-- Bootstrap Modal for confirmations -->

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-footer">
                            <button id="close" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button id="saveDelete" data-dismiss="modal" type="button" class="btn btn-primary saveChange">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nav bar - links - logo - logOut - Sets session as text/img -->

            <nav class="navbar navbar-default navbar-fixed-top">
                <div class="container-fluid">
                    <div class="navbar-header">  
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <img class="navbar-brand" src="http://www.intellect-coaches.com/wp-content/uploads/2017/02/Logo-1.png">
                    </div>
                    <div class="navbar-right">
                        <ul id="welcome" class="nav navbar-nav">
                            <li id="loggedUser"><?php echo $_SESSION['userName'] . ", " . $_SESSION['userRole'] ?></li>   
                            <li id="logOut"><a href="../Controllers/logOut.php">Log Out</a></li>  
                            <li><img id="imgHeader" src="../uploads/<?php echo $_SESSION['userImage'] ?>"/></li>    
                        </ul>
                    </div>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">    
                        <div class="navbar-left">
                            <ul class="nav navbar-nav">
                                <li><a href="index.php">School</a></li>
                                <li class="links">   
                                    <?php
                                    if ($_SESSION['userRole'] !== 'sales') {
                                        ?>
                                        <a href="administrators.php">Administration</a>
                                        <?php
                                    }
                                    ?>
                                </li>
                            </ul>     
                        </div>             
                    </div>
                </div>
            </nav>

            <!-- Courses and Students list -->

            <div id="all" class="row">

                <div class="col-xs-4">

                    <div class="col-xs-6">
                        <h3 id="courseList">Courses
                            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <span><button id="addCourse"  style="color:black;"  class="glyphicon glyphicon-plus"></button></span>
                        </h3>
                    </div>



                    <div class="col-xs-6">
                        <h3 id="studentList">Students
                            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <span><button id="addStudent" style="color:black;" class="glyphicon glyphicon-plus"></button></span>
                        </h3>

                    </div>
                </div>

                <!-- Main container on page load - total number of students and courses display block/none -->

                <div id="mainView" class="col-xs-8">

                    <h1 id="totalNStudents"></h1>

                    <h1 id="totalCourses"></h1>

                </div>

                <!-- Main Forms container  - courseAdd/courseView/studentAdd/studentview -->

                <div id="mainContainer" class="col-xs-8">
                    <p class="statusMsg"></p>
                    <div class="form-style-5 courseAdd">
                        <form enctype="multipart/form-data" class='CourseForm' id="newCourse" >
                            <input id="save" type="submit" class="btn btn-default" value="Save">
                            <input id="delete" type="button" class="btn btn-default" value="Delete">
                            <fieldset>
                                <legend><span class="number">1</span> Course Info</legend>
                                <label for="Cname">Name:</label>
                                <input type="text" name="Cname" placeholder="Course Name">
                                <label for="Cphone">Phone:</label>
                                <input type="text" name="Cphone" placeholder="Course Phone">
                                <label for="description">Description:</label>
                                <textarea name="description" rows="4" placeholder="Course Description"></textarea>
                                <p id="totalStudents"></p>
                            </fieldset>
                            <fieldset>
                                <legend><span class="number">2</span> Additional Info</legend>
                                <label for="file">Image:</label>
                                <input id="img" type='file' name='file' />
                                <img id="showImage" src="#" alt="your image" />
                            </fieldset>
                        </form>
                    </div>

                    <div class="form-style-5 courseView">               
                        <div class="formHeader">
                            <h4 id="courseViewHeader">Course</h4>
                            <input id="editCourse" type="button" class="btn btn-default" value="Edit"> 
                        </div>
                        <fieldset class="courseDescription" style="padding-top:7px;">                    
                            <h3 class="courseHeader"></h3>
                            <img class="courseImage" src="#"/>
                            <h3 id="desHeader">Description</h3>
                            <p class="desc"></p>
                            <h3 id="StudentHeader">Students:</h3>
                        </fieldset>

                    </div>  

                    <p class="statusMsgStudent"></p>
                    <div class="form-style-5 studentAdd">
                        <form enctype="multipart/form-data" class='StudentForm' id="newStudent">
                            <input id="save" type="submit" class="btn btn-default" value="Save">
                            <input id="deleteStudent" type="button" class="btn btn-default" value="Delete">
                            <fieldset>
                                <legend>Student Info</legend>
                                <label for="Sname">Name:</label>
                                <input type="text" name="Sname" placeholder="Student Name..">
                                <label for="Spassword">Phone:</label>
                                <input type="text" name="Sphone" placeholder="Student phone..">
                                <label for="Semail">Email:</label>
                                <input type="text" name="Semail" placeholder="Student email..">
                                <fieldset>
                                    <legend>Select Attending Courses:</legend> 
                                    <ul class="checkbox">
                                    </ul>
                                </fieldset>
                                <br>
                            </fieldset>
                            <fieldset>
                                <legend>Additional Info</legend>
                                <label for="file">Image:</label>
                                <input id="img2" type='file' name='file' />
                                <img id="showStudentImage" src="#" alt="your image" />
                            </fieldset>
                        </form>
                    </div>

                    <div class="form-style-5 studentView">               
                        <div class="formHeader">
                            <h4 id="studentViewHeader">Student</h4>
                            <input id="editStudent" type="button" class="btn btn-default" value="Edit"> 
                        </div>
                        <fieldset class="studentDescription" style="padding-top:7px;">                    
                            <h3 class="studentHeader"></h3>
                            <h5 class="studentPhone"></h5>
                            <h5 class="studentEmail">  </h5> 
                            <h3 id="courseslist">Attending Courses:</h3>
                        </fieldset>
                        <img class="studentImageView" src="#"/>                        
                    </div> 
                </div>
            </div>

            <!-- Footer - copyrights -->

            <footer id="footer">
                <div style="margin-top:-25px;" class="footer-copyright">
                    <div class="container">
                        <div  class="row">                            
                            <div class="col-md-7">
                                <p id="copyright">© 2018 Ben Herman - Full stack web development.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </body>
        
        <script type="text/javascript">
         var sessionRole =  "<?php echo $_SESSION['userRole']; ?>";   
        </script>
        
        <script src="../scripts/theschool.js">     
        </script>
        
    </html>
    
    <?php
} else {
    $request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);
    switch ($request_uri[0]) {
        // Home page
        case '/theschool/Views/index.php':
            require 'login.php';
            break;
         case '/theschool/Views/':
            require 'login.php';
            break;
        default:
            header('HTTP/1.0 404 Not Found');
            require '404.php';
            break;
    }
}
