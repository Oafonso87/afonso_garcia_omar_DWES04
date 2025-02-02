<?php

namespace App\Models\DTO;

class ProductoDTO implements \JsonSerializable {
    private $producto_id;
    private $nombre;
    private $marca;
    private $precio;
    private $unidades;

    // Constructor
    public function __construct($producto_id, $nombre, $marca, $precio, $unidades) {
        $this->producto_id = $producto_id;
        $this->nombre = $nombre;
        $this->marca = $marca;
        $this->precio = $precio;
        $this->unidades = $unidades;
    }

    public function jsonSerialize():mixed {
        return get_object_vars($this);
    }
    

    /**
     * Get the value of producto_id
     */
    public function getProductoId()
    {
        return $this->producto_id;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Get the value of marca
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Get the value of precio
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Get the value of unidades
     */
    public function getUnidades()
    {
        return $this->unidades;
    }    
}

?>