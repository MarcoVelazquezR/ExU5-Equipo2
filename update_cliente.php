<?php
require_once('ORM/Database.php');
require_once('ORM/orm.php');
require_once('ORM/clientes.php');
require_once('clientes.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $encontrado = $db->verificarDriver();

    if ($encontrado) {
        $cnn = $db->getConnection();
        $clienteModelo = new Cliente($cnn);

        $id = $_POST['id'] ?? '';
        $telefono = $_POST['telefonoU'] ?? '';

        if (!empty($id) && !empty($telefono)) {

            $datosActualizacion = [
                'telefono' => $telefono,
            ];

            if ($clienteModelo->updateById($id, $datosActualizacion)) {
                echo 'Datos actualizados correctamente.';
                echo '<script>
                        setTimeout(function(){
                            window.location.href = "clientes.php";
                        });
                      </script>';
                exit();
            } else {
                echo 'Error al actualizar datos.';
            }
        } else {
            echo 'Por favor, completa todos los campos del formulario.';
        }
    }
} else {
    $db = new Database();
    $encontrado = $db->verificarDriver();

    if ($encontrado) {
        $cnn = $db->getConnection();
        $clienteModelo = new Cliente($cnn);

        $id = $_GET['id'] ?? '';

        if (!empty($id)) {
            $cliente = $clienteModelo->getById($id);

            if ($cliente) {
                $id = $cliente['id'];
                $telefono = $cliente['telefono'];
            } else {
                echo 'No existe cliente con dicho ID';
                exit();
            }
        } else {
            echo 'El ID del cliente no fue proporcionado';
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualización de clientes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 50px;
        }

        #contenedorTablaFormulario {
            min-height: 500px;
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body>

    <div class="container mt-3" id="contenedorTablaFormulario">
        <?php if (!isset($_POST) || empty($_POST)) { ?>
            <form action="" method="post" id="formActualizacion">
                
            <input type="hidden" name="id" value="<?php echo $id ?? ''; ?>">
                <div class="mb-3">
                    <label for="especialidad" class="form-label">Telefono:</label>
                    <input type="text" class="form-control" name="telefonoU" id="telefonoU" value="<?php echo $telefono ?? ''; ?>" required>
                </div>
                <button type="button" class="btn btn-primary" id="btnActualizar">Actualizar</button>
            </form>
        </div>
        <?php } ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#btnActualizar').click(function() {
                var telefono = $('input[id="telefonoU"]').val();
                if (telefono.length != 10 || isNaN(telefono)) {
                    $('#telefonoU').css('border-color','#FF0000');
                    alert('Por favor ingrese un numero de telefono valido.');
                    return;
                }
                $('#formActualizacion').submit();
                alert('El numero de telefono se ha actualizado correctamente');
            });
        });
    </script>

</body>
</html>
