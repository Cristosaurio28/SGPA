<?php

namespace FJMP\Models;

use FJMP\Domain\Usuario;
//use Inventario\Domain\Usuario\UsuarioFactory;|
use FJMP\Exceptions\NotFoundException;
use FJMP\Exceptions\DbException;
use Exception;
use PDOException;

class UsuarioModel extends AbstractModel {
    public function addUsuario(Usuario $usuario) {
       
        $query = 'INSERT INTO usuario (nombre, tipo, clave, email) values (:nombre, :tipo, :clave, :email)';
        $sth = $this->db->prepare($query);
         try {
            $sth->execute([
                       'nombre' => $usuario->getNombre(),
                       'tipo'   => $usuario->getTipo(),
                       'clave'  => $usuario->getClave(),
                       'email'  => $usuario->getEmail()
                     ]);
        } catch (PDOException $e) {
            // integrity
           throw new DbException( $usuario->getEmail() . ' Ya esta USADO, ingrese otro Correo Electronico');
        }
    }
    public function getById(int $userId): Usuario {
        $query = 'SELECT * FROM usuario WHERE id = :usuarioId';
        $sth = $this->db->prepare($query);
        $sth->execute(['userId' => $userId]);
        $row = $sth->fetch();

        if (empty($row)) {
            throw new NotFoundException();
        }
        return new Usuario( 
            $row['usuarioId'],
             $row['nombre'], 
             $row['tipo'], 
            $row['clave'],
            $row['email']
          
        );
    }

    public function getByEmail(string $email): Usuario {
        $query = 'SELECT * FROM usuario WHERE email = :email';
        $sth = $this->db->prepare($query);
        $sth->execute(['email' => $email]);

        $row = $sth->fetch();

        if (empty($row)) {
            throw new NotFoundException();
        }
        return new Usuario( 
            $row['usuarioId'],
            $row['nombre'], 
            $row['tipo'], 
           $row['clave'],
           $row['email']
         
        );
    }
    public function getByNombre(string $nombre): Usuario {
        $query = 'SELECT * FROM usuario WHERE nombre = :nombre';
        $sth = $this->db->prepare($query);
        $sth->execute(['nombre' => $nombre]);

        $row = $sth->fetch();

        if (empty($row)) {
            throw new NotFoundException();
        }
        return new Usuario( 
            $row['usuarioId'],
            $row['nombre'], 
            $row['tipo'], 
           $row['clave'],
           $row['email']
         
        );
    }
}