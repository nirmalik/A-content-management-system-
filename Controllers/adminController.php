<?php

require_once '../DBCalls/DBcalls.php';

//login page controllers php! - not admin.

// sha1 password encryption + salt - check if user already exists - if he is set user session(session role and session name)
//else echo wrong details to login page.


$salt = "random salt text";
$loginPassword = $_POST["password"] . $salt;

$loginPassword1 = sha1($loginPassword);

if (loginIfUserExist($_POST["username"],$loginPassword1)) {
    setUserSession($_POST["username"]);
    echo 'ok';
} else {
    echo 'WrongLoginDetails';
}


