<?php
require_once('ORM/Database.php');
require_once('ORM/orm.php');
require_once('ORM/mascotas.php');

// Obtener el ID del cliente seleccionado
$selectedClienteId = isset($_GET['clienteId']) ? $_GET['clienteId'] : null;

// Inicializar la conexión a la base de datos
$db = new Database();
$encontrado = $db->verificarDriver();

// Verificar si se ha seleccionado un cliente
if ($encontrado && $selectedClienteId !== null) {
    $cnn = $db->getConnection();
    $mascotaModelo = new Mascota($cnn);

    // Obtener solo las mascotas asociadas al cliente seleccionado
    $mascotas = $mascotaModelo->getByClienteId($selectedClienteId);

    // Generar el HTML de la tabla de mascotas
    echo '<thead>';
    echo '<tr>';
    echo '<th class="col-sm-1">ID</th>';
    echo '<th class="col-sm-2">Nombre</th>';
    echo '<th class="col-sm-4">Edad</th>';
    echo '<th class="col-sm-2">Peso</th>';
    echo '<th class="col-sm-1">Editar</th>';
    echo '<th class="col-sm-1">Eliminar</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    foreach ($mascotas as $mascota) {
        echo '<tr>';
        echo '<td>' . $mascota['id'] . '</td>';
        echo '<td>' . $mascota['nombre'] . '</td>';
        echo '<td>' . $mascota['edad'] . '</td>';
        echo '<td>' . $mascota['peso'] . '</td>';
        echo '<td class="Editar">';
        echo '<a href="update_mascota.php?id=' . $mascota['id'] . '" class="btn btn-warning btn-xs" data-title="Edit" data-toggle="modal">';
        echo '<span class="glyphicon glyphicon-edit"></span>';
        echo '</a>';
        echo '</td>';
        echo '<td class="Eliminar">';
        echo '<p data-placement="top" data-toggle="tooltip" title="Delete">';
        echo '<a href="delete_mascota.php?id=' . $mascota['id'] . '" class="btn btn-danger btn-xs">';
        echo '<span class="glyphicon glyphicon-trash"></span>';
        echo '</a>';
        echo '</p>';
        echo '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
} else {
    // Manejar el caso cuando no se ha seleccionado un cliente o hay un problema con la conexión
    echo '<tr><td colspan="6">No se pudieron cargar las mascotas.</td></tr>';
}
?>
