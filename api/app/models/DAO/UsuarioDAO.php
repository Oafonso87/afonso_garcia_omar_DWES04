<?php

namespace App\Models\DAO;

use App\Core\DatabaseSingleton;
use App\Models\DTO\UsuarioDTO;
use PDO;

class UsuarioDAO {

    private $db;

    public function __construct() {
        $this->db=DatabaseSingleton::getInstance();
    }

    public function getAllUsuarios(){
        $connection = $this->db->getConnection();
        $query = "SELECT * FROM usuarios";
        $statement = $connection->query($query);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        $usuariosDTO = array();

        for($i=0; $i<count($result);$i++) {
            $fila = $result[$i];
            $usuarioDTO = new UsuarioDTO(
                $fila['usuario_id'],
                $fila['nombre'],
                $fila['apellidos'],
                $fila['email'],
                $fila['password']
            );
            $usuariosDTO[] = $usuarioDTO;
        }
        return $usuariosDTO;
    }

    public function getUsuarioById($id) {
        $connection = $this->db->getConnection();
        $query = "SELECT * FROM usuarios WHERE usuario_id = :id";
        $statement = $connection->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $fila = $statement->fetch(PDO::FETCH_ASSOC);

        $usuariosDTO = array();

        if ($fila) {
            $usuarioDTO = new UsuarioDTO(
                $fila['usuario_id'],
                $fila['nombre'],
                $fila['apellidos'],
                $fila['email'],
                $fila['password']
            );
            return $usuarioDTO;
        }        
        return null;
    }

    public function validarUsuario($nuevoUsuario) { 
         
        $datosUsuario = $nuevoUsuario;     
        $clavesObligatorias = ['nombre', 'apellidos', 'email', 'password'];

        foreach ($clavesObligatorias as $clave) {
            if (!isset($datosUsuario[$clave]) || empty($datosUsuario[$clave])) {
                return false;
            }
        }
        return true;
    }

    public function createUsuario($nuevoUsuario) { 
        
        $datosUsuario = $nuevoUsuario;

        $connection = $this->db->getConnection();

        $query = "INSERT INTO usuarios (nombre, apellidos, email, password) 
            VALUES (:nombre, :apellidos, :email, :password)";

        $statement = $connection->prepare($query);
        
        $statement->bindParam(':nombre', $datosUsuario['nombre'], PDO::PARAM_STR);
        $statement->bindParam(':apellidos', $datosUsuario['apellidos'], PDO::PARAM_STR);
        $statement->bindParam(':email', $datosUsuario['email'], PDO::PARAM_STR);
        $statement->bindParam(':password', $datosUsuario['password'], PDO::PARAM_STR);
        
        if ($statement->execute()) {            
            return $connection->lastInsertId();
        } else {            
            return null;
        }
    }       
    

    public function updateUsuario($id, $datos) {  
        
        try {
            $connection = $this->db->getConnection();
            $query = "UPDATE usuarios SET ";
            
            $campos = [];
            foreach ($datos as $campo => $valor) {
                $campos[] = "$campo = :$campo";
            }
            
            $query .= implode(", ", $campos);
            $query .= " WHERE usuario_id = :id";

                        
            $statement = $connection->prepare($query);

            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            
            foreach ($datos as $campo => $valor) {
                $statement->bindValue(":$campo", $valor, PDO::PARAM_STR);
            }
            if ($statement->execute()) {
                return true;
            } else {                
                return false;
            }       
        } catch (PDOException $exception) {
            return false;
        }            
    }

    public function deleteUsuario($id) {     
        try {
            $connection = $this->db->getConnection();    
            
            $query = "DELETE FROM usuarios WHERE usuario_id = :id";    
            
            $statement = $connection->prepare($query);    
            
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
    
            if ($statement->execute()) {
                return true;
            } else {                
                return false;
            }       
        } catch (PDOException $exception) {
            return false;
        }
    }
}
?>