<?php
require_once('ORM/Database.php');
require_once('ORM/orm.php');
require_once('ORM/mascotas.php');

$db = new Database();
$encontrado = $db->verificarDriver();

if ($encontrado) {
    $cnn = $db->getConnection();
    $mascotaModelo = new Mascota($cnn);

    $idMascota = isset($_GET['id']) ? $_GET['id'] : null;

    if ($idMascota) {
        if ($mascotaModelo->deleteById($idMascota)) {
            header('Location: mascotas.php');
            exit();
        } else {
            echo 'No existe esa Mascota para eliminar con ese ID';
        }
    } else {
        echo 'ID de mascota no proporcionado';
    }
}
?>
