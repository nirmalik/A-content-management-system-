
<?php

require_once '../DBCalls/DBcalls.php';

//POST request Course id and delete - if delete is ok echo ok.

$id = $_POST['id'];

$delete = deleteCourse($id);

if($delete) {   
    echo 'ok';
}else {    
    echo 'err';
}

