<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    setTimeout(function(){
        $.confirm({
            title: 'Eliminacion',
            content: 'Desea eliminar los datos?',
            buttons: {
                confirm: function () {
                    
                },
                cancel: function () {
                    window.location.href = "clientes.php";
                }
            }
        });
    });
</script>
<?php
require_once('ORM/Database.php');
require_once('ORM/orm.php');
require_once('ORM/clientes.php');

$db = new Database();
$encontrado = $db->verificarDriver();

if ($encontrado) {
    $cnn = $db->getConnection();
    $clientesModelo = new Cliente($cnn);

    $idCliente = isset($_GET['id']) ? $_GET['id'] : null;

    if ($idCliente) {
        if ($clientesModelo->deleteById($idCliente)) {
            header('Location: clientes.php');
            exit();
        } else {
            echo 'No existe cliente con dicho ID';
        }
    } else {
        echo 'El ID del cliente no fue proporcionado';
    }
}
?>
