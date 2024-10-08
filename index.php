<?php 
use FJMP\Core\Config;
use FJMP\Core\Router;
use FJMP\Core\Request;
use FJMP\Utils\DependencyInjector;
//use IOT\Models\UsuarioModel;

require_once __DIR__ . '/vendor/autoload.php';

// Sessions are always turned on
if (!isset($_SESSION)) {
	session_start();
}


// Config  DB parameters
$config = new Config();

// Database
$dbConfig = $config->get('db');

try {
	$db = new PDO(
    	'mysql:host=127.0.0.1;dbname=' . $dbConfig['database'] ,
    	$dbConfig['user'],
    	$dbConfig['password']
		);
	//$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'servicio no disponible!! ';
    //echo  $e->getMessage();
    exit();
}

// twig view engine
$loader = new Twig_Loader_Filesystem(__DIR__ . '/views');
$view = new Twig_Environment($loader);

//$log = new Logger('inventario');
//$logFile = $config->get('log');
//$log->pushHandler(new StreamHandler($logFile, Logger::DEBUG));

$di = new DependencyInjector();
$di->set('PDO', $db);
$di->set('Utils\Config', $config);
$di->set('Twig_Environment', $view);
//$di->set('Logger', $log);

// setup model
//$di->set('UsuarioModel', new UsuarioModel($di->get('PDO')));

// router
$router = new Router($di);
$response = $router->route(new Request());
echo $response;