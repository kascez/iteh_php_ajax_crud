<?php
require "../dbBroker.php";
require "../model/sir.php";

if(isset($_POST['id'])) {
    $status = Sir::deleteById($_POST['id'], $conn);
    if ($status) {
        echo 'Success';
    } else {
        echo 'Failed';
    }
}