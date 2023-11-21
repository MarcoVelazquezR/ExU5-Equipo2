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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
    require_once('ORM/mascotas.php');
    require_once('ORM/clientes.php');

    $db = new Database();
    $encontrado = $db->verificarDriver();

    ?>

    <div class="text-left">
        <label for="clientes">Selecciona un cliente:</label>
        <select id="clientes" class="form-control" onchange="updateClientInfo()">
            <?php
            // Obtener la lista de clientes desde la base de datos
            $clienteModelo = new Cliente($db->getConnection());
            $clientes = $clienteModelo->getAll();

            foreach ($clientes as $cliente) {
                echo "<option value='{$cliente['id']}'>{$cliente['nombres']} {$cliente['apellidos']}</option>";
            }
            ?>
        </select>

        <div class="mb-3">
            <label for="nombreCliente">Nombres del Cliente:</label>
            <input type="text" class="form-control" id="nombreCliente" readonly value="">
        </div>

        <div class="mb-3">
            <label for="telefonoCliente">Teléfono:</label>
            <input type="text" class="form-control" id="telefonoCliente" readonly value="">
        </div>
        <div class="text-left">
            <form action="insert_mascota.php" method="get">
                <input type="hidden" name="clienteId" value="<?= $cliente['id'] ?>">
                <button type="submit" class="btn btn-success" data-title="Insertar" data-toggle="tooltip" title="Insert">
                    <span class="glyphicon glyphicon-plus"></span> Añadir Mascota
                </button>
            </form>
        </div>
    </div>

    <script>
        function updateMascotasTable(clienteId) {
            let selectedClienteId = document.getElementById('clientes').value;
            let clientesData = <?php echo json_encode($clientes); ?>;

            for (let cliente of clientesData) {
                if (cliente.id === parseInt(selectedClienteId)) {
                    document.getElementById('nombreCliente').value = `${cliente.nombres} ${cliente.apellidos}`;
                    document.getElementById('telefonoCliente').value = cliente.telefono;
                    break;
                }
            }
            <?php
            if ($encontrado) {
                $cnn = $db->getConnection();
                $mascotaModelo = new Mascota($cnn);
                $selectedClienteId = isset($_GET['clienteId']) ? $_GET['clienteId'] : null;

                // Verifica si se ha seleccionado un cliente
                if ($selectedClienteId !== null) {
                    $cnn = $db->getConnection();
                    $mascotaModelo = new Mascota($cnn);

                    // Obtén solo las mascotas asociadas al cliente seleccionado
                    $mascotas = $mascotaModelo->getByClienteId($selectedClienteId);
                } else {
                    // Si no se ha seleccionado un cliente, muestra todas las mascotas
                    $mascotaModelo = new Mascota($cnn);
                    $mascotas = $mascotaModelo->getAll();
                }
            }

            ?>
            $.ajax({
                type: 'GET',
                url: 'get_mascotas.php', // Replace with the actual path to your PHP script
                data: {
                    clienteId: selectedClienteId
                },
                success: function(data) {
                    // Update the table body with the received data
                    $('#mascotasTableBody').html(data);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching mascotas:', error);
                }
            });
        }

        function updateClientInfo() {
            let selectedClienteId = document.getElementById('clientes').value;
            let clientesData = <?php echo json_encode($clientes); ?>;

            for (let cliente of clientesData) {
                if (cliente.id === parseInt(selectedClienteId)) {
                    document.getElementById('nombreCliente').value = `${cliente.nombres} ${cliente.apellidos}`;
                    document.getElementById('telefonoCliente').value = cliente.telefono;
                    break;
                }
            }
            <?php
            if ($encontrado) {
                $cnn = $db->getConnection();
                $mascotaModelo = new Mascota($cnn);
                $selectedClienteId = isset($_GET['clienteId']) ? $_GET['clienteId'] : null;

                // Verifica si se ha seleccionado un cliente
                if ($selectedClienteId !== null) {
                    $cnn = $db->getConnection();
                    $mascotaModelo = new Mascota($cnn);

                    // Obtén solo las mascotas asociadas al cliente seleccionado
                    $mascotas = $mascotaModelo->getByClienteId($selectedClienteId);
                } else {
                    // Si no se ha seleccionado un cliente, muestra todas las mascotas
                    $mascotaModelo = new Mascota($cnn);
                    $mascotas = $mascotaModelo->getAll();
                }
            }

            ?>
            $.ajax({
                type: 'GET',
                url: 'get_mascotas.php', // Replace with the actual path to your PHP script
                data: {
                    clienteId: selectedClienteId
                },
                success: function(data) {
                    // Update the table body with the received data
                    $('#mascotasTableBody').html(data);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching mascotas:', error);
                }
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#btnInsertar').click(function() {
                var nombre = $('input[name="nombre"]').val();
                var edad = $('input[name="edad"]').val();
                var peso = $('input[name="peso"]').val();
                var id_cliente = $('input[name="id_cliente"]').val();

                if (nombre === '' || edad === '' || peso === '') {
                    alert('Por favor, completa todos los campos del formulario.');
                    return;
                }

                // Crear un objeto FormData con los datos del formulario
                var formData = new FormData();
                formData.append('nombre', nombre);
                formData.append('edad', edad);
                formData.append('peso', peso);
                formData.append('id_cliente', id_cliente);

                // Enviar la petición AJAX
                $.ajax({
                    type: 'POST',
                    url: 'inserta_mascota.php', // Cambia a la ruta correcta de tu script PHP
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Manejar la respuesta si es necesario
                        console.log(response);
                        // Actualizar la tabla de mascotas
                        updateMascotasTable(id_cliente);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al insertar mascota:', error);
                    }
                });
            });
        });
    </script>

    <?php
    if ($encontrado) {
        $cnn = $db->getConnection();
        $mascotaModelo = new Mascota($cnn);
        $selectedClienteId = isset($_GET['clienteId']) ? $_GET['clienteId'] : null;

        // Verifica si se ha seleccionado un cliente
        if ($selectedClienteId !== null) {
            $cnn = $db->getConnection();
            $mascotaModelo = new Mascota($cnn);

            // Obtén solo las mascotas asociadas al cliente seleccionado
            $mascotas = $mascotaModelo->getByClienteId($selectedClienteId);
        }
    }

    ?>

    <div class="table-responsive">
        <table class="table table-bordered table-striped" id="mascotasTableBody">
            <thead>
                <tr>
                    <th class="col-sm-1">ID</th>
                    <th class="col-sm-2">Nombre</th>
                    <th class="col-sm-4">Edad</th>
                    <th class="col-sm-2">Peso</th>
                    <th class="col-sm-1">Editar</th>
                    <th class="col-sm-1">Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mascotas as $mascota) : ?>
                    <tr>
                        <td><?= $mascota['id']; ?></td>
                        <td><?= $mascota['nombre'] ?></td>
                        <td><?= $mascota['edad']; ?></td>
                        <td><?= $mascota['peso']; ?></td>
                        <td class="Editar">
                            <a href="update_mascota.php?id=<?= $mascota['id'] ?>" class="btn btn-warning btn-xs" data-title="Edit" data-toggle="modal">
                                <span class="glyphicon glyphicon-edit"></span>
                            </a>
                        </td>
                        <td class="Eliminar">
                            <p data-placement="top" data-toggle="tooltip" title="Delete">
                                <a href="delete_mascota.php?id=<?= $mascota['id']; ?>" class="btn btn-danger btn-xs">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </a>
                            </p>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="resultadoInsertarMascota"></div>

</body>

</html>