<?php 
class Veterinario extends Orm{
    function __construct(PDO $connection){
        parent::__construct('id','veterinarios',$connection);
    }
}
?>