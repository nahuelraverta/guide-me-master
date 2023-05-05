<?php 
$librosPorPagina = 8;
$paginas = array_chunk($listaLibros, $librosPorPagina);
$numPaginas = count($paginas);
$paginaActual = $_GET['pagina'] ?? 1; // Obtener la página actual de la URL
?>