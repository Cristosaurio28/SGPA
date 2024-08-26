<?php

namespace FJMP\Models;

use FJMP\Domain\Proyecto;

//use Inventario\Domain\Usuario\UsuarioFactory;|
use FJMP\Exceptions\NotFoundException;
use FJMP\Exceptions\DbException;
use Exception;
use PDOException;

class ProyectoModel extends AbstractModel {
    public function addDocente(Proyecto $docente) {
       
        $query = 'INSERT INTO Proyecto (titulo, estado, archivo, url) values (:titulo,:estado, :archivo, :url)';
        $sth = $this->db->prepare($query);
         try {
            $sth->execute([
                       'titulo' => $docente->getTitulo(),
                       'estado'   => $docente->getEstado(), 
                       'archivo'   => $docente->getArchivo(),  
                       'url'   => $docente->getUrl(),                       
                     ]);
        } catch (PDOException $e) {
            // integrity
        }
    }
    public function getById(int $proId): Proyecto {
        $query = 'SELECT * FROM proyecto WHERE id = :proyectoId';
        $sth = $this->db->prepare($query);
        $sth->execute(['docId' => $proId]);
        $row = $sth->fetch();

        if (empty($row)) {
            throw new NotFoundException();
        }
        return new Proyecto( 
            $row['proyectoId'],
             $row['titulo'], 
             $row['estado'],
             $row['archivo'],
             $row['url']
        );
    }

    public function getByTitulo(string $titulo): Proyecto {
        $query = 'SELECT * FROM proyecto WHERE titulo = :titulo';
        $sth = $this->db->prepare($query);
        $sth->execute(['titulo' => $titulo]);

        $row = $sth->fetch();

        if (empty($row)) {
            throw new NotFoundException();
        }
        return new Proyecto( 
            $row['proyectoId'],
             $row['titulo'], 
             $row['estado'],
             $row['archivo'],
             $row['url']
        );
    }
    public function getByEstado(string $estado): Proyecto {
        $query = 'SELECT * FROM proyecto WHERE estado = :estado';
        $sth = $this->db->prepare($query);
        $sth->execute(['estado' => $estado]);

        $row = $sth->fetch();

        if (empty($row)) {
            throw new NotFoundException();
        }
        return new Proyecto( 
            $row['proyectoId'],
             $row['titulo'], 
             $row['estado'],
             $row['archivo'],
             $row['url']
        );
    }
}