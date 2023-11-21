<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veterinarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/Proyecto final/CSS/styles.css">
    <style>
        
        .table-striped thead tr th {
            background-color: #444; 
            color: 
            #fff; 
        }
    </style>
</head>
<body>
    <header width="100%">
            <nav class="navbar navbar-expand-md navbar-dark bg-dark">
                <a href="#" class="navbar-brand">
                    <img width="40px" height="40px" src="/Proyecto final/img/ico.ico" alt="mi img">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="menu">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a href="#" id="login-link" class="nav-link text-white">Bienvenida Admin, Carolina García Echegaray</a>
                        </li>
                    </ul>
                </div>
            </nav>
    </header>


    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <div class="container-fluid">
            <h1 class="h1 text-center text-white">VETERINARIOS</h1>
        </div>
    </nav>
    
    <?php
    require_once('ORM/Database.php');
    require_once('ORM/orm.php');
    require_once('ORM/veterinarios.php');
    
    $db= new Database();
    $encontrado=$db->verificarDriver();
    
    ?>
    <div class="text-left">
        <a href="insert_veterinario.php" class="btn btn-success" data-title="Insertar" data-toggle="tooltip" title="Insert">
                <span class="glyphicon glyphicon-plus"></span> Añadir Veterinario
        </a>
    </div>
    
    <?php
    if($encontrado){
        $cnn = $db->getConnection();
        $veterinarioModelo = new Veterinario($cnn);
        $veterinarios = $veterinarioModelo->getAll();
    }

    ?>
    
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="col-sm-1">ID</th>
                    <th class="col-sm-2">Nombres</th>
                    <th class="col-sm-4">Apellidos</th>
                    <th class="col-sm-2">Especialidad</th>
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
                        <td class="Editar">
                            <a href="update_veterinario.php?id=<?= $veterinario['id'] ?>" class="btn btn-warning btn-xs" data-title="Edit" data-toggle="modal">
                                <span class="glyphicon glyphicon-edit"></span>
                            </a>
                        </td>

                        <td class="Eliminar">
                            <p data-placement="top" data-toggle="tooltip" title="Delete">
                                <a href="javascript:void(0);" onclick="confirmarEliminar(<?= $veterinario['id']; ?>)" class="btn btn-danger btn-xs">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </a>
                            </p>
                        </td>


                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script>
        function confirmarEliminar(id) {
            if (confirm('¿Estás seguro que deseas eliminar este veterinario?')) {
                window.location.href = 'delete_veterinario.php?id=' + id;
            }
        }
    </script>
</body>
</html>
