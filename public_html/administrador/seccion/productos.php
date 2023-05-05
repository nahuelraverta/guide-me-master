<?php include("../template/cabecera.php"); ?>

<?php

$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
$txtImagen = (isset($_FILES['txtImagen']['name'])) ? $_FILES['txtImagen']['name'] : "";
$txtDescripcion = (isset($_POST['txtDescripcion'])) ? $_POST['txtDescripcion'] : "";
$txtEditorial = (isset($_POST['txtEditorial'])) ? $_POST['txtEditorial'] : "";
$txtDescarga = (isset($_POST['txtDescarga'])) ? $_POST['txtDescarga'] : "";

$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

include("../config/bd.php");

switch ($accion) {
    case "Agregar":
        $sentenciaSQL = $conexion->prepare("INSERT INTO libro (nombre, imagen, descripcion, editorial, descarga) VALUES (:nombre, :imagen, :descripcion, :editorial, :descarga);");
        $sentenciaSQL->bindParam(':nombre', $txtNombre);
        $sentenciaSQL->bindParam(':descripcion', $txtDescripcion);
        $sentenciaSQL->bindParam(':editorial', $txtEditorial);
        $sentenciaSQL->bindParam(':descarga', $txtDescarga); 
       
        $fecha = new DateTime();
        $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "_" . $_FILES["txtImagen"]["name"] : "imagen.jpg";

        $tmpImagen = $_FILES["txtImagen"]["tmp_name"];

        if ($tmpImagen != "") {

            move_uploaded_file($tmpImagen, "../../img/" . $nombreArchivo);

        }
        header("Location:productos.php");

        $sentenciaSQL->bindParam(':imagen', $nombreArchivo);
        $sentenciaSQL->execute();
        break;

    case "Modificar":

        $sentenciaSQL = $conexion->prepare("UPDATE libro SET nombre=:nombre, descripcion=:descripcion, editorial=:editorial, descarga=:descarga WHERE id=:id");
        $sentenciaSQL->bindParam(':nombre', $txtNombre);
        $sentenciaSQL->bindParam(':descripcion', $txtDescripcion);
        $sentenciaSQL->bindParam(':editorial', $txtEditorial);
        $sentenciaSQL->bindParam(':descarga', $txtDescarga);
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();

        if ($txtImagen != "") {
            $fecha = new DateTime();
            $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "_" . $_FILES["txtImagen"]["name"] : "imagen.jpg";
            $tmpImagen = $_FILES["txtImagen"]["tmp_name"];
            move_uploaded_file($tmpImagen, "../../img/" . $nombreArchivo);

            $sentenciaSQL = $conexion->prepare("SELECT imagen FROM libro WHERE id=:id");
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();
            $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

            if (isset($libro["imagen"]) && ($libro["imagen"] != "imagen.jpg")) {
                if (file_exists("../../img/" . $libro["imagen"])) {
                    unlink("../../img/" . $libro["imagen"]);
                }
            }




            $sentenciaSQL = $conexion->prepare("UPDATE libro SET imagen=:imagen WHERE id=:id");
            $sentenciaSQL->bindParam(':imagen', $nombreArchivo);
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();

        }
        header("Location:productos.php");

        break;

    case "Cancelar":
        header("Location:productos.php");

        break;

    case "Seleccionar":
        $sentenciaSQL = $conexion->prepare("SELECT * FROM libro WHERE id=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $txtNombre = $libro['nombre'];
        $txtDescripcion = $libro['descripcion'];
        $txtEditorial = $libro['editorial'];
        $txtDescarga = $libro['descarga'];
        $txtImagen = $libro['imagen'];
        // echo "Presionado boton Seleccionar";

        break;

    case "Borrar":

        $sentenciaSQL = $conexion->prepare("SELECT imagen FROM libro WHERE id=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        if (isset($libro["imagen"]) && ($libro["imagen"] != "imagen.jpg")) {
            if (file_exists("../../img/" . $libro["imagen"])) {
                unlink("../../img/" . $libro["imagen"]);
            }
        }

        $sentenciaSQL = $conexion->prepare("DELETE FROM libro WHERE id=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();

        header("Location:productos.php");

        break;



}

$sentenciaSQL = $conexion->prepare("SELECT * FROM libro");
$sentenciaSQL->execute();
$listaLibros = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>


<div class="col-md-5">
    <div class="card">
        <div class="card-header">
            Datos de la Guia
        </div>
        <div class="card-body">

            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="txtID">ID: </label>
                    <input type="text" required readonly class="form-control" value="<?php echo $txtID; ?> "
                        name="txtID" id="txtID" placeholder="ID">
                </div>

                <div class="form-group">
                    <label for="txtNombre">Nombre: </label>
                    <input type="text" required class="form-control" value="<?php echo $txtNombre; ?>" name="txtNombre"
                        id="txtNombre" placeholder="Nombre del libro">
                </div>

                <div class="form-group">
                    <label for="txtNombre">Descripcion: </label>
                    <input type="text" required class="form-control" value="<?php echo $txtDescripcion; ?>" name="txtDescripcion"
                        id="txtDescripcion" placeholder="Descripcion de la guia">
                </div>

                <div class="form-group">
                    <label for="txtNombre">Editorial: </label>
                    <input type="text" required class="form-control" value="<?php echo $txtEditorial; ?>" name="txtEditorial"
                        id="txtEditorial" placeholder="Ingrese la editorial de la guia">
                </div>

                <div class="form-group">
                    <label for="txtNombre">Link de descarga: </label>
                    <input type="text" class="form-control" value="<?php echo $txtDescarga; ?>" name="txtDescarga"
                        id="txtDescarga" placeholder="URL de descarga">
                </div>

                <div class="form-group">
                    <label for="txtNombre" required>Imagen: </label>
                    <br>
                    <?php
                    if ($txtImagen != "") { ?>

                        <img class="img-thumbnail rounded" src="../../img/<?php echo $txtImagen; ?>" width="50">

                    <?php } ?>

                    <input type="file" class="form-control" name="txtImagen" id="txtImagen"
                        placeholder="Nombre del libro">
                </div>



                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" <?php echo ($accion == "Seleccionar") ? "disabled" : ""; ?>
                        value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" <?php echo ($accion != "Seleccionar") ? "disabled" : ""; ?>
                        value="Modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion" <?php echo ($accion != "Seleccionar") ? "disabled" : ""; ?>
                        value="Cancelar" class="btn btn-info">Cancelar</button>
                </div>

            </form>


        </div>

    </div>






</div>
<div class="col-md-7">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Acciones</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($listaLibros as $libro) { ?>
                <tr>
                    <td>
                        <?php echo $libro['id']; ?>
                    </td>
                    <td>
                        <?php echo $libro['nombre']; ?>
                    </td>
                    <td>
                        <img class="img-thumbnail rounded" src="../../img/<?php echo $libro['imagen']; ?>" width="50">


                    </td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="txtID" value="<?php echo $libro['id']; ?>" />
                            <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary" />
                            <button type="submit" name="accion" value="Borrar" class="btn btn-danger">Borrar</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>

        </tbody>
    </table>
</div>

<?php include("../template/pie.php"); ?>