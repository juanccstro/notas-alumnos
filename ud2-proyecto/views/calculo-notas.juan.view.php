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
                <table>
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
                    <?php foreach ($data['resultado'] as $materia => $datos) { ?>
                    <tr>
                        <td><?php echo $materia ?></td>
                        <td><?php echo number_format($datos['notaMedia'], 2, ',') ?></td>
                        <td><?php echo $datos['aprobados'] ?></td>
                        <td><?php echo $datos['suspensos'] ?></td>
                        <td><?php echo $datos['max']['alumno'] ?>: <?php echo $datos['max']['nota'] ?></td>
                        <td><?php echo $datos['min']['alumno'] ?>: <?php echo $datos['min']['nota'] ?></td>
                    </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <?php
            }
            ?>

            <!-- Tarjetas de colores dependientes de los alumnos que aprueban, no aprueban y el numero de suspensos -->
            <div class="col-4">
            <div>

            </div>
            </div>
            <div class="col-4">
                <div class="alert-success">
                    <?php
                    foreach($data['listados']['aprueban'] as $alumno){
                        ?>
                        <p><?php echo $alumno; ?></p>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="col-4">
                <div class="alert-light">
                    <?php
                    foreach($data['listados']['suspenden'] as $alumno){
                        ?>
                        <p><?php echo $alumno; ?></p>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="col-4">
                <div class="alert-info">
                    <?php
                    foreach($data['listados']['promocionan'] as $alumno){
                        ?>
                        <p><?php echo $alumno; ?></p>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="col-4">
                <div class="alert-danger">
                    <?php
                    foreach($data['listados']['noPromocionan'] as $alumno){
                        ?>
                        <p><?php echo $alumno; ?></p>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="card-body">
                <form method="post">
                    <label for="texto">Datos:</label>
                    <textarea class="form-control" name="json" id="json"
                              placeholder="Introduce aquí el JSON"></textarea>
                    <p class="alert-danger-small"></p>
                    <div>
                        <input type="submit" value="Analizar Datos" name="enviar"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
