<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
    <style>
        .table-striped thead tr th {
            background-color: #444; 
            color: #fff; 
        }
    </style>
</head>
<body>
    <?php
    require_once('ORM/Database.php');
    require_once('ORM/orm.php');
    require_once('ORM/veterinarios.php');

    $db = new Database();
    $encontrado = $db->verificarDriver();

    $cnn = $db->getConnection();
    $veterinarioModelo = new Veterinario($cnn);
    $veterinarios = $veterinarioModelo->getAll();
    ?>

    <div class="text-left">
        <button class="btn btn-success" data-toggle="modal" data-target="#addVeterinarioModal">
            + Añadir Veterinario
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="col-sm-1">ID</th>
                    <th class="col-sm-2">Nombres</th>
                    <th class="col-sm-4">Apellidos</th>
                    <th class="col-sm-1">Especialidad</th>
                    <th class="col-sm-1">Detalles</th>
                    <th class="col-sm-1">Editar</th>
                    <th class="col-sm-1">Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($veterinarios as $veterinario): ?>
                    <tr>
                        <td><?= $veterinario['id']; ?></td>
                        <td><?= $veterinario['nombre'] ?></td>
                        <td><?= $veterinario['apellidos']; ?></td>
                        <td><?= $veterinario['especialidad']; ?></td>
                        <td class="Ver">
                            <p data-placement="top" data-toggle="tooltip" title="Ver">
                                <button class="btn btn-info btn-xs" data-title="Ver" data-toggle="modal" data-target="#ver" >
                                    <span class="glyphicon glyphicon-eye-open"></span>
                                </button>
                            </p>
                        </td>
                        <td class="Editar">
                            <p data-placement="top" data-toggle="tooltip" title="Edit">
                                <button class="btn btn-warning btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit" >
                                    <span class="glyphicon glyphicon-edit"></span>
                                </button>
                            </p>
                        </td>
                        <td class="Eliminar">
                            <p data-placement="top" data-toggle="tooltip" title="Delete">
                                <button class="btn btn-danger btn-xs eliminar" data-title="Delete" data-toggle="modal" data-id="<?= $veterinario['id'] ?>">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </button>
                            </p>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    
</body>
</html>
