<?php
// Archivo de conexión a la base de datos
require_once 'db.php';

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validar que los campos no estén vacíos
    if (empty($username) || empty($password)) {
        $error = "Por favor, complete todos los campos.";
    } else {
        // Verificar las credenciales en la base de datos
        try {
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE login = :username AND pwd = :password");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->execute();

            // Verificar si se encontraron resultados
            if ($stmt->rowCount() > 0) {
                // Inicio de sesión exitoso, redireccionar a la página principal
                header('Location: index.php');
                exit();
            } else {
                $error = "Credenciales incorrectas. Por favor, inténtelo nuevamente.";
            }
        } catch (PDOException $e) {
            echo "Error al consultar la base de datos: " . $e->getMessage();
            die();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="validate.js"></script>
    <title>Iniciar Sesión</title>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4">Iniciar Sesión</h2>

            <?php
            if (isset($error)) {
                echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
            }
            ?>

            <form id="loginForm" action="login.php" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Usuario:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>

