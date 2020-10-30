<?php
    function executeQuery($query)
    {
        $connect = mysqli_connect("localhost", "neko", "Kvantifikator1", "sirevi");
        $result = mysqli_query($connect, $query);
        return $result;
    }

    if(isset($_POST['ASC']))
    {
        $asc_query = "SELECT * FROM sir ORDER BY cijena ASC";
        $result = executeQuery($asc_query);
    }
    elseif (isset($_POST['DESC']))
    {
        $desc_query = "SELECT * FROM sir ORDER BY cijena DESC";
        $result = executeQuery($desc_query);
    }
?>