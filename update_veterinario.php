<?php
require_once('ORM/Database.php');
require_once('ORM/orm.php');
require_once('veterinarios.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $encontrado = $db->verificarDriver();

    if ($encontrado) {
        $cnn = $db->getConnection();
        $veterinarioModelo = new Veterinario($cnn);

        $id = $_POST['id'] ?? '';
        $nombres = $_POST['nombres'] ?? '';
        $apellidos = $_POST['apellidos'] ?? '';
        $especialidad = $_POST['especialidad'] ?? '';

        if (!empty($id) && !empty($nombres) && !empty($apellidos) && !empty($especialidad)) {

            $datosActualizacion = [
                'nombre' => $nombres,
                'apellidos' => $apellidos,
                'especialidad' => $especialidad,
            ];

            if ($veterinarioModelo->updateById($id, $datosActualizacion)) {
                echo 'Datos actualizados correctamente.';
                echo '<script>
                        setTimeout(function(){
                            window.location.href = "veterinarios.php";
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
        $veterinarioModelo = new Veterinario($cnn);

        $id = $_GET['id'] ?? '';

        if (!empty($id)) {
            $veterinario = $veterinarioModelo->getById($id);

            if ($veterinario) {
                $id = $veterinario['id'];
                $nombres = $veterinario['nombre'];
                $apellidos = $veterinario['apellidos'];
                $especialidad = $veterinario['especialidad'];
            } else {
                echo 'Veterinario no encontrado.';
                exit();
            }
        } else {
            echo 'ID de veterinario no proporcionado.';
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
                    <label for="nombres" class="form-label">Nombres:</label>
                    <input type="text" class="form-control" name="nombres" value="<?php echo $nombres ?? ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="apellidos" class="form-label">Apellidos:</label>
                    <input type="text" class="form-control" name="apellidos" value="<?php echo $apellidos ?? ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="especialidad" class="form-label">Especialidad:</label>
                    <select class="form-select form-select-lg" name="especialidad" required>
                        <option value="Cirugía" <?php echo ($especialidad == 'Cirugía') ? 'selected' : ''; ?>>Cirugía</option>
                        <option value="Oncología" <?php echo ($especialidad == 'Oncología') ? 'selected' : ''; ?>>Oncología</option>
                        <option value="Fisioterapia" <?php echo ($especialidad == 'Fisioterapia') ? 'selected' : ''; ?>>Fisioterapia</option>
                        <option value="Rehabilitación" <?php echo ($especialidad == 'Rehabilitación') ? 'selected' : ''; ?>>Rehabilitación</option>
                        <option value="Imagenología" <?php echo ($especialidad == 'Imagenología') ? 'selected' : ''; ?>>Imagenología</option>
                    </select>
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
                var nombres = $('input[name="nombres"]').val();
                var apellidos = $('input[name="apellidos"]').val();
                var especialidad = $('select[name="especialidad"]').val();

                if (id === '' || nombres === '' || apellidos === '' || especialidad === '') {
                    alert('Por favor, completa todos los campos del formulario.');
                    return;
                }

                $('#formActualizacion').submit();
            });
        });
    </script>

</body>
</html>
