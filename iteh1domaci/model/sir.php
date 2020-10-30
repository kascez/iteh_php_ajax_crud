<?php
class Sir
{
    public $id;
    public $naziv;
    public $zemlja;
    public $opis;
    public $cijena;

    public function __construct($id = null, $naziv = null, $zemlja = null, $opis = null, $cijena = null)
    {
        $this->id = $id;
        $this->naziv = $naziv;
        $this->zemlja = $zemlja;
        $this->opis = $opis;
        $this->cijena = $cijena;
    }

    public static function getAll(mysqli $conn)
    {
        $q = "SELECT * FROM sir";
        return $conn->query($q);
    }

    public static function getById($id, mysqli $conn)
    {
        $q = "SELECT * FROM sir WHERE id=$id";
        $myArray = array();
        if ($result = $conn->query($q)) {

            while ($row = $result->fetch_array(1)) {
                $myArray[] = $row;
            }
        }
        return $myArray;
    }

    public static function deleteById($id, mysqli $conn)
    {
        $q = "DELETE FROM sir WHERE id=$id";
        return $conn->query($q);
    }

    public static function add($naziv, $zemlja, $opis, $cijena, mysqli $conn)
    {
        $q = "INSERT INTO sir(naziv,zemlja,opis,cijena) values('$naziv','$zemlja', '$opis', $cijena)";
        return $conn->query($q);
    }

    public static function update($id, $naziv, $zemlja, $opis, $cijena, mysqli $conn)
    {
        $q = "UPDATE sir set naziv='$naziv', zemlja='$zemlja', opis='$opis', cijena='$cijena' where id=$id";
        return $conn->query($q);
    }
}