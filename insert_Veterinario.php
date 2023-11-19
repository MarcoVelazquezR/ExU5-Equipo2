<?php
require_once('ORM/Database.php');
require_once('ORM/orm.php');
require_once('veterinarios.php');

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $encontrado = $db->verificarDriver();

    if ($encontrado) {
        $cnn = $db->getConnection();
        $veterinarioModelo = new Veterinario($cnn);

        // Validar y obtener datos del formulario
        $nombres = $_POST['nombres'] ?? '';
        $apellidos = $_POST['apellidos'] ?? '';
        $especialidad = $_POST['especialidad'] ?? '';

        // Validar los datos antes de la inserción (puedes agregar más validaciones según tus necesidades)
        if (!empty($nombres) && !empty($apellidos) && !empty($especialidad)) {

            $datosInsercion = [
                'nombre' => $nombres,
                'apellidos' => $apellidos,
                'especialidad' => $especialidad,
            ];

            if ($veterinarioModelo->insert($datosInsercion)) {
                echo 'Datos insertados correctamente.';
                echo '<script>
                        setTimeout(function(){
                            window.location.href = "veterinarios.php";
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
            min-height: 500px; /* Establece una altura mínima para el contenedor */
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
                    <label for="nombres" class="form-label">Nombres:</label>
                    <input type="text" class="form-control" name="nombres" required>
                </div>

                <div class="mb-3">
                    <label for="apellidos" class="form-label">Apellidos:</label>
                    <input type="text" class="form-control" name="apellidos" required>
                </div>

                <div class="mb-3">
                    <label for="especialidad" class="form-label">Especialidad:</label>
                    <select class="form-select form-select-lg" name="especialidad" required>
                        <option value="">Selecciona una especialidad</option>
                        <option value="Cirugía">Cirugía</option>
                        <option value="Oncología">Oncología</option>
                        <option value="Fisioterapia">Fisioterapia</option>
                        <option value="Rehabilitación">Rehabilitación</option>
                        <option value="Imagenología">Imagenología</option>
                    </select>
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
                var nombres = $('input[name="nombres"]').val();
                var apellidos = $('input[name="apellidos"]').val();
                var especialidad = $('select[name="especialidad"]').val();

                if (nombres === '' || apellidos === '' || especialidad === '') {
                    alert('Por favor, completa todos los campos del formulario.');
                    return;
                }

                $('#formInsercion').submit();
            });
        });
    </script>

</body>
</html>
