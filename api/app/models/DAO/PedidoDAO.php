<?php

namespace App\Models\DAO;

use App\Core\DatabaseSingleton;
use App\Models\DTO\PedidoDTO;
use PDO;

class PedidoDAO {

    private $db;

    public function __construct() {
        $this->db=DatabaseSingleton::getInstance();
    }

    public function getAllPedidos(){
        $connection = $this->db->getConnection();
        $query = "SELECT p.pedido_id, u.nombre AS nombre_usuario, u.apellidos AS apellidos_usuario, pr.nombre AS nombre_producto, 
            pr.marca AS marca_producto,p.cantidad, p.precio_total, p.fecha_pedido FROM pedidos p JOIN usuarios u ON 
            p.usuario_id = u.usuario_id JOIN productos pr ON p.producto_id = pr.producto_id";
        $statement = $connection->query($query);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        $pedidosDTO = array();

        for($i=0; $i<count($result);$i++) {
            $fila = $result[$i];
            $pedidoDTO = new PedidoDTO(
                $fila['pedido_id'],
                $fila['nombre_usuario'],
                $fila['apellidos_usuario'],
                $fila['nombre_producto'],
                $fila['marca_producto'],
                $fila['cantidad'],
                $fila['precio_total'],
                $fila['fecha_pedido']
            );
            $pedidosDTO[] = $pedidoDTO;
        }
        return $pedidosDTO;
    }

    public function getPedidoById($id) {
        $connection = $this->db->getConnection();
        $query = "SELECT p.pedido_id, u.nombre AS nombre_usuario, u.apellidos AS apellidos_usuario, pr.nombre AS nombre_producto, 
            pr.marca AS marca_producto, p.cantidad, p.precio_total, p.fecha_pedido FROM pedidos p JOIN usuarios u ON
            p.usuario_id = u.usuario_id JOIN productos pr ON p.producto_id = pr.producto_id WHERE pedido_id = :id";
        $statement = $connection->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $fila = $statement->fetch(PDO::FETCH_ASSOC);

        $pedidosDTO = array();

        if ($fila) {            
            $pedidoDTO = new PedidoDTO(
                $fila['pedido_id'],
                $fila['nombre_usuario'],
                $fila['apellidos_usuario'],
                $fila['nombre_producto'],
                $fila['marca_producto'],
                $fila['cantidad'],
                $fila['precio_total'],
                $fila['fecha_pedido']
            );
            return $pedidoDTO;
        }        
        return null;
    }
    
    public function validarPedido($nuevoPedido) { 
         
        $datosPedido = $nuevoPedido;     
        $clavesObligatorias = ['usuario_id', 'producto_id', 'cantidad', 'precio_total', 'fecha_pedido'];
        
        foreach ($clavesObligatorias as $clave) {
            if (!isset($datosPedido[$clave]) || empty($datosPedido[$clave])) {
                return false;
            }
        }
        return true;
    }

    public function createPedido($nuevoPedido) { 
        
        $datosPedido = $nuevoPedido;
        
        $connection = $this->db->getConnection();
        
        $query = "INSERT INTO pedidos (usuario_id, producto_id, cantidad, precio_total, fecha_pedido) 
                VALUES (:usuario_id, :producto_id, :cantidad, :precio_total, :fecha_pedido)";
        
        $statement = $connection->prepare($query);
        
        $statement->bindParam(':usuario_id', $datosPedido['usuario_id'], PDO::PARAM_INT);
        $statement->bindParam(':producto_id', $datosPedido['producto_id'], PDO::PARAM_INT);
        $statement->bindParam(':cantidad', $datosPedido['cantidad'], PDO::PARAM_INT);
        $statement->bindParam(':precio_total', $datosPedido['precio_total'], PDO::PARAM_STR);
        $statement->bindParam(':fecha_pedido', $datosPedido['fecha_pedido'], PDO::PARAM_STR);
        
        if ($statement->execute()) {            
            return $connection->lastInsertId();
        } else {            
            return null;
        }
    }       
    

    public function updatePedido($id, $datos) {  
        
        try {
            $connection = $this->db->getConnection();
            $query = "UPDATE pedidos SET ";
            
            $campos = [];
            foreach ($datos as $campo => $valor) {
                $campos[] = "$campo = :$campo";
            }
            
            $query .= implode(", ", $campos);
            $query .= " WHERE pedido_id = :id";            
            
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

    public function deletePedido($id) {     
        try {
            $connection = $this->db->getConnection();    
            
            $query = "DELETE FROM pedidos WHERE pedido_id = :id";    
            
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