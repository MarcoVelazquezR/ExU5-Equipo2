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
        $id_cliente = $_GET['id'] ?? '';
        $nombre = $_POST['nombre'] ?? '';
        $edad = $_POST['edad'] ?? '';
        $peso = $_POST['peso'] ?? '';

        if (!empty($nombre) && !empty($edad) && !empty($peso) && !empty($id_cliente)) {

            $datosInsercion = [
                'nombre' => $nombre,
                'edad' => $edad,
                'peso' => $peso,
                'id_cliente' => $id_cliente,
            ];

            if ($mascotaModelo->insert($datosInsercion)) {
                echo 'Datos insertados correctamente.';
                echo '<script>
                        setTimeout(function(){
                            window.location.href = "mascotas.php?id=' . $id_cliente . '";
                        });
                      </script>';
                exit();
            } else {
                echo 'Error al insertar datos.';
            }
        } else {
            echo 'Por favor, completa todos los campos del formulario.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Inserción</title>
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
            <form action="" method="post" id="formInsercion">
                <div class="container mt-3">

                    <form action="" method="post" id="formInsercion">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" name="nombre" required>
                        </div>

                        <div class="mb-3">
                            <label for="edad" class="form-label">Edad:</label>
                            <input type="text" class="form-control" name="edad" required>
                        </div>

                        <div class="mb-3">
                            <label for="peso" class="form-label">Peso:</label>
                            <input type="text" class="form-control" name="peso" required>
                        </div>
                        <div class="mb-3">
                            <input type="hidden" name="id_cliente" value="<?= $id_cliente ?>">
                        </div>
                        <button type="button" class="btn btn-primary" id="btnInsertar">Insertar</button>
                    </form>
                </div>
            <?php } ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#btnInsertar').click(function() {
                var nombre = $('input[name="nombre"]').val();
                var edad = $('input[name="edad"]').val();
                var peso = $('select[name="peso"]').val();            

                    if (nombre === '' || edad === '' || peso === '') {
                        alert('Por favor, completa todos los campos del formulario.');
                        return;
                    }

                $('#formInsercion').submit();
            });
        });
    </script>

</body>

</html>