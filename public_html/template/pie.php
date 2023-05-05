
</div>

</div>

</body>
</html>


<!-- SCRIPT DE VER MAS Y VER MENOS DE LA DESCRIPCION DE "PRODUCTOS" -->
<script>
    function verMas(event) {
        event.preventDefault();
        var resumen = event.target.parentElement; // Obtiene el elemento padre del enlace "Ver más"
        var completo = resumen.nextElementSibling; // Obtiene el siguiente elemento, que contiene la descripción completa
        resumen.style.display = 'none'; // Oculta la descripción resumida
        completo.style.display = 'block'; // Muestra la descripción completa
    }

    function verMenos(event) {
        event.preventDefault();
        var completo = event.target.parentElement; // Obtiene el elemento padre del enlace "Ver menos"
        var resumen = completo.previousElementSibling; // Obtiene el elemento anterior, que contiene la descripción resumida
        completo.style.display = 'none'; // Oculta la descripción completa
        resumen.style.display = 'block'; // Muestra la descripción resumida
    }
</script>
