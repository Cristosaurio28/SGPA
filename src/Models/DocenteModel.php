<?php

namespace FJMP\Models;

use FJMP\Domain\Docente;

//use Inventario\Domain\Usuario\UsuarioFactory;|
use FJMP\Exceptions\NotFoundException;
use FJMP\Exceptions\DbException;
use Exception;
use PDOException;

class DocenteModel extends AbstractModel {
    public function addDocente(Docente $docente) {
       
        $query = 'INSERT INTO docente (nombre, fecha) values (:nombre,:fecha)';
        $sth = $this->db->prepare($query);
         try {
            $sth->execute([
                       'nombre' => $docente->getNombre(),
                       'fecha'   => $docente->getFecha(),                       
                     ]);
        } catch (PDOException $e) {
            // integrity
        }
    }
    public function getById(int $docId): Docente {
        $query = 'SELECT * FROM docente WHERE id = :docenteId';
        $sth = $this->db->prepare($query);
        $sth->execute(['docId' => $docId]);
        $row = $sth->fetch();

        if (empty($row)) {
            throw new NotFoundException();
        }
        return new Docente( 
            $row['docenteId'],
             $row['nombre'], 
             $row['fecha']
          
        );
    }

    public function getByNombre(string $nombre): Docente {
        $query = 'SELECT * FROM docente WHERE nombre = :nombre';
        $sth = $this->db->prepare($query);
        $sth->execute(['nombre' => $nombre]);

        $row = $sth->fetch();

        if (empty($row)) {
            throw new NotFoundException();
        }
        return new Docente( 
            $row['docenteId'],
             $row['nombre'], 
             $row['fecha']
        );
    }
    public function getByFecha(string $fecha): Docente {
        $query = 'SELECT * FROM docente WHERE fecha = :fecha';
        $sth = $this->db->prepare($query);
        $sth->execute(['docente' => $fecha]);

        $row = $sth->fetch();

        if (empty($row)) {
            throw new NotFoundException();
        }
        return new Docente( 
            $row['docenteId'],
             $row['nombre'], 
             $row['fecha']
        );
    }
}