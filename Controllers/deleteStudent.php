
<?php

require_once '../DBCalls/DBcalls.php';

//POST request Student id and delete - if delete is ok echo ok.

$id = $_POST['id'];

$delete = deleteStudent($id);

if($delete) {   
    echo 'ok';
}else {    
    echo 'err';
}
