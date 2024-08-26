<?php
namespace FJMP\Domain;

class Usuario {
    private $usuarioId;            // id: es un numero que se usa en la base de datos, i.e. 1
    private $nombre;        // nombre: es un string nombre de usuario, debe ser unico,  i.e. juan23
    private $tipo;
    private $email;         // contraseña: es un string con la contraseña, (posiblemente md5) i.e. asdfq341         
    private $clave;          // tipo: es el tipo de usuario definido en TiposDeUsuario
    
    public function __construct($usuarioId, $nombre, $tipo, $clave, $email){
        $this->usuarioId    = $usuarioId;
        $this->nombre       = $nombre;
        $this->tipo        = $tipo;
        $this->clave        = $clave;
        $this->email        = $email;
    }

    public function getId(): int {
        return $this->usuarioId;
    }
    public function getnombre(): string {
        return $this->nombre;
    }
     public function gettipo(): string {
        return $this->tipo;
    }
    public function getclave(): string {
        return $this->clave;
    }
    public function getemail(): string {
        return $this->email;
    }
}
