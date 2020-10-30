<?php

require "dbBroker.php";
require "model/sir.php";

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
} elseif (isset($_GET['logout']) && !empty($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
}

$result = Sir::getAll($conn);

if (!$result) {
    echo "Nastala je greška pri izvođenju upita<br>";
    die();
}
if ($result->num_rows == 0)
{
    echo "Nema sireva";
    die();

}
else {



?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/home.css">
    <title>Sir i nemir</title>

</head>

<body>

<div class="jumbotron" style="color: black;"><h1>Dobrodošli na sajt "Sir i nemir"</h1>
    <h2>U tabeli možete vidjeti sve sireve koji su trenutno na stanju</h2>
</div>

<div class="row" style="background-color: rgba(255, 255, 255, 0.362);">
    <div class="col-md-4"><h2>Pregled dostupnih sireva</h2>
        <p>Pogledajte sireve u ponudi:</p>
        <button id="btn" class="btn btn-info btn-block"
                style="background-color: orange !important; border: 1px solid white;"><i
                    class="glyphicon glyphicon-th-list"></i> Pregled
        </button>
    </div>
    <div class="col-md-4"><h2>Dodaj novi sir</h2>
        <p>Dodaj novi sir:</p>
        <button id="btn-dodaj" type="button" class="btn btn-success btn-block"
                style="background-color: orange; border: 1px solid white;" data-toggle="modal" data-target="#myModal"><i
                    class="glyphicon glyphicon-plus"></i> Dodaj
        </button>

    </div>
    <div class="col-md-4"><h2>Pretraga sireva</h2>
        <p>Pretraži sireve po kriterijumu: </p>
        <button id="btn-pretraga" class="btn btn-warning btn-block"
                style="background-color:  orange; border: 1px solid white;" ><i
                    class="glyphicon glyphicon-search"></i> Pretraga
        </button>
        <input type="text" id="myInput" onkeyup="funkcijaZaPretragu()" placeholder="Pretrazi sireve" hidden>
    </div>
</div>

<div id="pregled" class="panel panel-success" style="margin-top: 1%; background-color: black;" >
    <div class="panel-heading" style="background-color: black; border: orange; color: orange; font-size: 36;">PREGLED SVIH SIREVA</div>
    <div class="panel-body">
        <table id="myTable" class="table table-hover table-striped" style="color: orange; background-color: black;">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Naziv sira</th>
                <th scope="col">Zemlja porijekla</th>
                <th scope="col">Cijena na 100g</th>
                <th scope="col">Kratak opis sira</th>
                <th scope="col">Izaberi ovaj sir</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($red = $result->fetch_array()) {
                ?>
                <tr>
                    <!--<th scope="row">{{ counter }}</th>-->
                    <td><?php echo $red["id"] ?></td>
                    <td><?php echo $red["naziv"] ?></td>
                    <td><?php echo $red["zemlja"] ?></td>
                    <td><?php echo $red["cijena"] ?></td>
                    <td><?php echo $red["opis"] ?></td>
                    <td>
                        <label class="custom-radio-btn">
                            <input type="radio" name="checked-donut" value=<?php echo $red["id"] ?>>
                            <span class="checkmark"></span>
                        </label>
                    </td>

                </tr>
                <?php
            }
            } ?>
            </tbody>
        </table>
        <div class="row" style="padding: 1%">
            <div class="col-md-12" style="text-align: right">
                <button id="btn-izmeni" class="btn btn-warning" style="background-color: blue; border: 1px solid white;"
                        data-toggle="modal" data-target="#izmeniModal"><i
                            class="glyphicon glyphicon-pencil"></i> Izmjeni
                </button>
                <button id="btn-obrisi" class="btn btn-danger" style="background-color: red; border: 1px solid white;"><i
                            class="glyphicon glyphicon-trash"></i> Obriši
                </button>
                <form action = "excel.php" method = "post" style="text-align: left">
                    <input type="submit" name="export_excel" class="btn btn-sucess" style="color: white; background-color: green; border: 1px solid white;" value="Generiši Excel tabelu"/>
                </form>
            </div>
        </div>
    </div>
    <a href="home.php?logout=true" style="float: left; padding: 10px">
        <button id="logout" type="button" class="btn btn-danger" style="background-color: orange; border: 1px solid white; float: right;">Odjavi se</button>
    </a>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog" >
    <div class="modal-dialog">

        <!--Sadrzaj modala-->
        <div class="modal-content" style="border: 3px solid orange;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="container sir-form">
                    <form action="#" method="post" id="dodajForm">
                        <h3 style="color: black">Dodavanje sira</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" style="border: 1px solid black" name="nazivSira" class="form-control"
                                           placeholder="Naziv sira *" value="<?php echo $red["id"] ?>"/>
                                </div>
                                <div class="form-group">
                                    <input type="text" style="border: 1px solid black" name="zemljaSira" class="form-control" placeholder="Zemlja porijekla sira *"
                                           value=""/>
                                </div>
                                <div class="form-group">
                                    <input type="number" style="border: 1px solid black" name="cijenaSira" class="form-control"
                                           placeholder="Cijena sira *" value=""/>
                                </div>
                                <div class="form-group">
                                    <button id="btnDodaj" type="submit" class="btn btn-success btn-block"
                                            style="background-color: orange; border: 1px solid black;"><i
                                                class="glyphicon glyphicon-plus"></i> Dodaj sir
                                    </button>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <textarea name="opisSira" class="form-control" placeholder="Kratak opis sira *"
                                              style="width: 100%; height: 150px; border: 1px solid black;"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" style="color: white; background-color: orange; border: 1px solid white" data-dismiss="modal">Zatvori</button>
            </div>
        </div>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="izmeniModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal sadrzaj-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="container sir-form">
                    <form action="#" method="post" id="izmeniForm">
                        <h3 style="color: black">Izmjena sira</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input id="id" type="text" name="idSira" class="form-control"
                                           placeholder="Id sira *" value="" readonly/>
                                </div>
                                <div class="form-group">
                                    <input id="nazivv" type="text" name="nazivSira" class="form-control"
                                           placeholder="Naziv sira *" value=""/>
                                </div>
                                <div class="form-group">
                                    <input id="zemljaa" type="text" name="zemljaSira" class="form-control"
                                           placeholder="Zemlja porijekla sira *" value=""/>
                                </div>
                                <div class="form-group">
                                    <input id="cijenaa" type="number" name="cijenaSira" class="form-control"
                                           placeholder="Cijena sira *" value=""/>
                                </div>
                                <div class="form-group">
                                    <button id="btnIzmeni" type="submit" class="btn btn-success btn-block"
                                            style="color: white; background-color: orange; border: 1px solid white"><i
                                                class="glyphicon glyphicon-pencil"></i> Izmjeni sir
                                    </button>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <textarea id="opiss" name="opisSira" class="form-control"
                                              placeholder="Opis sira *"
                                              style="width: 100%; height: 150px;"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Zatvori</button>
            </div>
        </div>

    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
<script>
    function funkcijaZaPretragu() {

        // Declare variables
        var input, filter, table, tr, i, td1, td2, td3, td4, txtValue1, txtValue2, txtValue3, txtValue4;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td1 = tr[i].getElementsByTagName("td")[1];
            td2 = tr[i].getElementsByTagName("td")[2];
            td3 = tr[i].getElementsByTagName("td")[3];
            td4 = tr[i].getElementsByTagName("td")[4];

            if (td1 || td2 || td3 || td4) {
                txtValue1 = td1.textContent || td1.innerText;
                txtValue2 = td2.textContent || td2.innerText;
                txtValue3 = td3.textContent || td3.innerText;
                txtValue4 = td4.textContent || td4.innerText;

                if (txtValue1.toUpperCase().indexOf(filter) > -1 || txtValue2.toUpperCase().indexOf(filter) > -1
                    || txtValue3.toUpperCase().indexOf(filter) > -1 || txtValue4.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>


</body>
</html>
