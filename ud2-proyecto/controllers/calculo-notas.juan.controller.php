<?php
/*
 * Aquí hacemos los ejercicios y rellenamos el array de datos.
 */

/*
* Comprobar errores del formulario (campos vacíos, incompletos o incorrectos
*/
function comprobarErroresForm(string $texto): array
{
    $errores = [];
    if (empty($texto)) {
        $errores['texto'][] = 'El campo es obligatorio';
    } else {
        $datos = json_decode($texto);
        if (is_null($datos)) {
            $errores['texto'][] = 'Debes introducir un JSON valido';
        } else {
            if (!is_array($datos)) {
                $errores['texto'][] = 'Debes introducir un array dentro del JSON';
            } else {
                foreach ($datos as $materia => $alumnos) {
                    if (!is_string($materia) || mb_strlen($materia) == 0)
                        $errores['texto'][] = "Debes introducir una asignatura valida, ERROR: '$materia'";
                }
                if (!is_array($alumnos)) {
                    $errores['texto'][] = "El JSON debe ser un array de alumnos, ERROR: '$materia'";
                } else {
                    foreach ($alumnos as $alumno => $nota) {
                        if (!is_string($alumno) || mb_strlen(trim($alumno)) == 0) {
                            $errores['texto'][] = "Debes introducir un alumno válido, ERROR: '$alumno' de la materia '$materia'";
                        }

                    }
                }
            }
        }
    }
    return $errores;
}



/*
 * Llamamos a las vistas
 */
include 'views/templates/header.php';
include 'views/calculo-notas.juan.view.php';
include 'views/templates/footer.php';