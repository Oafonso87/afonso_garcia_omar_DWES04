<?php

namespace App\Controllers;

use App\Models\DAO\UsuarioDAO;
use App\Utils\ApiResponse;

class UsuariosController{

    private $usuarioDAO;    

    public function __construct(){        
        $this->usuarioDAO = new UsuarioDAO();
    }
    
    //GET
    function getAllUsuarios(){    
        $usuarios = $this->usuarioDAO->getAllUsuarios();        
        
        if(isset($usuarios)){
            return $this->sendJsonResponse(apiResponse: new ApiResponse(
                status: 'success',
                code: 200,
                message: 'Estos son todos los usuarios actualmente.',
                data: $usuarios
            ));
        } else {
            return $this->sendJsonResponse(apiResponse: new ApiResponse(
                status: 'not success',
                code: 500,
                message: 'Error al leer los usuarios.',
                data: null
            ));
        }
    }

    //GET
    function getUsuarioById($id){
        $usuario = $this->usuarioDAO->getUsuarioById($id);
                
        if ($usuario) {
            return $this->sendJsonResponse(apiResponse: new ApiResponse(
                status: 'success',
                code: 200,
                message: 'Este es el usuario con el Id seleccionado:',
                data: $usuario 
            ));            
        } else {            
            return $this->sendJsonResponse(apiResponse: new ApiResponse(
                status: 'not found',
                code: 404,
                message: 'Usuario no encontrado.',
                data: null
            ));
        }       
    }

    //POST
    public function createUsuario($data){
        if (!$this->usuarioDAO->validarUsuario($data)) {            
            return $this->sendJsonResponse(apiResponse: new ApiResponse(
                status: 'bad request',
                code: 400,
                message: 'Error al crear el usuario. Los datos proporcionados no son validos.',
                data: null
            ));
        }

        $usuarioId = $this->usuarioDAO->createUsuario($data);
        $nuevoUsuario = $this->usuarioDAO->getUsuarioById($usuarioId);
        
        if ($nuevoUsuario) {            
            return $this->sendJsonResponse(apiResponse: new ApiResponse(
                status: 'success',
                code: 201,
                message: 'Se ha aniadido un usuario con los siguientes datos:',
                data: $nuevoUsuario
            ));
        } else {            
            return $this->sendJsonResponse(apiResponse: new ApiResponse(
                status: 'not success',
                code: 500,
                message: 'Error al guardar el usuario.',
                data: null
            ));
        }        
    }

    //PUT
    public function updateUsuario($id, $data){            
        $usuarioExistente = $this->usuarioDAO->getUsuarioById($id);

        if (!$usuarioExistente) {
            return $this->sendJsonResponse(new ApiResponse(
                status: 'not found',
                code: 404,
                message: 'Usuario no encontrado.',
                data: null
            ));
        }
        
        $usuarioUp = $this->usuarioDAO->updateUsuario($id, $data);        
        $usuarioActualizado = $this->usuarioDAO->getUsuarioById($id);

        if ($usuarioActualizado) {            
            return $this->sendJsonResponse(new ApiResponse(
                status: 'success',
                code: 201,
                message: 'Usuario actualizado correctamente.',
                data: $usuarioActualizado
            ));
        } else {            
            return $this->sendJsonResponse(new ApiResponse(
                status: 'error',
                code: 500,
                message: 'Error al actualizar el usuario, verifique los datos proporcionados.',
                data: null
            ));
        }
    }

    //DELETE
    public function deleteUsuario($id){        
        $usuarioExistente = $this->usuarioDAO->getUsuarioById($id);

        if (!$usuarioExistente) {            
            return $this->sendJsonResponse(new ApiResponse(
                status: 'not found',
                code: 404,
                message: 'Usuario no encontrado.',
                data: null
            ));
        } elseif ($this->usuarioDAO->deleteUsuario($id)) {            
            return $this->sendJsonResponse(apiResponse: new ApiResponse(
                status: 'success',
                code: 200,
                message: 'Usuario eliminado con exito.',
                data: null
                ));
        } else {        
            return $this->sendJsonResponse(new ApiResponse(
                status: 'error',
                code: 500,
                message: 'Error al eliminar el usuario.',
                data: null
            ));
        }        
    }

    private function sendJsonResponse($apiResponse): void {
        header('Content-Type: application/json');
        http_response_code($apiResponse->getCode());
        echo $apiResponse->toJSON();
    }
}