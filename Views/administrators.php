<?php
session_start();
?>
<?php
//routing - if session is set and session role name is not sales show administrators page. else (end of page) redirect to login.

if ((isset($_SESSION['userRole']) && ($_SESSION['userRole'] !== 'sales'))) {
    ?>
    <html>
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="https://fonts.googleapis.com/css?family=Karla" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
            <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
            <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
            <link rel="stylesheet" href="../css/administrators.css">
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
            <title></title>
        </head>
        <body>

            <!-- Bootstrap Modal for confirmations -->

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to delete this administrator?</h5>
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


            <nav class="navbar navbar-default navbar-fixed-top ">
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
                                    <a href="administrators.php">Administration</a>
                                </li>
                            </ul>     
                        </div>             
                    </div>
                </div>
            </nav>

            <!-- Admins list -->


            <div class="row main">

                <div class="col-xs-4">

                    <div class="col-xs-6">                     
                        <h3 id="adminList">Administrators
                            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <span><button style="color:black;" id="addAdmin" class="glyphicon glyphicon-plus"></button></span>
                        </h3>

                    </div>
                </div>

                <!-- Main container on page load - Admins overview (if user is not owner he isn't presented) -->

                <div id="mainContainer" class="col-xs-8">

                    <button id="showAdmins" class="btn btn-success">All Administrators</button>


                    <!-- admin add/edit main form -->

                    <p class="statusMsg"></p>
                    <div class="form-style-5 adminAdd">
                        <form enctype="multipart/form-data" class='AdminForm' id="newAdmin">
                            <input id="save" type="submit" class="btn btn-default" value="Save">
                            <input id="delete" type="button" class="btn btn-default" value="Delete">
                            <fieldset>
                                <legend>Admin Info</legend>
                                <label for="Aname">Name:</label>
                                <input type="text" name="Aname" placeholder="Admin Name..">
                                <label for="Apassword">Password:</label>
                                <input type="password" name="Apassword" placeholder="Admin password..">
                                <label for="Aphone">Phone:</label>
                                <input type="text" name="Aphone" placeholder="Admin Phone..">
                                <label for="Aemail">Email:</label>
                                <input type="text" name="Aemail" placeholder="Admin email..">
                                <label for="Arole">Role:</label>
                                <select id="roleSelect" name="Arole">
                                    <option value="sales">sales</option>  
                                    <option value="manager">manager</option>                                
                                    <option id='Owner' value='owner'>owner</option>
                                </select>
                                <fieldset id="newOwner">
                                    <label for="newOwner">New Owner:</label>
                                    <input id="ownerInput" type="text" name="newOwner" placeholder="New Owner..">
                                </fieldset>
                            </fieldset>
                            <fieldset>
                                <legend>Additional Info</legend>
                                <label for="file">Image:</label>
                                <input id="img" type='file' name='file' />
                                <img id="showImage" src="#" alt="your image" />
                            </fieldset>
                        </form>
                    </div>

                    <!-- admin details view -->

                    <div class="form-style-5 adminView">               
                        <div class="formHeader">
                            <h4 id="adminViewHeader"></h4>
                            <input id="editAdmin" type="button" class="btn btn-default" value="Edit"> 
                        </div>
                        <fieldset id="firstDescription" class="adminDescription" style="padding-top:7px;">                    
                            <h3 class="adminHeader"></h3>
                            <h4 class="adminPhone"></h4>
                            <h4 class="adminEmail"></h4>
                            <img class="adminImage" src="#"/>
                        </fieldset>
                    </div>                      
                </div>
            </div>

            <!-- Footer -->

            <footer id="footer">
                <div class="footer-copyright">
                    <div class="container">
                        <div class="row">                            
                            <div class="col-md-7">
                                <p id="copyright">© 2018 Ben Herman - Full stack web development.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <script type="text/javascript">
                var sessionRole = "<?php echo $_SESSION['userRole']; ?>";
                var sessionName = "<?php echo $_SESSION['userName']; ?>";
            </script>
            <script src="../scripts/administrators.js">
            </script>
        </body>
    </html>
    <?php
} else {
    $request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);
    switch ($request_uri[0]) {
        // Home page
        case '/theschool/Views/administrators.php':
            require 'login.php';
            break;
        default:
            header('HTTP/1.0 404 Not Found');
            require '404.php';
            break;
    }
}
