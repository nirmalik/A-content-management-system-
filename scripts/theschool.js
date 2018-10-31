
$(document).ready(function (e) {

    //side bar lists main func.

    showDetails();

    //show/hide elements.

    function showHide(show) {
        $("#mainView ").css("display", "none");
        $(".studentView ").css("display", "none");
        $(".courseView ").css("display", "none");
        $(".courseAdd").css("display", "none");
        $(".studentAdd ").css("display", "none");
        show.css("display", "block");
    }

    /* showAllCourses/showAllStudents - functions to build the side bar of students list and courses list */


    function showDetails() {
        showAllCourses();
        showAllStudents();
    }

    // remove and rebuild list and append to checkboxes inputs/coursesList - on side bar 

    function showAllCourses() {
        $(".courses").remove();
        $('.SelectedCourses').remove();
        $.ajax({
            type: 'GET',
            url: '../Controllers/allCourses.php',
            success: function (coursesList) {
                var courses = JSON.parse(coursesList);
                for (i = 0; i < courses.length; i++) {
                    var coursesWrapper = "<div class='courses wrapper courselinks' data-course='" + courses[i].id + "'" + "><h6 id='Cheader'>" + courses[i].name + "</h6>\n\
                                <h6>" + courses[i].phone + "</h6><img src='../uploads/" + courses[i].image + "'" + "</div>";
                    $('.col-xs-6').eq(0).append(coursesWrapper);
                    var coursesList = "<li class='SelectedCourses'><input name='Courselist[]' type='checkbox' data-id='" + courses[i].id + "'value='" + courses[i].name + "'/><label for='" + courses[i].name + "'>" + courses[i].name + "</label></li>";
                    $('.checkbox').append(coursesList);
                }
                $('#totalCourses').text("Total Number Of Courses: " + courses.length);
            }
        });
    }
    ;


    // destroy and rebuild students list and append to studentsList on side bar

    function showAllStudents() {
        $(".students").remove();
        $.ajax({
            type: 'GET',
            url: '../Controllers/allStudents.php',
            success: function (studentList) {

                var students = JSON.parse(studentList);
                for (i = 0; i < students.length; i++) {
                    var studentsWrapper = "<div class='students wrapper studentlinks' data-student='" + students[i].id + "'" + "><h6 id='Sheader'>" + students[i].name + "</h6>\n\
                                <h6 class='studentPhone'>" + students[i].phone + "</h6><img class='studentImageDisplay' src='../uploads/" + students[i].image + "'" + "</div>";
                    $('.col-xs-6').eq(1).append(studentsWrapper);
                }
                $('#totalNStudents').text("Total Number Of Students: " + students.length);
            }
        });
    }
    ;

    //Main students Ajax - off('click') events so they wont bubble - clear msg. 

    $('body').on('click', '.studentlinks', function (e) {
        $("#img2").show();
        $("#img2").attr("type", "file");
        e.preventDefault();
        showHide($("#mainContainer"));
        $('.statusMsg').html('');
        $('.statusMsgStudent').html('');
        let
        StudentData;
        StudentData = {id: this.dataset.student};

        //student Details Ajax via Post of student id.

        $.ajax({
            type: 'POST',
            url: '../Controllers/studentDetails.php',
            data: StudentData,
            success: function (student) {
                var students = JSON.parse(student);
                console.log(students);
                $('.studentPhone').html(students[0].phone);
                $('.studentEmail').html(students[0].email);
                $('.studentHeader').html(students[0].name + ", " + students[1].length + " Courses");
                $('.studentImageView').attr("src", "../uploads/" + students[0].image)
                $(".attendingCourses").remove();
                for (i = 0; i < students[1].length; i++) {
                    var coursesContainer = "<fieldset style='position:relative;margin:20px;' class='attendingCourses'><i style='position:absolute; left:-60px;top:35%;' class='glyphicon glyphicon-book'></i><h4 style='margin-left:10px;' class='courseList'>" + students[1][i].name + "</h4>\n\
                            <img style='position:absolute; left:-35px;top:15%;' class='courseImageView' src='../uploads/" + students[1][i].image + "'/>"
                    $('.studentView').append(coursesContainer);
                }



                //edit button on click - build student edit form.

                $('#editStudent').click(function () {
                    $("#deleteStudent").attr('data-student', StudentData.id);
                    $("#deleteStudent").css("display", "block");
                    $("#newStudent").off('submit');
                    $("#editStudentForm").off('submit');
                    showHide($(".studentAdd"));
                    $(".StudentForm").attr("id", "editStudentForm");
                    $('#editStudentForm').find('input[name=Sname]').val(students[0].name);
                    $('#editStudentForm').find('input[name=Sphone]').val(students[0].phone);
                    $('#editStudentForm').find('input[name=Semail]').val(students[0].email);
                    $('#showStudentImage').attr('src', "../uploads/" + students[0].image + "");

                    // uncheck checked checkbox inputs and recheck the attending courses.

                    var radioLength = $('input[type=checkbox]');
                    $('input[type=checkbox]').prop('checked', false);
                    for (i = 0; i < students[1].length; i++) {
                        for (j = 0; j < radioLength.length; j++) {
                            if (radioLength[j].value === students[1][i].name) {
                                radioLength[j].checked = true;
                            }
                        }
                    }

                    //Update student main Ajax.
                    //swap bootstrap Modal id from delete to confirm upload with no image.
                    //Modal save button on click function - change image from type file to type text and upload defualt img (if text is changed it will still upload the defualt).

                    $("form#editStudentForm").submit(function (e) {
                        e.preventDefault();
                        $('.saveChange').attr('id', 'saveNoImg');
                        $(".saveChange").off('click');
                        $('#saveNoImg').click(function (event) {
                            event.preventDefault();
                            $("#img2").attr("type", "text");
                            $('#showStudentImage').attr('src', "../uploads/defualt.png");
                            $("#img2").hide();
                            $("#img2").val("#");
                            $("form#editStudentForm").submit();
                        });

                        // bootstrap Modal activation if no image.

                        if ($("#img2").val() === '') {
                            $('#exampleModal').modal({show: true});
                            $('#exampleModalLabel').html('Are you sure you want to save without an image?');
                        } else {
                            var formData = new FormData(this);
                            formData.append('id', StudentData.id)
                            $.ajax({
                                type: 'POST',
                                url: '../Controllers/updateStudent.php',
                                data: formData,
                                success: function (msg) {

                                    //check data attr and show student details after save

                                    if (msg === 'ok') {
                                        if ($('.studentlinks').attr('data-student', StudentData.id)) {
                                            $('.studentlinks').click();
                                            showHide($(".studentView "));
                                        }
                                        $('#editStudentForm')[0].reset();
                                        $('.statusMsgStudent').html('<span style="font-size:18px;color:#34A853"> Student Edited successfully.</span>');
                                        showDetails();
                                    } else if (msg === 'phoneErr') {
                                        $('.statusMsgStudent').html('<span style="font-size:18px;color:#EA4335">Phone must be 10 digits!.</span>');
                                    } else if (msg === 'nameErr') {
                                        $('.statusMsgStudent').html('<span style="font-size:18px;color:#EA4335">name must be 20 letters max!.</span>');
                                    } else if (msg === 'fileErr') {
                                        $('.statusMsgStudent').html('<span style="font-size:18px;color:#EA4335">image must be up to 10 kb in size!.</span>');
                                    } else if (msg === 'emailErr') {
                                        $('.statusMsgStudent').html('<span style="font-size:18px;color:#EA4335">Please enter a correct email!.</span>');
                                    }
                                    else {
                                        $('.statusMsgStudent').html('<span style="font-size:18px;color:#EA4335">Please fill out all fields.</span>');
                                    }
                                    $(".submitBtn").removeAttr("disabled");
                                },
                                contentType: false,
                                cache: false,
                                processData: false,
                            });
                        }
                    });

                    //Delete button activates bootstraps Modal - saves new data and reloads page.

                    $("#deleteStudent").attr('data-toggle', 'modal');
                    $("#deleteStudent").attr('data-target', '#exampleModal');

                    $("#deleteStudent").click(function (event) {
                        $('.saveChange').attr('id', 'saveDeleteStudent');
                        $(".saveChange").off('click');
                        $('#exampleModalLabel').html('Are you sure you want to delete this student?');
                        $("#saveDeleteStudent").click(function (event) {
                            event.stopPropagation();
                            let
                            DeleteData = {id: StudentData.id};
                            $.ajax({
                                type: 'POST',
                                data: DeleteData,
                                url: '../Controllers/deleteStudent.php',
                                success: function (msg) {
                                    if (msg.indexOf('ok') !== -1) {
                                        location.reload();
                                    } else {
                                        $('.statusMsg').html('<span style="font-size:18px;color:#EA4335">Could not delete student.</span>');
                                    }
                                }
                            });
                        });
                    });
                });
            }
        });
        $(".studentView ").css("display", "block");
    });

    // add new student main ajax - change form to add student - clear msg and image.

    $("#addStudent").click(function () {
        $("#img2").show();
        $("#img2").attr("type", "file");
        showHide($("#mainContainer"));
        showHide($(".studentAdd"));
        $("#deleteStudent").css("display", "none");
        $("#newStudent").off('submit');
        $("#editStudentForm").off('submit');
        $(".StudentForm").attr("id", "newStudent");
        $(".StudentForm")[0].reset();
        $('#showImage').attr('src', "");
        $('#showStudentImage').attr('src', "");
        $('.statusMsg').html('');
        $('.statusMsgStudent').html('');

        //ajax submit new student - change modal save button id for no image.

        $("#newStudent").on('submit', function (e) {
            e.preventDefault();
            $('.saveChange').attr('id', 'saveNoImg');
            $(".saveChange").off('click');
            $('#saveNoImg').click(function (event) {
                event.preventDefault();
                $("#img2").attr("type", "text");
                $('#showStudentImage').attr('src', "../uploads/defualt.png");
                $("#img2").hide();
                $("#img2").val("#");
                $("#newStudent").submit();
            });
            var formData = new FormData(this)
            if ($("#img2").val() === '') {
                $('#exampleModal').modal({show: true});
                $('#exampleModalLabel').html('Are you sure you want to save without an image?');
            } else {
                $.ajax({
                    type: 'POST',
                    url: '../Controllers/addStudent.php',
                    data: formData,
                    success: function (msg) {
                        if (msg === 'ok') {
                            showAllStudents();
                            $('#newStudent')[0].reset();
                            $('.statusMsgStudent').html('<span style="font-size:18px;color:#34A853"> Student submitted successfully.</span>');
                            $(".studentAdd").css("display", "none");
                        } else if (msg === 'phoneErr') {
                            $('.statusMsgStudent').html('<span style="font-size:18px;color:#EA4335">Phone must be 10 digits!.</span>');
                        } else if (msg === 'nameErr') {
                            $('.statusMsgStudent').html('<span style="font-size:18px;color:#EA4335">name must be 20 letters max!.</span>');
                        } else if (msg === 'fileErr') {
                            $('.statusMsgStudent').html('<span style="font-size:18px;color:#EA4335">image must be up to 10 kb in size!.</span>');
                        } else if (msg === 'emailErr') {
                            $('.statusMsgStudent').html('<span style="font-size:18px;color:#EA4335">Please enter a correct email!.</span>');
                        }
                        else {
                            $('.statusMsgStudent').html('<span style="font-size:18px;color:#EA4335">Please fill out all fields.</span>');
                        }
                        $(".submitBtn").removeAttr("disabled");
                    },
                    contentType: false,
                    cache: false,
                    processData: false,
                });
            }
        });
    });

    //Courses ajax main - change img to file - clear msg - check session roles for permissions - fill courseView with course details

    $('body').on('click', '.courselinks', function (e) {
        showHide($("#mainContainer"));
        $("#img").show();
        $("#img").attr("type", "file");
        $('.statusMsg').html('');
        $('.statusMsgStudent').html('');
        var CourseData = {id: this.dataset.course};
        $.ajax({
            type: 'POST',
            url: '../Controllers/courseDetails.php',
            data: CourseData,
            success: function (course) {
                var courses = JSON.parse(course);
                //if role is sales edit button is hidden

                if (sessionRole !== 'sales') {
                    $('#editCourse').css("display", "block");
                    $("#editCourse").attr("data-course", courses[0].id);
                }


                $('.courseHeader').html(courses[0].name + ", " + courses[1].length + " Students");
                $('.courseImage').attr("src", "../uploads/" + courses[0].image)
                $('.courseDescription').find('p').css("word-wrap", "break-word");

                $('.courseDescription').find('p').css("line-height", "30px");
                $('.courseDescription').find('p').html(courses[0].description);
                $(".attendingStudents").remove();
                for (i = 0; i < courses[1].length; i++) {
                    var studentContainer = "<fieldset style='position:relative;margin-bottom:20px;' class='attendingStudents'><i  style='position:absolute; left:-45px;top:40%;' class='glyphicon glyphicon-user'></i><h4 style='margin-left:30px;' class='studentList'>" + courses[1][i].name + "<span>\n\
                                                    <img style='position:absolute; left:-15px;top:7%;' class='studentImage' src='../uploads/" + courses[1][i].image + "'/></span></h4>"
                    $('.courseView').append(studentContainer);
                }

                //edit button click event - clear click events - change to edit course form - show image/attending students.


                $('#editCourse').click(function () {
                    showHide($(".courseAdd"));
                    $("#delete").attr('data-course', CourseData.id);
                    $("#delete").off('click');
                    $("#newCourse").off('submit');
                    $("#editCourseForm").off('submit');
                    $(".CourseForm").attr("id", "editCourseForm");
                    $('#editCourseForm').find('input[name=Cname]').val(courses[0].name);
                    $('#editCourseForm').find('input[name=Cphone]').val(courses[0].phone);
                    $('#editCourseForm').find('textarea[name=description]').val(courses[0].description);
                    $('#showImage').attr('src', "../uploads/" + courses[0].image + "");
                    $('#totalStudents').html('Total ' + courses[1].length + ' students taking this course');

                    //if courses has no students show delete button otherwise can't delete.

                    if (courses[1].length === 0) {
                        $("#delete").css("display", "block");
                    } else {
                        $("#delete").css("display", "none");
                    }

                    //course update submit ajax via post course id.

                    $("#editCourseForm").submit(function (e) {
                        $('.saveChange').attr('id', 'saveNoImg');
                        $(".saveChange").off('click');
                        $('#saveNoImg').click(function (event) {
                            event.preventDefault();
                            $("#img").attr("type", "text");
                            $('#showImage').attr('src', "../uploads/defualt.png");
                            $("#img").hide();
                            $("#img").val("#");
                            $("#editCourseForm").submit();
                        });

                        e.preventDefault();
                        if ($("#img").val() === '') {
                            $('#exampleModal').modal({show: true});
                            $('#exampleModalLabel').html('Are you sure you want to save without an image?');
                        } else {
                            var formData = new FormData(this);
                            formData.append('id', CourseData.id)
                            $.ajax({
                                type: 'POST',
                                url: '../Controllers/updateCourse.php',
                                data: formData,
                                contentType: false,
                                cache: false,
                                processData: false,
                                success: function (msg) {
                                    if (msg === 'ok') {
                                        if ($('.courselinks').attr('data-course', CourseData.id)) {
                                            $('.courselinks').click();
                                            $(".courseView ").css("display", "block");
                                        }
                                        $('#editCourseForm')[0].reset();
                                        $('.statusMsg').html('<span style="font-size:18px;color:#34A853">new Course Edited successfully.</span>');
                                        $(".courseAdd").css("display", "none");
                                        showDetails();
                                    } else if (msg === 'phoneErr') {
                                        $('.statusMsg').html('<span style="font-size:18px;color:#EA4335">Phone must be 10 digits!.</span>');
                                    } else if (msg === 'nameErr') {
                                        $('.statusMsg').html('<span style="font-size:18px;color:#EA4335">name must be 20 letters max!.</span>');
                                    } else if (msg === 'fileErr') {
                                        $('.statusMsg').html('<span style="font-size:18px;color:#EA4335">image must be up to 10 kb in size!.</span>');
                                    }
                                    else {
                                        $('.statusMsg').html('<span style="font-size:18px;color:#EA4335">Please fill out all fields.</span>');
                                    }
                                    $(".submitBtn").removeAttr("disabled");
                                }
                            });
                        }
                    });

                    //delete bootstrap modal.

                    $("#delete").attr('data-toggle', 'modal');
                    $("#delete").attr('data-target', '#exampleModal');

                    $("#delete").click(function (e) {
                        $('.saveChange').attr('id', 'saveDelete');
                        $(".saveChange").off('click');
                        $('#exampleModalLabel').html('Are you sure you want to delete this course?');
                        e.preventDefault();
                        $("#saveDelete").click(function (e) {
                            var CourseDeleteData = {id: CourseData.id};
                            $.ajax({
                                type: 'POST',
                                data: CourseDeleteData,
                                url: '../Controllers/deleteCourse.php',
                                success: function (msg) {
                                    if (msg.indexOf('ok') !== -1) {
                                        location.reload();
                                    } else {
                                        $('.statusMsg').html('<span style="font-size:18px;color:#EA4335">Could not delete course.</span>');
                                    }
                                }
                            });
                        });
                    });
                });
            }
        });
        $(".courseView ").css("display", "block");
    });

    //add course main ajax - clear events/msg and change image to file.

    $("#addCourse").click(function () {
        showHide($("#mainContainer"));
        showHide($(".courseAdd"));
        $("#editCourseForm").off('submit');
        $("#img").show();
        $("#img").attr("type", "file");
        $("#newCourse").off('submit');
        $(".CourseForm").attr("id", "newCourse");
        $(".CourseForm")[0].reset();
        $('#showImage').attr('src', "");
        $('.statusMsg').html('');
        $('.statusMsgStudent').html('');
        $('#saveDelete').attr('id', 'saveNoImg');

        //new course submit ajax.

        $("#newCourse").on('submit', function (e) {
            e.preventDefault();
            $('.saveChange').attr('id', 'saveNoImg');
            $('.saveChange').off('click');
            $('#saveNoImg').click(function (event) {
                event.preventDefault();
                $("#img").attr("type", "text");
                $('#showImage').attr('src', "../uploads/defualt.png");
                $("#img").hide();
                $("#img").val("#");
                $("#newCourse").submit();
            });
            if ($("#img").val() === '') {
                $('#exampleModal').modal({show: true});
                $('#exampleModalLabel').html('Are you sure you want to save without an image?');
            } else {
                $.ajax({
                    type: 'POST',
                    url: '../Controllers/addCourse.php',
                    data: new FormData(this),
                    contentType: false, cache: false,
                    processData: false,
                    success: function (msg) {
                        if (msg === 'ok') {
                            $('#newCourse')[0].reset();
                            $('.statusMsg').html('<span style="font-size:18px;color:#34A853">new Course submitted successfully.</span>');
                            $(".courseAdd").css("display", "none");
                            showDetails();
                        } else if (msg === 'phoneErr') {
                            $('.statusMsg').html('<span style="font-size:18px;color:#EA4335">Phone must be 10 digits!.</span>');
                        } else if (msg === 'nameErr') {
                            $('.statusMsg').html('<span style="font-size:18px;color:#EA4335">name must be 20 letters max!.</span>');
                        } else if (msg === 'fileErr') {
                            $('.statusMsg').html('<span style="font-size:18px;color:#EA4335">image must be up to 10 kb in size!.</span>');
                        } else if (msg === 'noFileErr') {
                            $('.statusMsg').html('<span style="font-size:18px;color:#EA4335">Please upload a file!.</span>');
                        }
                        else {
                            $('.statusMsg').html('<span style="font-size:18px;color:#EA4335">Please fill out all fields.</span>');
                        }
                        $(".submitBtn").removeAttr("disabled");
                    }
                });
            }
        });
    });

    //courses file type validation.

    $("#img").change(function (input) {
        var file = this.files[0];
        var imagefile = file.type;
        var match = ["image/jpeg", "image/png", "image/jpg"];
        if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
            $('.statusMsg').html('<span style="font-size:18px;color:#EA4335">Please select a valid image file!.</span>');
            $("#img").val('');
            return false;
        }
        var reader = new FileReader();
        reader.onload = function ()
        {
            $('#showImage').attr('src', reader.result);

        };
        reader.readAsDataURL(event.target.files[0]);
    });

    //students file type validation.

    $("#img2").change(function (input) {
        var file = this.files[0];
        var imagefile = file.type;
        var match = ["image/jpeg", "image/png", "image/jpg"];
        if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
            $('.statusMsg').html('<span style="font-size:18px;color:#EA4335">Please select a valid image file!.</span>');
            $("#img2").val('');
            return false;
        }
        var reader = new FileReader();
        reader.onload = function ()
        {
            $('#showStudentImage').attr('src', reader.result);

        };
        reader.readAsDataURL(event.target.files[0]);
    });
});
