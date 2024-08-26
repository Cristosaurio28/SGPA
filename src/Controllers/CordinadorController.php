<?php

namespace FJMP\Controllers;
use FJMP\Exceptions\NotFoundException;
use FJMP\Exceptions\DbException;
use FJMP\Models\CordinadorModel;
use FJMP\Domain\Cordinador;

class CordinadorController extends AbstractController {
    public function registro(): string {
         // use pattern POST-RESEND-GET
         if (!$this->request->isPost()) {
            return $this->render('registro.twig', []);
        }

        // POST
        $params = $this->request->getParams();

        if (!($params->has('nombre') && $params->has('comentario') && $params->has('prioridad'))) {
            $params = ['errorMessage' => 'No info provided.'];
            return $this->render('cordinador.twig', $params);
        }

        $nombre = $params->getString('nombre');
        $comentario = $params->getString('comentario');
        $prioridad = $params->getString('prioridad');

        $cordinadorModel = new CordinadorModel($this->db);

        try {
            $cordinadorModel->addCordinador(new Cordinador(0, $nombre, $comentario, $prioridad));
        } catch (DbException $e) {
             $properties = ['errorMessage' => $e->getMessage()];
              return $this->render('cordinador.twig', $properties);
        }

        // resend  & GET
        header("Location: /", true,303);
        exit();
        //$properties = ['errorMessage' => 'Registo exitoso!!!'];
        //return $this->render('login.twig', $properties);
    }

    public function login(): string {
        
        // 1. GET from anchor or rute
        if (!$this->request->isPost()) {
            return $this->render('login.twig', []);
        }

        // NOT HERE if already logged in POST
    
        if (isset($_SESSION['usuario_id'])) {
            // The user is allowed here
            $properties = [
                'usuario_id' => $_SESSION['usuario_id'],
                'usuario_nombre' => $_SESSION['usuario_nombre']
            ];

            return $this->render('usuario.twig', $properties);
        }
        
        
        // 2. POST PROCESSING    

        $params = $this->request->getParams();

        if (!($params->has('nombre') && $params->has('comentario') && $params->has('prioridad'))) {
            $properties = ['errorMessage' => 'No info provided.'];
            return $this->render('usuario.twig', $properties);
        }

        $nombre = $params->getString('nombre');
        $comentario = $params->getString('comentario');
        $prioridad = $params->getString('prioridad');

        $cordinadorModel = new cordinadorModel($this->db);

        try {
            $cordinador= $cordinadorModel->getByNombre($nombre);
            if ($cordinador->getPrioridad() != $prioridad)
                throw new NotFoundException(); 
        } catch (NotFoundException $e) {
            //$this->log->warn(' Email de Usuario or CLAVE not found: ');
            $properties = ['errorMessage' => 'Login user or password INFO error.'];
            return $this->render('usuario.twig', $properties);
        }

        // logged in successfull: add cookies or session variable
        //setcookie('usuario_id', $usuario->getId());
        //setcookie('usuario_nombre', $usuario->getNombre());

        $_SESSION['usuario_id'] = $cordinador->getId();
        $_SESSION['usuario_nombre'] = $cordinador->getNombre();
        
        // pass variables to views
        //$properties = [
        //    'usuario_id' => $usuario->getId(),
        //    'usuario_nombre' => $usuario->getNombre()
        //];
        // 3. resend, and GET /
        header("Location: /", true,303);
        exit();
        //return $this->render('usuario.twig', $properties);

    }

    public function logout() {
        // LOGOUT fisrt GET, DESTROY SESSION, GET
        
        // usual logout
        session_destroy();                          
        session_write_close();                     
        setcookie(session_name(),'',0,'/');
        unset($_POST['email']);
        unset($_POST['clave']);

         // added by FJMP
        session_regenerate_id(true);
        //$id_sesion_nueva = session_id();

        // resend and GET
        header("Location: /");
        exit;
        //return $this->render('login.twig', []);
    }
}