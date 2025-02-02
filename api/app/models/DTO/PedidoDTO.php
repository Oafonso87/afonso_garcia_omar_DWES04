<?php

namespace App\Models\DTO;

class PedidoDTO implements \JsonSerializable {
    private $pedido_id;
    private $nombre_usuario;
    private $apellidos_usuario;
    private $nombre_producto;
    private $marca_producto;
    private $cantidad;
    private $precio_total;
    private $fecha_pedido;

    // Constructor
    public function __construct($pedido_id, $nombre_usuario, $apellidos_usuario, $nombre_producto, $marca_producto, $cantidad, $precio_total, $fecha_pedido) {
        $this->pedido_id = $pedido_id;
        $this->nombre_usuario = $nombre_usuario;
        $this->apellidos_usuario = $apellidos_usuario;
        $this->nombre_producto = $nombre_producto;
        $this->marca_producto = $marca_producto;
        $this->cantidad = $cantidad;
        $this->precio_total = $precio_total;
        $this->fecha_pedido = $fecha_pedido;
    }

    public function jsonSerialize():mixed {
        return get_object_vars($this);
    }
     
    
    public function getPedidoId() 
    { 
        return $this->pedido_id; 
    }

    public function getNombreUsuario()
    { 
        return $this->nombre_usuario; 
    }

    public function getApellidosUsuario()
    { 
        return $this->apellidos_usuario; 
    }

    public function getNombreProducto()
    { 
        return $this->nombre_producto; 
    }

    public function getMarcaProducto()
    {
         return $this->marca_producto;
    }

    public function getCantidad()
    { 
        return $this->cantidad; 
    }

    public function getPrecioTotal() 
    { 
        return $this->precio_total; 
    }

    public function getFechaPedido() 
    { 
        return $this->fecha_pedido; 
    }
}

?>