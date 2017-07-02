<?php
require_once APP_PATH."Route.php";
class Router
{
	private static $routerInstance;
	private static $_path;
	private static $_requestMethod;
	private static $_routes;
	private static $_controller;
	private static $_method;
	private static $_arguments = array();
	public static function get($ruta,$action = "")
	{
		self::$_routes['GET'][$ruta] = $action;
	}
	public static function post($ruta,$action = "")
	{
		self::$_routes['POST'][$ruta] = $action;
	}
	public static function put($ruta,$action = "")
	{
		self::$_routes['PUT'][$ruta] = $action;
	}
	public static function delete($ruta,$action = "")
	{
		self::$_routes['DELETE'][$ruta] = $action;
	}
	public static function match()
	{
		require_once APP_PATH . "Route.php";
		self::$_requestMethod = $_SERVER["REQUEST_METHOD"];
		self::$_path = isset($_GET["url"]) ? filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL) : DEFAULT_CONTROLLER;
	    $availableRoutes = self::$_routes[self::$_requestMethod];
	    $routeFounded = false;
	    if(count($availableRoutes) > 0)
    	{
    		$pathArray = explode('/',self::$_path);
            $pathArray = array_filter($pathArray);
            self::$_controller = trim(strtolower(array_shift($pathArray)));
            self::$_method = trim(strtolower(array_shift($pathArray)));
            self::$_arguments = $pathArray;
            $currentRoute = self::$_controller . (self::$_method != "" ? "/".self::$_method : "");
    		foreach ($availableRoutes as $ruta => $action) 
    		{
    			if($currentRoute === $ruta || $currentRoute === $ruta.'/index')
    			{
    				$routeFounded = true;
    				if($action instanceof \Closure)
    					self::$_method = $action;
    				else
    					self::$_method = self::$_method != "" ? self::$_method : "index";
    				break;
    			}
    		}
    	}
    	if(!$routeFounded)
    	{
    		self::$_controller = DEFAULT_ERROR;
    		self::$_method = 'error404';
    	}
	}
	public static function getAddressArray()
	{
		return array('controller'=>self::$_controller,'method'=>self::$_method,'arguments'=>self::$_arguments);
	}
}
?>