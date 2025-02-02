<?php

namespace App\Core;

class Router {
    protected $routes = [];

    public function __construct(){
        $this->routes=[            
            '/productos/get' => 'ProductosController@getAllProductos',
            '/productos/get/{id}' => 'ProductosController@getProductoById',
            '/productos/create' => 'ProductosController@createProducto',
            '/productos/update/{id}' => 'ProductosController@updateProducto',
            '/productos/delete/{id}' => 'ProductosController@deleteProducto',
            '/usuarios/get' => 'UsuariosController@getAllUsuarios',
            '/usuarios/get/{id}' => 'UsuariosController@getUsuarioById',
            '/usuarios/create' => 'UsuariosController@createUsuario',
            '/usuarios/update/{id}' => 'UsuariosController@updateUsuario',
            '/usuarios/delete/{id}' => 'UsuariosController@deleteUsuario',
            '/pedidos/get' => 'PedidosController@getAllPedidos',
            '/pedidos/get/{id}' => 'PedidosController@getPedidoById',
            '/pedidos/create' => 'PedidosController@createPedido',
            '/pedidos/update/{id}' => 'PedidosController@updatePedido',
            '/pedidos/delete/{id}' => 'PedidosController@deletePedido'
        ];
    }

    public function add($route, $params): void{
        $this->routes[$route] = $params;
    }    

    public function match($uri): void{
        $uri = str_replace(search: BASE_URL, replace: '',subject: $uri);
        $uri = parse_url(url: $uri, component: PHP_URL_PATH);

        $requestMethod = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route => $params) {
            $routePattern = preg_replace('/\{[a-zA-Z0-9_]+}/', '([a-zA-Z0-9_]+)', $route);

            $routePattern = str_replace('/', '\/', $routePattern);

            if (preg_match('/^' . $routePattern . '$/', $uri, $matches)) {
                array_shift($matches);
                list($controller, $method) = explode('@', $params);
                $controller = 'App\\Controllers\\' . $controller;

                if (class_exists(class: $controller) && method_exists(object_or_class: $controller, method: $method)) {
                    $controllerInstance = new $controller();

                    if (in_array($requestMethod, ['POST', 'PUT', 'DELETE'])) {
                        $input = json_decode(file_get_contents('php://input'), true);
                        $matches[] = $input;
                    }

                    call_user_func_array([$controllerInstance, $method], $matches);
                    return;                    
                } else {
                    $this->sendNotFound();
                    return;
                }
            }
        } 
        $this->sendNotFound();       
    }

    private function sendNotFound(): void {
        header(header: "HTTP/1.0 404 Not Found");
        echo "404 Not Found";
    }
}

?>