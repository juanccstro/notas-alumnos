<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $data['titulo']; ?></h1>

</div>

<!-- Content Row -->

<div class="row">
    <div class="col-12">

    </div>

    <div class="col-12">
        <div class="card shadow mb-4">
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
                            Aprovados
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
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Datos de las asignaturas</h6>
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

