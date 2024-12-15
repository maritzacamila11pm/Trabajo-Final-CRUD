<?php
class AuthController {
    private $db;
    private $usuario;

    public function __construct() 
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        $datebase = new Database();
        $this->db = $datebase->connect();
        $this->usuario = new Usuario($this->db);
    }    

    public function showLogin() {
        include 'views/auth/login.php';
        
    }

    public function showRegister(){
        include 'views/auth/register.php';
        
    }


    public function login() {
        header('Content-Type: application/json'); 
        try {

            $data = json_decode(file_get_contents("php://input"));
            // var_dump ($data);
            if (empty($data->nombreUsuario) && empty($data->claveUsuario)){
                throw new Exception('Usuario y Contraseña son requeridos');
            }
            
            $usuario =$this->usuario->login($data->nombreUsuario ,$data->claveUsuario);
            if ($usuario) {
                session_start();
                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                $_SESSION['usuario'] = $usuario['nombre_usuario'];
                $_SESSION['correo'] = $usuario['correo'];
                $_SESSION['nombre_completo'] = $usuario['nombre_completo'];

                echo json_encode([
                    'status' => 'success',
                    'message'=> 'Login exitoso 😉',
                    'usuario'=> [
                        'nombre_usuario'=> $usuario['nombre_usuario'],
                        'nombre_completo'=>$usuario['nombre_completo'],

                    ]
                ]);

            }else{
                throw new Exception("Usuario o contraseñas incorrectos");
                
            }
            
            //  var_dump($usuario);
            // throw new Exception('Error al iniciar sesion');
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
    public function register(){
        header('Content-Type: application/json');
        try {
            $data = json_decode(file_get_contents("php://input"));

            if (
                empty($data->clave) && 
                empty($data->confirmarClave)&&
                empty($data->gmail)&&
                empty($data->nombreCompleto)&&
                empty($data->usuario)
                ){
                throw new Exception('Los campos son requeridos 🧐');
            }
            //comparar las dos comtraseñas y generar un error en caso de no ser iguales 
        
            if ($data->clave != $data->confimarClave ) {
                throw new Exception('Las contraseñas no coinciden 🤐');
                
            }

            if ( $this->usuario->validaUsuario($data->usuario)) {
                throw new Exception('El usuario ya existe 🤔');
            }
            if ( $this->usuario->validaCorreo($data->gmail)) {
                throw new Exception('El correo ya existe 🤔');
            }
            // if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/',$data->clave)) {
            //     throw new Exception('El Contraseña debe contener al menos un carácter especial 🙃');
            // }
            // if (strlen($data->clave) < 8) {
            //     throw new Exception('El Contraseña debe tener al menos 8 caracteres 😁');
            // }
            $usuarioData =[
               "clave"=> $data->clave,
               "gmail" => $data->gmail,
               "nombreCompleto" =>$data->nombreCompleto,
               "usuario" =>$data->usuario,

            ];

           if ($this->usuario->registrarUsuario($usuarioData)) {
            echo json_encode([
                'status' => 'success',
                'message'=> 'Usuario registrado correctamente 😉',
            ]);
           } else{
            throw new Exception('No se pudo registar 🤔');
           };
    

        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }


}