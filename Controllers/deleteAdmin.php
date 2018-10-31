
<?php

require_once '../DBCalls/DBcalls.php';

//POST request Admin id and delete - if delete is ok echo ok.

$id = $_POST['id'];

$delete = deleteAdmin($id);

if($delete) {   
    echo 'ok';
}else {    
    echo 'err';
}

