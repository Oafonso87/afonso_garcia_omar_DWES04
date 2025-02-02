<?php

namespace App\Models\DAO;

use App\Core\DatabaseSingleton;
use App\Models\DTO\ProductoDTO;
use PDO;

class ProductoDAO {

    private $db;

    public function __construct() {
        $this->db=DatabaseSingleton::getInstance();
    }

    public function getAllProductos(){
        $connection = $this->db->getConnection();
        $query = "SELECT * FROM productos";
        $statement = $connection->query($query);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        $productosDTO = array();

        for($i=0; $i<count($result);$i++) {
            $fila = $result[$i];
            $productoDTO = new ProductoDTO(
                $fila['producto_id'],
                $fila['nombre'],
                $fila['marca'],
                $fila['precio'],
                $fila['unidades']
            );
            $productosDTO[] = $productoDTO;
        }
        return $productosDTO;
    }

    public function getProductoById($id) {
        $connection = $this->db->getConnection();
        $query = "SELECT * FROM productos WHERE producto_id = :id";
        $statement = $connection->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $fila = $statement->fetch(PDO::FETCH_ASSOC);

        $productosDTO = array();

        if ($fila) {            
            $productoDTO = new ProductoDTO(
                $fila['producto_id'],
                $fila['nombre'],
                $fila['marca'],
                $fila['precio'],
                $fila['unidades']
            );
            return $productoDTO;
        }        
        return null;
    }
    
    public function validarProducto($nuevoProducto) { 
         
        $datosProducto = $nuevoProducto;     
        $clavesObligatorias = ['nombre', 'marca', 'precio', 'unidades'];
        
        foreach ($clavesObligatorias as $clave) {
            if (!isset($datosProducto[$clave]) || empty($datosProducto[$clave])) {
                return false;
            }
        }
        return true;
    }

    public function createProducto($nuevoProducto) { 
        
        $datosProducto = $nuevoProducto;
        
        $connection = $this->db->getConnection();
        
        $query = "INSERT INTO productos (nombre, marca, precio, unidades) 
                VALUES (:nombre, :marca, :precio, :unidades)";
        
        $statement = $connection->prepare($query);
        
        $statement->bindParam(':nombre', $datosProducto['nombre'], PDO::PARAM_STR);
        $statement->bindParam(':marca', $datosProducto['marca'], PDO::PARAM_STR);
        $statement->bindParam(':precio', $datosProducto['precio'], PDO::PARAM_STR);
        $statement->bindParam(':unidades', $datosProducto['unidades'], PDO::PARAM_INT);
        
        if ($statement->execute()) {            
            return $connection->lastInsertId();
        } else {            
            return null;
        }
    }       
    

    public function updateProducto($id, $datos) {  
        
        try {
            $connection = $this->db->getConnection();
            $query = "UPDATE productos SET ";
            
            $campos = [];
            foreach ($datos as $campo => $valor) {
                $campos[] = "$campo = :$campo";
            }
            
            $query .= implode(", ", $campos);
            $query .= " WHERE producto_id = :id";            
            
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

    public function deleteProducto($id) {     
        try {
            $connection = $this->db->getConnection();    
            
            $query = "DELETE FROM productos WHERE producto_id = :id";
    
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