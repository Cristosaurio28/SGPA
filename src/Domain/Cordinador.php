<?php
namespace FJMP\Domain;

class cordinador{
private $cordinadorId;
private $nombre;
private $comentario;
private $prioridad;

public function __construct($cordinadorId, $nombre, $comentario, $prioridad){

    $this->cordinadorId   =$cordinadorId;
    $this->nombre  = $nombre;
    $this->comentario  = $comentario;
    $this->prioridad  = $prioridad;

}
public function getId(): int{
    return $this->cordinadorId;
}    
public function getNombre(): string{
    return $this->nombre;
}   
public function getComentario(): string{
    return $this->comentario;
} 
public function getPrioridad(): string{
    return $this->prioridad;
} 
}

?>