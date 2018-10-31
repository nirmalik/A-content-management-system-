<?php

require_once '../DBCalls/DBcalls.php';

require_once '../Models/Admin.php';

//Post request for Admin id and retrieve admin details to Dom.

 $id = $_POST["id"];

showAdminDetails($id);


