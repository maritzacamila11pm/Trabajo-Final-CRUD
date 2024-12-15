<?php
//include "./config/Database.php";

//$db = new Database();
//$valida = $db->connect();

//if($valida){
    //echo"conexion establecida correctamente";
//}else{
    //echo"error de conection";
//}

// manejo de errores

error_reporting(E_ALL);
ini_set('display_errors',1);

//cargar el archivo de configuracion
include_once 'config/config.php';

//Autoload de clases
spl_autoload_register(function ($class_name) {
    $directories = [
        'controllers/',
        'models/',
        'config/',
        'utils/',
        ''
    ];
    
    foreach ($directories as $directory) {
        $file = $directory . $class_name . '.php';
        if (file_exists($file)) {
            // var_dump($file);
            require_once $file;
            return;
        }
    }
});

//crear una instancia de router
$router = new Router();

$public_routes =[
    '/web',
    '/login',
    '/register',

];

//optener la ruta actual
$current_route = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
$current_route = str_replace(dirname($_SERVER['SCRIPT_NAME']),'',$current_route);
//LOGIN
$router->add('GET','/login','AuthController','showLogin',);
//REGISTER
$router->add('GET','/register','AuthController','showRegister',);
//LOGIN
$router->add('POST', 'auth/login', 'AuthController', 'login');
//REGISTER
$router->add('POST', 'auth/register', 'AuthController', 'register');
/// HOME CONTROLLER
$router->add('GET', '/home', 'HomeController', 'index');
/// CRUD TAREAS 
$router->add('GET', 'tarea/', 'TareaController', 'index');
$router->add('GET', 'tarea/obtener', 'TareaController', 'obtenerTarea');

//Despachar la ruta
try {
    $router->dispatch($current_route, $_SERVER['REQUEST_METHOD']);
} catch (Exception $e) {
    // Manejar el error
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        include 'views/errors/404.php';
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
} 