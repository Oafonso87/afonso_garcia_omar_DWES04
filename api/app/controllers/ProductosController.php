<?php

namespace App\Controllers;

use App\Models\DAO\ProductoDAO;
use App\Utils\ApiResponse;

class ProductosController{

    private $productoDAO;    

    public function __construct(){        
        $this->productoDAO = new ProductoDAO();
    }
    
    //GET
    function getAllProductos(){        
        $productos = $this->productoDAO->getAllProductos();        
        
        if(isset($productos)){
            return $this->sendJsonResponse(apiResponse: new ApiResponse(
                status: 'success',
                code: 200,
                message: 'Estos son todos los productos disponibles.',
                data: $productos
            ));
        } else {
            return $this->sendJsonResponse(apiResponse: new ApiResponse(
                status: 'not success',
                code: 500,
                message: 'Error al leer los productos.',
                data: null
            ));
        }
    }

    //GET
    function getProductoById($id){
        $producto = $this->productoDAO->getProductoById($id);
                
        if ($producto) {
            return $this->sendJsonResponse(apiResponse: new ApiResponse(
                status: 'success',
                code: 200,
                message: 'Este es el producto con el Id seleccionado:',
                data: $producto 
            ));            
        } else {            
            return $this->sendJsonResponse(apiResponse: new ApiResponse(
                status: 'not found',
                code: 404,
                message: 'Producto no encontrado.',
                data: null
            ));
        }       
    }

    //POST
    public function createProducto($data){
        if (!$this->productoDAO->validarProducto($data)) {            
            return $this->sendJsonResponse(apiResponse: new ApiResponse(
                status: 'bad request',
                code: 400,
                message: 'Error al crear el producto. Los datos proporcionados no son validos.',
                data: null
            ));
        }

        $productoId = $this->productoDAO->createProducto($data);
        $nuevoProducto = $this->productoDAO->getProductoById($productoId);
        
        if ($nuevoProducto) {            
            return $this->sendJsonResponse(apiResponse: new ApiResponse(
                status: 'success',
                code: 201,
                message: 'Se ha aniadido un producto con los siguientes datos:',
                data: $nuevoProducto
            ));
        } else {            
            return $this->sendJsonResponse(apiResponse: new ApiResponse(
                status: 'not success',
                code: 500,
                message: 'Error al guardar el producto.',
                data: null
            ));
        }        
    }

    //PUT
    public function updateProducto($id, $data){            
        $productoExistente = $this->productoDAO->getProductoById($id);

        if (!$productoExistente) {            
            return $this->sendJsonResponse(new ApiResponse(
                status: 'not found',
                code: 404,
                message: 'Producto no encontrado.',
                data: null
            ));
        }
        
        $productoUp = $this->productoDAO->updateProducto($id, $data);        
        $productoActualizado = $this->productoDAO->getProductoById($id);

        if ($productoActualizado) {            
            return $this->sendJsonResponse(new ApiResponse(
                status: 'success',
                code: 201,
                message: 'Producto actualizado correctamente.',
                data: $productoActualizado
            ));
        } else {            
            return $this->sendJsonResponse(new ApiResponse(
                status: 'error',
                code: 500,
                message: 'Error al actualizar el producto, verifique los datos proporcionados.',
                data: null
            ));
        }
    }

    //DELETE
    public function deleteProducto($id){        
        $productoExistente = $this->productoDAO->getProductoById($id);

        if (!$productoExistente) {            
            return $this->sendJsonResponse(new ApiResponse(
                status: 'not found',
                code: 404,
                message: 'Producto no encontrado.',
                data: null
            ));
        } elseif ($this->productoDAO->deleteProducto($id)) {            
            return $this->sendJsonResponse(apiResponse: new ApiResponse(
                status: 'success',
                code: 200,
                message: 'Producto eliminado con exito.',
                data: null
                ));
        } else {       
            return $this->sendJsonResponse(new ApiResponse(
                status: 'error',
                code: 500,
                message: 'Error al eliminar el producto.',
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