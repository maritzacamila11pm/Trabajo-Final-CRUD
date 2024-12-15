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

    public function obtenerTarea(){

        header('Content-Type: application/json'); 
        try {
            $resultado = $this->tareas->obtenerTarea();
            $tarea = $resultado->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode([
                'status' => 'success',
                'data' => $tarea
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    } 

}
