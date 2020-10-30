<?php
require "../dbBroker.php";
require "../model/sir.php";

if (isset($_POST['nazivSira']) && isset($_POST['zemljaSira']) 
    && isset($_POST['opisSira']) && isset($_POST['cijenaSira'])) {
    $status = Sir::add($_POST['nazivSira'], $_POST['zemljaSira'], $_POST['opisSira'], $_POST['cijenaSira'], $conn);
    if ($status) {
        echo 'Success';
    } else {
        echo $status;
        echo 'Failed';
    }
}