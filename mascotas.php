<?php
include 'includes/header.php';
require_once('ORM/Database.php');
require_once('ORM/orm.php');
require_once('ORM/mascotas.php');
require_once('ORM/clientes.php');
$clienteID = isset($_GET['id']) ? $_GET['id'] : null;
$db = new Database();
$encontrado = $db->verificarDriver();

?>


<div class="text-left">

    <div class="mb-3">
        <label for="nombreCliente">Nombres del Cliente:</label>
        <input type="text" class="form-control" id="nombreCliente" readonly value="">
    </div>

    <div class="mb-3">
        <label for="telefonoCliente">Teléfono:</label>
        <input type="text" class="form-control" id="telefonoCliente" readonly value="">
    </div>
    <div class="text-left">
        <a href="insert_mascota.php?id=<?= $clienteID ?>" class="btn btn-success" data-title="Insertar" data-toggle="tooltip" title="Insert">
            <span class="glyphicon glyphicon-plus"></span> Añadir Mascota
        </a>
    </div>
</div>
<?php
if ($encontrado) {
    $cnn = $db->getConnection();
    $clienteModelo = new Cliente($cnn);
    $cliente = $clienteModelo->getById($clienteID);
    echo '
                <script>
                    document.getElementById(\'nombreCliente\').value = \'' . $cliente['nombres'] . ' ' . $cliente['apellidos'] . '\';
                    document.getElementById(\'telefonoCliente\').value = \'' . $cliente['telefono'] . '\';
                </script>
            ';
}
?>
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

            var formData = new FormData();
            formData.append('nombre', nombre);
            formData.append('edad', edad);
            formData.append('peso', peso);
            formData.append('id_cliente', id_cliente);

            $.ajax({
                type: 'POST',
                url: 'inserta_mascota.php',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
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

    if ($clienteID !== null) {
        $mascotas = $mascotaModelo->getByClienteId($clienteID);
    }
    $clienteModelo = new Cliente($cnn);
    $cliente = $clienteModelo->getById($clienteID);
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
                        <a href="update_mascota.php?id=<?= $cliente['id'] ?>&id_mascota=<?= $mascota['id'] ?>" class="btn btn-warning btn-xs" data-title="Edit" data-toggle="modal">
                            <span class="glyphicon glyphicon-edit"></span>
                        </a>
                    </td>
                    <td class="Eliminar">
                        <p data-placement="top" data-toggle="tooltip" title="Delete">
                            <a href="delete_mascota.php?id=<?= $mascota['id']; ?>&id_cliente=<?= $clienteID ?>" class="btn btn-danger btn-xs">
                                <span class="glyphicon glyphicon-trash"></span>
                            </a>
                        </p>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>

</html>