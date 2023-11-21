<?php 
class Cliente extends Orm{
    function __construct(PDO $connection){
        parent::__construct('id','clientes',$connection);
    }    
}
?>