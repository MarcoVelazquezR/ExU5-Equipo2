<?php
require_once('ORM/Database.php');
require_once('ORM/orm.php');
require_once('mascotas.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $encontrado = $db->verificarDriver();

    if ($encontrado) {
        $cnn = $db->getConnection();
        $mascotaModelo = new Mascota($cnn);
        $id_mascota = $_POST['id_mascota'] ?? '';
        $id_cliente = $_GET['id'] ?? '';

        // Output the values for debugging
        var_dump($id_cliente);
        var_dump($id_mascota);

        $nombre = $_POST['nombre'] ?? '';
        $edad = $_POST['edad'] ?? '';
        $peso = $_POST['peso'] ?? '';

        if (!empty($id_mascota) && !empty($nombre) && !empty($edad) && !empty($peso) && !empty($id_cliente)) {

            $datosActualizacion = [
                'nombre' => $nombre,
                'edad' => $edad,
                'peso' => $peso,
            ];

            if ($mascotaModelo->updateById($id_mascota, $datosActualizacion)) {
                header('Location: mascotas.php?id=' . $id_cliente);
                exit();
            } else {
                echo 'Error al actualizar datos.';
            }
        } else {
            echo 'Por favor, completa todos los campos del formulario 1.';
        }
    }
} else {
    $db = new Database();
    $encontrado = $db->verificarDriver();

    if ($encontrado) {
        $cnn = $db->getConnection();
        $mascotaModelo = new Mascota($cnn);

        $id = $_GET['id_mascota'] ?? '';  // Cambiado de 'id' a 'id_mascota'

        if (!empty($id)) {
            $mascota = $mascotaModelo->getById($id);

            if ($mascota) {
                $id_mascota = $mascota['id'];  // Cambiado de 'id' a 'id_mascota'
                $nombre = $mascota['nombre'];
                $edad = $mascota['edad'];
                $peso = $mascota['peso'];
            } else {
                echo 'Mascota no encontrado.';
                exit();
            }
        } else {
            echo 'ID de mascota no proporcionado.';
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
    <title>Formulario de Actualización</title>
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
            <h2>Formulario</h2>
            <?php
            echo '<h1>CLIENTE ID8:' . $id_cliente . '</h1>';
            ?>
            <form action="" method="post" id="formActualizacion">

                <input type="hidden" name="id_mascota" value="<?php echo $id_mascota ?? ''; ?>"> <!-- Cambiado de 'id' a 'id_mascota' -->

                <div class="mb-3">
                    <label class="form-label">Nombre:</label>
                    <input type="text" class="form-control" name="nombre" value="<?php echo $nombre ?? ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Edad:</label>
                    <input type="text" class="form-control" name="edad" value="<?php echo $edad ?? ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Peso:</label>
                    <input type="text" class="form-control" name="peso" value="<?php echo $peso ?? ''; ?>" required>
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
            var id_mascota = $('input[name="id_mascota"]').val(); // Cambiado de 'id' a 'id_mascota'
            var nombre = $('input[name="nombre"]').val();
            var edad = $('input[name="edad"]').val();
            var peso = $('input[name="peso"]').val();

            if (id_mascota === '' || nombre === '' || edad === '' || peso === '') {
                alert('Por favor, completa todos los campos del formulario 2.');
                return;
            }

            $('#formActualizacion').submit();
        });
    });
</script>

</body>

</html>