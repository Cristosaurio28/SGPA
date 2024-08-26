<?php

namespace FJMP\Domain;

class docente{
private $docenteId;
private $nombre;
private $fecha;

public function __construct($docenteId, $nombre,$fecha ){
    $this->docenteId   =$docenteId;
    $this->nombre  = $nombre;
    $this->fecha  = $fecha ;

}
public function getId(): int{
    return $this->docenteId;
}    
public function getNombre(): string{
    return $this->nombre;
}   
public function getFecha(): string{
    return $this->fecha;
}  
}

?>