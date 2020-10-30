<?php
    $connect = mysqli_connect("localhost", "neko", "Kvantifikator1", "sirevi");
    $output = '';
    if(isset($_POST["export_excel"]))
    {
        $sql = "SELECT * FROM sir ORDER BY id DESC";
        $result = mysqli_query($connect, $sql);
        if (mysqli_num_rows($result) > 0)
        {
            $output .= '
                <table class="table" bordered = "1">
                <tr>
                    <th>ID</th>
                    <th>Naziv</th>
                    <th>Zemlja porijekla</th>
                    <th>Cijena</th>
                    <th>Opis</th>
                </tr>
            ';
            while($row = mysqli_fetch_array($result))
            {
                $output .= '
                    <tr>
                        <td>' .$row["id"].'</td>
                        <td>' .$row["naziv"].'</td>
                        <td>' .$row["zemlja"].'</td>
                        <td>' .$row["cijena"].'</td>
                        <td>' .$row["opis"].'</td>
                    </tr>
                ';
            }
            $output .= '</table>';
            header("Content-Type: application/xls");
            header("Content-Disposition: attachment; filename = tabela.xls");
            echo $output;
        }
    }
?>