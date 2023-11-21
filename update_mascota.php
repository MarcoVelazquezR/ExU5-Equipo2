<?php
require_once('ORM/Database.php');
require_once('ORM/orm.php');
require_once('mascotas.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $encontrado = $db->verificarDriver();

    if ($encontrado) {
        $cnn = $db->getConnection();
        $mascotaModelo = new Mascota ($cnn);

        $id = $_POST['id'] ?? '';
        $nombre = $_POST['nombre'] ?? '';
        $edad = $_POST['edad'] ?? '';
        $peso = $_POST['peso'] ?? '';

        if (!empty($id) && !empty($nombre) && !empty($edad) && !empty($peso)) {

            $datosActualizacion = [
                'nombre' => $nombre,
                'edad' => $edad,
                'peso' => $peso,
            ];

            if ($mascotaModelo->updateById($id, $datosActualizacion)) {
                echo 'Datos actualizados correctamente.';
                echo '<script>
                        setTimeout(function(){
                            window.location.href = "mascotas.php";
                        });
                      </script>';
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

        $id = $_GET['id'] ?? '';

        if (!empty($id)) {
            $mascota = $mascotaModelo->getById($id);

            if ($mascota) {
                $id = $mascota['id'];
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
            <form action="" method="post" id="formActualizacion">
                
            <input type="hidden" name="id" value="<?php echo $id ?? ''; ?>">

                <div class="mb-3" >
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" class="form-control" name="nombre" value="<?php echo $nombre ?? ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="edad" class="form-label">Edad:</label>
                    <input type="text" class="form-control" name="edad" value="<?php echo $edad ?? ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="peso" class="form-label">Peso:</label>
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
                var id = $('input[name="id"]').val();
                var nombre = $('input[name="nombre"]').val();
                var edad = $('input[name="edad"]').val();
                var peso = $('input[name="peso"]').val();

                if (id === '' || nombre === '' || edad === '' || peso === '') {
                    alert('Por favor, completa todos los campos del formulario 2.');
                    return;
                }

                $('#formActualizacion').submit();
            });
        });
    </script>

</body>
</html>
