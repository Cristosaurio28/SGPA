<?php
namespace FJMP\Controllers;

use FJMP\Exceptions\NotFoundException;

class InicioController extends AbstractController {
    public function inicio(): string {
    	if (isset($_SESSION['usuario_id'])) {
    		// The user is allowed here
    		$properties = [
    			'usuario_id' => $_SESSION['usuario_id'],
    			'usuario_nombre' => $_SESSION['usuario_nombre'],
                'usuario_tipo' => $_SESSION['usuario_tipo']
    		];
        	return $this->render('usuario.twig', $properties);
        }
        return $this->render('inicio.twig', []);
    }
}