<?php
class Mascota extends Orm
{
    private $conn;

    function __construct(PDO $connection)
    {
        parent::__construct('id', 'mascotas', $connection);
        $this->conn = $connection;  // Fix the variable name here
    }

    public function getByClienteId($clienteId)
    {
        $query = "SELECT * FROM mascotas WHERE id_cliente = :clienteId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':clienteId', $clienteId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
