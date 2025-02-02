<?php

class ProductoEntity {
    private $id_producto;
    private $nombre;
    private $marca;
    private $precio;
    private $unidades;

    // Constructor
    public function __construct($id_producto, $nombre, $marca, $precio, $unidades)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->marca = $marca;
        $this->precio = $precio;
        $this->unidades = $unidades;
    }
    

    /**
     * Get the value of id_producto
     */
    public function getIdProducto()
    {
        return $this->id_producto;
    }

    /**
     * Set the value of id_producto
     */
    public function setIdProducto($id_producto): self
    {
        $this->id_producto = $id_producto;

        return $this;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     */
    public function setNombre($nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of marca
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set the value of marca
     */
    public function setMarca($marca): self
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get the value of precio
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set the value of precio
     */
    public function setPrecio($precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get the value of unidades
     */
    public function getUnidades()
    {
        return $this->unidades;
    }

    /**
     * Set the value of unidades
     */
    public function setUnidades($unidades): self
    {
        $this->unidades = $unidades;

        return $this;
    }
}

?>