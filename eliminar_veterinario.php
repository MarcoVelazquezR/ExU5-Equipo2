<?php
require_once('ORM/Database.php');
require_once('ORM/orm.php');
require_once('ORM/compra.php');

$db= new Database();
$encontrado=$db->verificarDriver();
$id = $_GET['id'];

if($encontrado){
    $cnn= $db->getConnection();
    $compraModelo= new Veterinario($cnn);
    $compra= $compraModelo->deleteById($id);

    if($compraModelo->deleteById($id)){
        echo 'Compra eliminada';
    }
    else{
        echo 'No existe esa compra para eliminar con ese id';
    }
}
?>
