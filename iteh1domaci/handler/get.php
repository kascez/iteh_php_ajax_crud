<?php

require "../dbBroker.php";
require "../model/sir.php";

if(isset($_POST['id'])) {
    $myArray = Sir::getById($_POST['id'], $conn);
    echo json_encode($myArray);
}