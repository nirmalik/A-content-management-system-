
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Courses/Students CMS</title>   
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">  
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>    
        <link rel="stylesheet" href="../css/style.css">        
    </head>

    <body>

        <div class="container">

            <div class="row">

                <div class="col-md-6 col-md-offset-3">                 
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-12">
                                <h1 id="effect"><span  id="PHP">PHP</span><span id="Project"> Project</span><span id="-"> -</span><span id="Ben"> Ben</span><span id="Herman"> Herman</span></h1>
                            </div>                           
                        </div>
                    </div>                  
                    <div class="panel-body">
                        <div class="row">
                            <div id="errorCol" class="col-sm-6">
                                <p id="loginError"></p>
                            </div>
                        </div>                        
                        <div class="row">                                
                            <div class="col-lg-12">                               
                                <form id="login-form" method="post" role="form" style="display: block;">                                      
                                    <div class="form-group">
                                        <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-3">
                                                <input type="button" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
                                            </div>
                                        </div>
                                    </div>                             
                                </form>  
                            </div>
                        </div>                    
                    </div>
                </div>
            </div>
        </div>


        <script>

            $(function () {
                
                //hide ans show effect plugin functons.

                $(".row").hide();
                $("#PHP").hide();
                $("#Project").hide();
                $("#-").hide();
                $("#Ben").hide();
                $("#Herman").hide();

                setTimeout(function () {
                    $(".row").show("fade", 700);
                }, 400);

                setTimeout(function () {
                    $("#PHP").show("fade", 700);
                }, 800);

                setTimeout(function () {
                    $("#Project").show("fade", 700);
                }, 1200);

                setTimeout(function () {
                    $("#-").show("fade", 700);
                }, 1600);


                setTimeout(function () {
                    $("#Ben").show("fade", 700);
                }, 2000);

                setTimeout(function () {
                    $("#Herman").show("fade", 700);
                }, 2400);

            //login form submit on click event. if login returns false error will show and form will shake.

                $("#login-submit").on("click", function () {
                    var loginErrDiv = document.getElementById("loginError");

                    var loginDetails = {username: $('#username').val(), password: $('#password').val()}
                    $.ajax({
                        type: 'POST',
                        url: "../Controllers/adminController.php",
                        data: loginDetails,
                        success: function (msg) {
                            if (msg === 'ok') {
                                window.location = "../Views/index.php";
                            } else {
                                $(".row").effect("shake", 500);
                                loginErrDiv.innerHTML = "Wrong username or password!";
                            }
                        }
                    });
                });

            });

        </script>
    </body>
</html>





