<?php

//destroy user session and return to login page.

session_start();
session_destroy();
header('Location:../Views/login.php');
