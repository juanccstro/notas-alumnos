<?php
/*
 * Aquí hacemos los ejercicios y rellenamos el array de datos.
 */
declare(strict_types=1);

$data = [];
// Comprueba que el usuario ha enviado algo mediante el formulario
if (!empty($_POST)) {
    $data['errores'] = comprobarErroresForm($_POST['json']);
    $data['input']['json'] = filter_var($_POST['json'], FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($data['errores'])) {
        $datos = json_decode($_POST['json'], true);
        $alumnosSusp = [];
        $resultado = [];

        foreach ($datos as $materia => $alumnos) {
            $sumaNotas = 0;
            $numAlumnos = count($alumnos);
            $suspensos = $aprobados = 0;
            $maxNota = -1;
            $minNota = 11;
            $maxAlumno = '';
            $minAlumno = '';

            foreach ($alumnos as $alumno => $notas) {
                if (!isset($alumnosSusp[$alumno])) {
                    $alumnosSusp[$alumno] = 0; // Establezco los alumnos suspensos a 0 si aun no existen
                }

                // Calculo la media del alumno para esa materia
                $media = array_sum($notas) / count($notas);
                $sumaNotas += $media;

                // Cuento suspensos y aprobados
                if ($media < 5) {
                    $suspensos++;
                    $alumnosSusp[$alumno]++;
                } else {
                    $aprobados++;
                }

                // Nota mínima y máxima
                foreach ($notas as $nota) {
                    if ($nota > $maxNota) {
                        $maxNota = $nota;
                        $maxAlumno = $alumno;
                    }
                    if ($nota < $minNota) {
                        $minNota = $nota;
                        $minAlumno = $alumno;
                    }
                }
            }


            $resultado[$materia] = [
                'notaMedia' => $sumaNotas / $numAlumnos, // Suma de todas las notas entre el numero de alumnos
                'suspensos' => $suspensos,
                'aprobados' => $aprobados,
                'notaMax' => ['alumno' => $maxAlumno, 'nota' => $maxNota],
                'notaMin' => ['alumno' => $minAlumno, 'nota' => $minNota],
            ];
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
            $promocionan[] = $alumno;
        } elseif ($suspensos < 2) {
            // Suspende solo una materia
            $promocionan[] = $alumno;
            $suspenden[] = $alumno;
        } elseif ($suspensos >= 2) {
            // Suspende dos o más materias
            $noPromocionan[] = $alumno;
            $suspenden[] = $alumno;
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
        $errores['json'][] = 'El campo es obligatorio'; // Comprueba que el textarea está relleno con datos y lanza un mensaje si no lo está
    } else {
        $datos = json_decode($json, true);

        if (is_null($datos)) {
            $errores['json'][] = 'Debes introducir un JSON válido';
        } elseif (!is_array($datos)) {
            $errores['json'][] = 'El JSON debe ser un array de asignaturas';
        } else {
            // Validación de la estructura de cada asignatura
            foreach ($datos as $materia => $alumnos) {
                if (!is_string($materia) || trim($materia) === '') {
                    $errores['json'][] = "Debes introducir un nombre de asignatura válido, ERROR: '$materia'";
                }

                if (!is_array($alumnos) || empty($alumnos)) {
                    $errores['json'][] = "Cada asignatura debe contener un array de alumnos, ERROR en: '$materia'";
                } else {
                    // Valida de cada alumno y sus notas
                    foreach ($alumnos as $alumno => $notas) {
                        if (!is_string($alumno) || trim($alumno) === '') {
                            $errores['json'][] = "Debes introducir un nombre de alumno válido, ERROR en '$materia'";
                        }

                        if (!is_array($notas) || empty($notas)) {
                            $errores['json'][] = "Las notas de '$alumno' en '$materia' deben ser un array no vacío";
                        } else {
                            foreach ($notas as $nota) {
                                if (!is_numeric($nota)) {
                                    $errores['json'][] = "Cada nota debe ser un número, ERROR: '$nota' de '$alumno' en '$materia'";
                                } elseif ($nota < 0 || $nota > 10) {
                                    $errores['json'][] = "Cada nota debe estar entre 0 y 10, ERROR: '$nota' de '$alumno' en '$materia'";
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