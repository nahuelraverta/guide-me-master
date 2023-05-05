<?php
$host="localhost";
$bd="id20362831_sitio";
$usuario="id20362831_nahuelrav";
$contrasenia="Larush2!!Lar";

try {
    $conexion= new PDO("mysql:host=$host;dbname=$bd",$usuario,$contrasenia);
    

} catch ( Exception $ex) {

    echo $ex->getMessage();
    //throw $th;
}

?>