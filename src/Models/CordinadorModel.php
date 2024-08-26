<?php

namespace FJMP\Models;

use FJMP\Domain\Cordinador;

//use Inventario\Domain\Usuario\UsuarioFactory;|
use FJMP\Exceptions\NotFoundException;
use FJMP\Exceptions\DbException;
use Exception;
use PDOException;

class CordinadorModel extends AbstractModel {
    public function addCordinador(Cordinador $cordinador) {
       
        $query = 'INSERT INTO cordinador (nombre, comentario, prioridad) values (:nombre, :comentario, :prioridad)';
        $sth = $this->db->prepare($query);
         try {
            $sth->execute([
                       'nombre' => $cordinador->getNombre(),
                       'comentario'   => $cordinador->getComentario(),
                       'prioridad'  => $cordinador->getPrioridad()
                       
                     ]);
        } catch (PDOException $e) {
            // integrity
        }
    }
    public function getById(int $corId): Cordinador {
        $query = 'SELECT * FROM cordinador WHERE id = :cordinadorId';
        $sth = $this->db->prepare($query);
        $sth->execute(['corId' => $corId]);
        $row = $sth->fetch();

        if (empty($row)) {
            throw new NotFoundException();
        }
        return new Cordinador( 
            $row['cordinadorId'],
             $row['nombre'], 
             $row['comentario'], 
            $row['prioridad']
          
        );
    }

    public function getByNombre(string $nombre): Cordinador {
        $query = 'SELECT * FROM cordinador WHERE nombre = :nombre';
        $sth = $this->db->prepare($query);
        $sth->execute(['nombre' => $nombre]);

        $row = $sth->fetch();

        if (empty($row)) {
            throw new NotFoundException();
        }
        return new Cordinador( 
            $row['cordinadorId'],
             $row['nombre'], 
             $row['comentario'], 
            $row['prioridad']
        );
    }
    public function getByPrioridad(string $prioridad): Cordinador {
        $query = 'SELECT * FROM cordinador WHERE prioridad = :prioridad';
        $sth = $this->db->prepare($query);
        $sth->execute(['prioridad' => $prioridad]);

        $row = $sth->fetch();

        if (empty($row)) {
            throw new NotFoundException();
        }
        return new Cordinador( 
            $row['cordinadorId'],
             $row['nombre'], 
             $row['comentario'], 
            $row['prioridad']
        );
    }
}