<?php
class TareaController{
    
    private $db;
    private $tareas;

    public function __construct() 
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        $datebase = new Database();
        $this->db = $datebase->connect();
        $this->tareas = new Tarea($this->db);
    }    

    public function index(){
        include 'views/layouts/header.php';
        include 'views/tarea/index.php';
        include 'views/layouts/footer.php';

    }

    public function obtenerTarea() {
        header('Content-Type: application/json'); 
        try {
            // Llamar al método obtenerTarea de la clase Tarea
            $resultado = $this->tareas->obtenerTarea();
            
            // Verificar si la consulta devuelve filas
            if ($resultado->rowCount() > 0) {
                // Si hay resultados, convertirlos a un array asociativo
                $tareas = $resultado->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode([
                    'status' => 'success',
                    'data' => $tareas
                ]);
            } else {
                // Si no hay resultados, devolver un array vacío
                echo json_encode([
                    'status' => 'success',
                    'data' => []
                ]);
            }
        } catch (Exception $e) {
            // En caso de error, devolver un mensaje de error
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
    
    
    

    //FORMA 1 - FUNCIONA RARO 
    // public function guardarTarea()
    // {
    //     header('Content-Type: application/json');
    //     $data = json_decode(file_get_contents('php://input'), true);

    
    //     $this->tareas ->equipo = $data['equipo'];
    //     $this->tareas ->responsable = $data['responsable'];
    //     $this->tareas ->tarea = $data['tarea'];
    //     $this->tareas->fase = $data['fase'];
    //     $this->tareas->descripcion = $data['descripcion'] ?? '';
    //     $this->tareas->fecha_limite = $data['fecha_limite'];

    //     try {
    //         $resultado = $this->tareas->crearTarea();
    //         if ($resultado) {
    //             echo json_encode([
    //                 'status' => 'success',
    //                 'message' => 'Tarea creada exitosamente.'
    //             ]);
    //         } else {
    //             echo json_encode([
    //                 'status' => 'error',
    //                 'message' => 'Error al crear tarea.'
    //             ]);
    //         }
    //     } catch (Exception $e) {
    //         echo json_encode([
    //             'status' => 'error',
    //             'message' => $e->getMessage()
    //         ]);
    //     }
    // }
    
    //FORMA 2 - EN PROCESO 
    public function guardarTarea(){
        header('Content-Type: application/json'); 
    
        try {
            // Validación de campos
            if (
                empty($_POST['equipo']) ||
                empty($_POST['responsable']) ||
                empty($_POST['tarea']) ||
                empty($_POST['fase']) ||
                empty($_POST['descripcion']) ||
                empty($_POST['fecha_limite'])
            ) {
                throw new Exception('Todos los campos son requeridos.');
            }
    
            // Asignación de valores a las propiedades del objeto tarea
            $this->tareas->equipo = $_POST['equipo'];
            $this->tareas->responsable = $_POST['responsable'];
            $this->tareas->tarea = $_POST['tarea'];
            $this->tareas->fase = $_POST['fase'];
            $this->tareas->descripcion = $_POST['descripcion'];
            $this->tareas->fecha_limite = $_POST['fecha_limite'];
    
            // Llamada al método que guarda la tarea
            if ($this->tareas->crearTarea()) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Tarea creada correctamente 😉',
                ]);
            } else {
                throw new Exception('No se pudo crear la tarea 🤔');
            }
    
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
    
}
