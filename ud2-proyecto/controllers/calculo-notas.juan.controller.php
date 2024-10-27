<?php
/*
 * Aquí hacemos los ejercicios y rellenamos el array de datos.
 */
declare(strict_types=1);

$data = [];

if (!empty($_POST)) {
    $data['errores'] = comprobarErroresForm($_POST['texto']);
    $data['input']['texto'] = filter_var($_POST['texto'], FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($data['errores'])) {
        $datos = ($_POST['texto']);
        $alumnosSusp = [];
        $resultado = [];

        // Recorro el array de materias y dentro de ese el de los alumnos que contiene poniendo nombre a esos valores
        foreach ($datos as $materia => $alumnos) {
            $datosMateria = [];

            $suspensos = 0;
            $aprobados = 0;
            $sumaNotas = 0;
            $min = [];
            $min['alumno'] = '';
            $min['nota'] = -1;
            $max = [];
            $max['alumno'] = '';
            $max['nota'] = 10;


            //Recorre array de notas y contabiliza los suspensos y aprobados
            foreach ($alumnos as $alumno => $nota) {
                $alumnosSusp[$alumno] = 0;
                $sumaNotas += $nota;
                if ($nota < 5) {
                    $suspensos++;
                    $alumnosSusp[$alumno]++;
                } else
                    $aprobados++;
            }
            if ($min['nota'] < $nota)
                $alumnoMin['alumno'] = $alumno;
            $notaMin['nota'] = $nota;
        }
        if ($max['nota'] < $nota)
            $alumnoMax['alumno'] = $alumno;
        $notaMax['nota'] = $nota;
    }
    $datosMateria['notaMedia'] = $sumaNotas / count($alumnos);
    $datosMateria['suspensos'] = $suspensos;
    $datosMateria['aprobados'] = $aprobados;
    if (!empty ($alumnos)) {
        $datosMateria['notaMax'] = $notaMax;
        $datosMateria['notaMin'] = $notaMin;
    } else {
        $datosMateria['max'] = ['alumno' => '', 'nota' => ''];
        $datosMateria['min'] = ['alumno' => '', 'nota' => ''];
    }
    $resultado['materia'] = $datosMateria;
    $data['resultado'] = $resultado;
}


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