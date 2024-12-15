<?php
class Tarea {
    
    private $conn;
    public $id_tareas;
    public $equipo;
    public $responsable;
    public $tarea;
    public $descripcion;
    public $fecha_limite;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerTarea() {
        $query = "SELECT * FROM tareas ORDER BY fecha_creacion ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
        
    }
    // public function crearTarea() {
    //     $query = "INSERT INTO tareas 
    //             (equipo, responsable, tarea, descripcion,fecha_limite) 
    //             VALUES (:equipo, :responsable, :tarea, :descripcion, :fecha_limite)";
        
    //     $stmt = $this->conn->prepare($query);

    //     $stmt->bindParam(':equipo', $this->equipo);
    //     $stmt->bindParam(':responsable', $this->responsable);
    //     $stmt->bindParam(':tarea', $this->tarea);
    //     $stmt->bindParam(':descripcion', $this->descripcion);
    //     $stmt->bindParam(':fecha_limite', $this->fecha_limite);

    //     if($stmt->execute()) {
    //         return true;
    //     }
    //     return false;
    // }
    
}