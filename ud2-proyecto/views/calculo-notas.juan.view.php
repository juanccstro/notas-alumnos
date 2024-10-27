<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Calculo de Notas - Juan C. Castro</h1>

</div>

<!-- Content Row -->

<div class="row">
    <?php
    if (isset($data['resultado'])) {
        ?>
        <div class="col-12">
            <div class="card shadow mb-4">

                <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Datos de las asignaturas</h6>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>
                                Módulo
                            </th>
                            <th>
                                Nota media
                            </th>
                            <th>
                                Aprobados
                            </th>
                            <th>
                                Suspensos
                            </th>
                            <th>
                                Máximo
                            </th>
                            <th>
                                Mínimo
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($data['resultado'] as $materia => $datosMateria) { ?>
                            <tr>
                                <td><?php echo $materia ?></td>
                                <td><?php echo is_numeric($datosMateria['notaMedia']) ? number_format($datosMateria['notaMedia'], 2, ',') : ''; ?></td>
                                <td><?php echo $datosMateria['aprobados'] ?></td>
                                <td><?php echo $datosMateria['suspensos'] ?></td>
                                <td><?php echo $datosMateria['notaMax']['alumno'] ?>
                                    : <?php echo $datosMateria['notaMax']['nota'] ?>
                                </td>
                                <td><?php echo $datosMateria['notaMin']['alumno'] ?>
                                    : <?php echo $datosMateria['notaMin']['nota'] ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>


                <!-- Tarjetas de colores dependientes de los alumnos que aprueban, no aprueban y el numero de suspensos -->
                <div class="row">
                    <div class="col-6">
                        <div class="alert-success">
                            <h6>Alumnos que aprueban todo:</h6>
                            <?php
                            foreach ($data['listados']['aprueban'] as $alumno) {
                                echo '<p>' . ($alumno) . '</p>';
                            }
                            ?>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="alert-warning">
                            <h6>Alumnos con suspensos:</h6>
                            <?php
                            foreach ($data['listados']['suspenden'] as $alumno) {
                                echo '<p>' . ($alumno) . '</p>';
                            }
                            ?>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="alert-info">
                            <h6>Alumnos que promocionan:</h6>
                            <?php
                            foreach ($data['listados']['promocionan'] as $alumno) {
                                echo '<p>' . ($alumno) . '</p>';
                            }
                            ?>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="alert-danger">
                            <h6>Alumnos que no promocionan:</h6>
                            <?php
                            foreach ($data['listados']['noPromocionan'] as $alumno) {
                                echo '<p>' . ($alumno) . '</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>
<div class="card-body">
    <form method="post">
        <label for="texto">Datos:</label>
        <textarea class="form-control" name="json" id="json"
                  placeholder="Introduce aquí el JSON"><?php echo isset($data['input']['json']) ? $data['input']['json'] : '' ?></textarea>
        <p class="alert-danger-small">
            <?php echo isset($data['errores']['json']) ? implode('<br>', $data['errores']['json']) : ''; ?>
        </p>
        <div>
            <input type="submit" value="Analizar Datos" name="enviar"/>
        </div>
    </form>
</div>

