<?php
$dsn = 'mysql:host=localhost;dbname=veterinaria';
$user = 'root';
$pass = '';

try {
    $conn = new PDO($dsn, $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];

    // Validación en servidor
    if (empty($nombres) || empty($apellidos) || empty($telefono)) {
        echo "Todos los campos son obligatorios.";
        // Aquí podrías redirigir al usuario de vuelta al formulario con un mensaje
        exit;
    }
    // Insertar con PDO
    $sql = "INSERT INTO clientes (nombres, apellidos, telefono) 
                VALUES (:nombres, :apellidos, :telefono)";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':nombres', $nombres);
    $stmt->bindParam(':apellidos', $apellidos);
    $stmt->bindParam(':telefono', $telefono);

    $stmt->execute();
    // Obtener id generado
    $cliente_id = $conn->lastInsertId();

    //header("Location: mascotadisenio.php");
    header("Location: insertar_mascota.php?cliente_id=$cliente_id");
    //header("Location: mascotadisenio.php?cliente_id=" . urlencode($cliente_id));
    exit;
}
