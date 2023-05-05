<?php include("template/cabecera.php"); ?>
<?php include("template/buscador.php"); ?>
<?php include("template/paginacion.php"); ?>

<br>
<div>
  <div class="container">
    <div class="row">

<?php foreach ($paginas[$paginaActual - 1] as $libro) { ?>
    <div class="col-md-3 nop">


        <div class="card">
            <img src="./img/<?php echo $libro['imagen']; ?>" alt="">
            <div class="card-content">
                <h2>
                    <?php echo $libro['nombre']; ?>
                </h2>
                <p>
                    <?php echo substr($libro['descripcion'], 0, 100); ?>
                </p>


                <a href="#" class="button">
                    <?php if (!empty($libro['descarga'])) { ?>
                        <a name="" id="" class="btn btn-primary" href="<?php echo $libro['descarga']; ?>" target="_blank"
                            role="button"><?php echo $libro['editorial']; ?> GUIDE</a>
                    <?php } ?>
                </a>
            </div>
        </div>

    </div>
    

<?php } ?>

<!-- Navegación de paginación -->
<br>
<div class="paginacion" >
<style>
.paginacion {
    display: flex;
    justify-content: center;
    margin-top: 20px; /*opcional, si deseas agregar un margen superior*/
}
</style>

    <nav aria-label="Páginas">
        <ul class="pagination">
            <?php for ($i = 1; $i <= $numPaginas; $i++) { ?>
                <li class="page-item <?php echo $i == $paginaActual ? 'active' : ''; ?>">
                    <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php } ?>
        </ul>
    </nav>
</div>


<?php include("template/pie.php"); ?>