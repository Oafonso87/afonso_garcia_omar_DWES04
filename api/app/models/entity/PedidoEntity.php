<?php

class PedidoEntity {
    private $pedido_id;
    private $usuario_id;
    private $producto_id;
    private $cantidad;
    private $precio_total;
    private $fecha_pedido;

    // Constructor
    public function __construct($pedido_id, $usuario_id, $producto_id, $cantidad, $precio_total, $fecha_pedido) {
        $this->pedido_id   = $pedido_id;
        $this->usuario_id  = $usuario_id;
        $this->producto_id = $producto_id;
        $this->cantidad    = $cantidad;
        $this->precio_total = $precio_total;
        $this->fecha_pedido = $fecha_pedido;
    }

    /**
     * Get the value of pedido_id
     */
    public function getPedidoId() {
        return $this->pedido_id;
    }

    /**
     * Set the value of pedido_id
     */
    public function setPedidoId($pedido_id): self {
        $this->pedido_id = $pedido_id;
        return $this;
    }

    /**
     * Get the value of usuario_id
     */
    public function getUsuarioId() {
        return $this->usuario_id;
    }

    /**
     * Set the value of usuario_id
     */
    public function setUsuarioId($usuario_id): self {
        $this->usuario_id = $usuario_id;
        return $this;
    }

    /**
     * Get the value of producto_id
     */
    public function getProductoId() {
        return $this->producto_id;
    }

    /**
     * Set the value of producto_id
     */
    public function setProductoId($producto_id): self {
        $this->producto_id = $producto_id;
        return $this;
    }

    /**
     * Get the value of cantidad
     */
    public function getCantidad() {
        return $this->cantidad;
    }

    /**
     * Set the value of cantidad
     */
    public function setCantidad($cantidad): self {
        $this->cantidad = $cantidad;
        return $this;
    }

    /**
     * Get the value of precio_total
     */
    public function getPrecioTotal() {
        return $this->precio_total;
    }

    /**
     * Set the value of precio_total
     */
    public function setPrecioTotal($precio_total): self {
        $this->precio_total = $precio_total;
        return $this;
    }

    /**
     * Get the value of fecha_pedido
     */
    public function getFechaPedido() {
        return $this->fecha_pedido;
    }

    /**
     * Set the value of fecha_pedido
     */
    public function setFechaPedido($fecha_pedido): self {
        $this->fecha_pedido = $fecha_pedido;
        return $this;
    }
}

?>