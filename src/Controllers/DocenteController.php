<?php

namespace FJMP\Controllers;
use FJMP\Exceptions\NotFoundException;
use FJMP\Exceptions\DbException;
use FJMP\Models\DocenteModel;
use FJMP\Domain\Docente;

class DocenteController extends AbstractController {
    public function registro(): string {
         // use pattern POST-RESEND-GET
         if (!$this->request->isPost()) {
            return $this->render('registro.twig', []);
        }

        // POST
        $params = $this->request->getParams();

        if (!($params->has('nombre') && $params->has('fecha'))) {
            $params = ['errorMessage' => 'No info provided.'];
            return $this->render('docente.twig', $params);
        }

        $nombre = $params->getString('nombre');
        $fecha = $params->getString('fecha');

        $docenteModel = new DocenteModel($this->db);

        try {
            $docenteModel->addDocente(new Docente(0, $nombre, $fecha));
        } catch (DbException $e) {
             $properties = ['errorMessage' => $e->getMessage()];
              return $this->render('docente.twig', $properties);
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

        if (!($params->has('nombre') && $params->has('fecha'))) {
            $properties = ['errorMessage' => 'No info provided.'];
            return $this->render('usuario.twig', $properties);
        }

        $nombre = $params->getString('nombre');
        $fecha = $params->getString('fecha');

        $docenteModel = new docenteModel($this->db);

        try {
            $docente= $docenteModel->getByNombre($nombre);
            if ($docente->getFecha() != $fecha)
                throw new NotFoundException(); 
        } catch (NotFoundException $e) {
            //$this->log->warn(' Email de Usuario or CLAVE not found: ');
            $properties = ['errorMessage' => 'Login user or password INFO error.'];
            return $this->render('usuario.twig', $properties);
        }

        // logged in successfull: add cookies or session variable
        //setcookie('usuario_id', $usuario->getId());
        //setcookie('usuario_nombre', $usuario->getNombre());

        $_SESSION['usuario_id'] = $docente->getId();
        $_SESSION['usuario_nombre'] = $docente->getNombre();
        
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