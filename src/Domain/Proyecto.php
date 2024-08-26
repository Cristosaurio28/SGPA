<?php

 namespace FJMP\Domain;

 class proyecto{
    private $proyectoId;
    private $titulo;
    private $estado;
    private $archivo;
    private $url;
    


    public function __construct($proyectoId, $titulo, $estado, $archivo, $url){
      $this->proyectoId       = $proyectoId;
      $this->titulo           = $titulo;
      $this->estado           = $estado;
      $this->archivo           = $archivo;
      $this->url           = $url;
    }
    public function getId(): int{
      return $this->proyectoId;
    }
    public function getTitulo(): string{
      return $this->titulo;
    }
    public function getEstado(): string{
      return $this->estado;
    }
    public function getArchivo(): string{
      return $this->archivo;
    }
    public function getUrl(): string{
      return $this->url;
    }
 }
 ?>