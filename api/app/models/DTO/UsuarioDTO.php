<?php

namespace App\Models\DTO;

class UsuarioDTO implements \JsonSerializable {

    private $usuario_id;
    private $nombre;
    private $apellidos;
    private $email;
    private $password;

    // Constructor
    public function __construct($usuario_id, $nombre, $apellidos, $email, $password) {
        $this->usuario_id = $usuario_id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->password = $password;
    }

    public function jsonSerialize():mixed {
        $data = get_object_vars($this);
        // Se elimina la contraseña antes de devolver el JSON por seguridad
        unset($data['password']); 
        return $data;
    }

    /**
     * Get the value of id_usuario
     */
    public function getIdUsuario()
    {
        return $this->usuario_id;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Get the value of apellidos
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }
}
