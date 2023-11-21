<?php

$cliente_id = isset($_GET['cliente_id']) ? $_GET['cliente_id'] : null;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conexión PDO
    $dsn = 'mysql:host=localhost;dbname=veterinaria';
    $user = 'root';
    $pass = '';

    try {
        $conn = new PDO($dsn, $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }

    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];
    $peso = $_POST['peso'];

    if (!empty($nombre) && !empty($edad) && !empty($peso) && !empty($cliente_id)) {

        // Insertar mascota con PDO
        $sql = "INSERT INTO mascotas(nombre, edad, peso, cliente_id) 
        VALUES(:nombre, :edad, :peso, :cliente_id)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':edad', $edad);
        $stmt->bindParam(':peso', $peso);
        $stmt->bindParam(':cliente_id', $cliente_id);

        $stmt->execute();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Mascota</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <script src="https://kit.fontawesome.com/5797ea773f.js" crossorigin="anonymous"></script>

    <style>
        body {
            background-color: lightblue;
            background-size: auto;
            background-repeat: repeat-x;
            background-image: url("img/perritofeliz.jpeg");
        }

        .h1 {
            font-size: 3em;
            color: black;
            background-color: whitesmoke;
            padding: 10px 20px;
            border-radius: 10px;
            text-transform: uppercase;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease-in-out;
        }

        .form-container {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <h1 class="h1 text-center">Registro de Mascotas</h1>
    <!-- formulario para registrar mascota -->
    <div id="contenedorMasc" method="POST" class="container form-container">
        <?php if (!isset($_POST) || empty($_POST)) { ?>
            <form action="" method="POST  id=" formularioMasc"">
                <div class="mb-3">
                    <label for="nombre" class="form-label d-flex justify-content-center align-items-center"><b>Nombre de la Mascota</b></label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="edad" class="form-label d-flex justify-content-center align-items-center"><b>Edad de la Mascota</b></label>
                    <input type="number" class="form-control" id="edad" name="edad" required>
                </div>
                <div class="mb-3">
                    <label for="peso" class="form-label d-flex justify-content-center align-items-center"><b>Peso de la Mascota</b></label>
                    <input type="decimal" class="form-control" id="peso" name="peso" required>
                </div>
                <div class="mb-3">
                    <input type="hidden" name="cliente_id" value="<?= $cliente_id ?>">
                </div>

                <button type="submit" class="btn btn-primary" id="btnGuardar">Guardar</button>
                <a href="index.php" class="btn btn-secondary">Regresar</a>
            </form>
    </div>
<?php } ?>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#btnGuardar').click(function() {
            var nombre = $('input[name="nombre"]').val();
            var edad = $('input[name="edad"]').val();
            var peso = $('select[name="peso"]').val();

            if (nombre === '' || edad === '' || peso === '') {
                alert('Todos los campos del formulario deben estar llenos.');
                return;
            }

            $('#formularioMasc').submit();
        });
    });

    header("Location: index.php");
</script>

</body>

</html>