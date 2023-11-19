<?php
require_once('ORM/Database.php');
require_once('ORM/orm.php');
require_once('ORM/veterinarios.php');

$db = new Database();
$encontrado = $db->verificarDriver();

if ($encontrado) {
    $cnn = $db->getConnection();
    $veterinariosModelo = new Veterinario($cnn);

    $idVeterinario = isset($_GET['id']) ? $_GET['id'] : null;

    if ($idVeterinario) {
        if ($veterinariosModelo->deleteById($idVeterinario)) {
            header('Location: veterinarios.php');
            exit();
        } else {
            echo 'No existe ese veterinario para eliminar con ese ID';
        }
    } else {
        echo 'ID de veterinario no proporcionado';
    }
}
?>
