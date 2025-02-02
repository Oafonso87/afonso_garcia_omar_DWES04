<?php

namespace App\Controllers;

use App\Models\DAO\PedidoDAO;
use App\Utils\ApiResponse;

class PedidosController{

    private $pedidoDAO;    

    public function __construct(){        
        $this->pedidoDAO = new PedidoDAO();
    }
    
    //GET
    function getAllPedidos(){       
        $pedidos = $this->pedidoDAO->getAllPedidos();        
        
        if(isset($pedidos)){
            return $this->sendJsonResponse(apiResponse: new ApiResponse(
                status: 'success',
                code: 200,
                message: 'Estos son todos los pedidos realizados.',
                data: $pedidos
            ));
        } else {
            return $this->sendJsonResponse(apiResponse: new ApiResponse(
                status: 'not success',
                code: 500,
                message: 'Error al leer los pedidos.',
                data: null
            ));
        }
    }

    //GET
    function getPedidoById($id){
        $pedido = $this->pedidoDAO->getPedidoById($id);
                
        if ($pedido) {
            return $this->sendJsonResponse(apiResponse: new ApiResponse(
                status: 'success',
                code: 200,
                message: 'Este es el pedido con el Id seleccionado:',
                data: $pedido
            ));            
        } else {
            return $this->sendJsonResponse(apiResponse: new ApiResponse(
                status: 'not found',
                code: 404,
                message: 'Pedido no encontrado.',
                data: null
            ));
        }       
    }

    //POST
    public function createPedido($data){        
        if (!$this->pedidoDAO->validarPedido($data)) {            
            return $this->sendJsonResponse(apiResponse: new ApiResponse(
                status: 'bad request',
                code: 400,
                message: 'Error al crear el pedido. Los datos proporcionados no son validos.',
                data: null
            ));
        }

        $pedidoId = $this->pedidoDAO->createPedido($data);
        $nuevoPedido = $this->pedidoDAO->getPedidoById($pedidoId);
        
        if ($nuevoPedido) {            
            return $this->sendJsonResponse(apiResponse: new ApiResponse(
                status: 'success',
                code: 201,
                message: 'Se ha aniadido un pedido con los siguientes datos:',
                data: $nuevoPedido
            ));
        } else {            
            return $this->sendJsonResponse(apiResponse: new ApiResponse(
                status: 'not success',
                code: 500,
                message: 'Error al guardar el pedido.',
                data: null
            ));
        }        
    }

    //PUT
    public function updatePedido($id, $data){       
        $pedidoExistente = $this->pedidoDAO->getPedidoById($id);

        if (!$pedidoExistente) {            
            return $this->sendJsonResponse(new ApiResponse(
                status: 'not found',
                code: 404,
                message: 'Pedido no encontrado.',
                data: null
            ));
        }
        
        $pedidoUp = $this->pedidoDAO->updatePedido($id, $data);        
        $pedidoActualizado = $this->pedidoDAO->getPedidoById($id);

        if ($pedidoActualizado) {           
            return $this->sendJsonResponse(new ApiResponse(
                status: 'success',
                code: 201,
                message: 'Pedido actualizado correctamente.',
                data: $pedidoActualizado
            ));
        } else {           
            return $this->sendJsonResponse(new ApiResponse(
                status: 'error',
                code: 500,
                message: 'Error al actualizar el pedido, verifique los datos proporcionados.',
                data: null
            ));
        }
    }

    //DELETE
    public function deletePedido($id){        
        $pedidoExistente = $this->pedidoDAO->getPedidoById($id);

        if (!$pedidoExistente) {
            return $this->sendJsonResponse(new ApiResponse(
                status: 'not found',
                code: 404,
                message: 'Pedido no encontrado.',
                data: null
            ));
        } elseif ($this->pedidoDAO->deletePedido($id)) {
            return $this->sendJsonResponse(apiResponse: new ApiResponse(
                status: 'success',
                code: 200,
                message: 'Pedido eliminado con exito.',
                data: null
                ));
        } else {       
            return $this->sendJsonResponse(new ApiResponse(
                status: 'error',
                code: 500,
                message: 'Error al eliminar el pedido.',
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