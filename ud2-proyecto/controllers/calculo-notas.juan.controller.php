<?php
/*
 * Aquí hacemos los ejercicios y rellenamos el array de datos.
 */
$data['titulo'] = "Ejercicio ud3";
$data["div_titulo"] = "Cálculos de notas";
$data['texto'] = "Preparado para ejercicio de cálculo de notas";

/*
 * Llamamos a las vistas
 */
include 'views/templates/header.php';
include 'views/calculo-notas.juan.view.php';
include 'views/templates/footer.php';