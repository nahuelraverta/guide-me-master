<!-- buscador -->

<?php
include("administrador/config/bd.php");

if (!empty($_GET['busqueda'])) {
    $termino_busqueda = $_GET['busqueda'];
    $sentenciaSQL = $conexion->prepare("SELECT * FROM libro WHERE nombre LIKE '%$termino_busqueda%' ORDER BY nombre");
} else {
    $sentenciaSQL = $conexion->prepare("SELECT * FROM libro ORDER BY nombre");
}

$sentenciaSQL->execute();
$listaLibros = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<?php if (count($listaLibros) == 0) { ?>
    
        <div class="alert alert-warning" role="alert">
            No se encontraron resultados para "<?php echo $_GET['busqueda']; ?>"
        </div>
    
<?php } ?>


<!-- Fin del buscador -->

<?php
include("administrador/config/bd.php");

if (!empty($_GET['busqueda'])) {
    $termino_busqueda = $_GET['busqueda'];
    $sentenciaSQL = $conexion->prepare("SELECT * FROM libro WHERE nombre LIKE '%$termino_busqueda%' ORDER BY nombre");
} else {
    $sentenciaSQL = $conexion->prepare("SELECT * FROM libro ORDER BY nombre");
}

$sentenciaSQL->execute();
$listaLibros = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>