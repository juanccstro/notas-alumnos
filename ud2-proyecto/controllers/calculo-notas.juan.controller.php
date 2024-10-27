<?php
/*
 * Aquí hacemos los ejercicios y rellenamos el array de datos.
 */
declare(strict_types=1);

$data = [];

// Comprueba que el usuario a enviado algo mediante el formulario
if (!empty($_POST)) {
    $data['errores'] = comprobarErroresForm($_POST['json']);
    $data['input']['json'] = filter_var($_POST['json'], FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($data['errores'])) {
        $datos = json_decode($_POST['json'], true);
        $alumnosSusp = [];
        $resultado = [];

        foreach ($datos as $materia => $alumnos) {

            $datosMateria = [];
            $suspensos = $aprobados = $sumaNotas = 0;
            $max = ['alumno' => '-', 'nota' => -1];
            $min = ['alumno' => '-', 'nota' => 11];

            foreach ($alumnos as $alumno => $notas) {
                $alumnosSusp[$alumno] = $alumnosSusp[$alumno] ?? 0;
                $sumaNotas += array_sum($notas);
                $numNotas = count($notas);


                // Calcular los suspensos y aprobados
                if (max($notas) < 5) {
                    $suspensos++;
                    $alumnosSusp[$alumno] += 1;
                } else {
                    $aprobados++;
                }

                // Nota mínima y máxima
                $notaActual = max($notas);
                if ($notaActual < $min['nota']) {
                    $min = ['alumno' => $alumno, 'nota' => $notaActual];
                }
                if ($notaActual > $max['nota']) {
                    $max = ['alumno' => $alumno, 'nota' => $notaActual];
                }
            }

            $datosMateria = [
                'notaMedia' => $sumaNotas / (count($alumnos) * $numNotas),
                'suspensos' => $suspensos,
                'aprobados' => $aprobados,
                'notaMax' => $max,
                'notaMin' => $min
            ];
            $resultado[$materia] = $datosMateria;
        }

        $data['resultado'] = $resultado;
        $data['listados'] = agruparPorNotas($alumnosSusp);
    }
}


function agruparPorNotas(array $alumnos): array
{
    $promocionan = [];
    $noPromocionan = [];
    $suspenden = [];
    $aprueban = [];

    foreach ($alumnos as $alumno => $suspensos) {
        if ($suspensos === 0) {
            // No suspende ninguna materia
            $aprueban[] = $alumno;
        } elseif ($suspensos < 2) {
            // Suspende solo una materia
            $promocionan[] = $alumno;
            $suspenden[] = $alumno; // También entra en suspenden
        } elseif ($suspensos >= 2) {
            // Suspende dos o más materias
            $noPromocionan[] = $alumno;
            $suspenden[] = $alumno; // También entra en suspenden
        }
    }

    return [
        'aprueban' => $aprueban,
        'promocionan' => $promocionan,
        'suspenden' => $suspenden,
        'noPromocionan' => $noPromocionan
    ];
}


/*
* Comprobar errores del formulario (campos vacíos, incompletos o incorrectos)
*/
function comprobarErroresForm(string $json): array
{
    $errores = [];
    if (empty($json)) {
        $errores['json'][] = 'El campo es obligatorio';
    } else {
        $datos = json_decode($json, true);

        if (is_null($datos)) {
            $errores['json'][] = 'Debes introducir un JSON valido';
        } else {
            if (!is_array($datos)) {
                $errores['json'][] = 'Debes introducir un array dentro del JSON';
            } else {
                foreach ($datos as $materia => $alumnos) {
                    if (!is_string($materia) || mb_strlen($materia) == 0)
                        $errores['json'][] = "Debes introducir una asignatura valida, ERROR: '$materia'";
                }
                if (!is_array($alumnos)) {
                    $errores['json'][] = "El JSON debe ser un array de alumnos, ERROR: '$materia'";
                } else {
                    foreach ($alumnos as $alumno => $notas) {
                        if (!is_string($alumno) || mb_strlen(trim($alumno)) == 0) {
                            $errores['json'][] = "Debes introducir un alumno válido, ERROR: '$alumno' en la materia '$materia'";
                        }
                        if (!is_array($notas) || empty($notas)) {
                            $errores['json'][] = "Las notas de '$alumno' en '$materia' deben ser un array no vacío";
                        } else {
                            foreach ($notas as $nota) {
                                if (!is_numeric($nota)) {
                                    $errores['json'][] = "Cada nota debe ser un número, ERROR: '$nota' de '$alumno' en '$materia'";
                                }
                            }
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