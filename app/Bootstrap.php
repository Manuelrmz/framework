<?php
require_once APP_PATH.'Router.php';
class Bootstrap
{
    public static function run()
    {
        Router::match();
        self::render(Router::getAddressArray());
    }
    public static function render($address)
    {
        $controller = $address['controller'].'Controller';
        $rutaControlador = CONTROLLER_PATH . $controller . '.php';
        $metodo = $address['method'];
        $args = $address['arguments'];
        if(is_readable($rutaControlador))
        {
            require_once $rutaControlador;
            $controller = new $controller;
            if(is_callable(array($controller, $metodo)))
            {
                if(self::checkAjaxRequest() && $address['controller'] == DEFAULT_ERROR)
                echo json_encode(array('status'=>false,'msg'=>'Error processing the route')); 
                else
                {
                    if(isset($args))
                        call_user_func_array(array($controller, $metodo), $args);
                    else
                        call_user_func(array($controller, $metodo));
                }
            }
            else
            {
                if($address['controller'] == DEFAULT_ERROR)
                throw new Exception("Error: Controller's Method Doesn't Exist", 1);
                self::render(array('controller'=>DEFAULT_ERROR,'method'=>'index','arguments'=>array()));
            }
        }
        else
        {
            if($address['controller'] == DEFAULT_ERROR)
            throw new Exception("Error: Controller Doesn't Exist", 1);
            self::render(array('controller'=>DEFAULT_ERROR,'method'=>'index','arguments'=>array())); 
        }
    }
    public static function checkAjaxRequest()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
}
?>