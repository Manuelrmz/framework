<?php
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
	    if(count($availableRoutes) > 0)
    	{
    		$pathArray = explode('/',self::$_path);
            $pathArray = array_filter($pathArray);
            self::$_controller = strtolower(array_shift($pathArray));
            self::$_method = strtolower(array_shift($pathArray));
            self::$_arguments = $pathArray;
    		foreach ($availableRoutes as $ruta => $action) 
    		{
				$route = explode('/',$ruta);
				if(sizeof($route) > 0)
				{
					if(self::$_controller == $route[0])
					{
						if(isset($route[1]))
						{
							if(self::$_method != "")
							{
								if(self::$_method == $route[1])
								{
									self::$_method = $action != "" ? $action : $route[1];
									return;
								}
							}
							else
							{
								if($route[1] == 'index')
								{
									self::$_method = $action != "" ? $action : "index";
									return;
								}
							}
						}
						else
						{
							if(self::$_method == "" || self::$_method == "index")
							{
								self::$_method = 'index';
								return;
							}
						}
					}
				}
    		}
    	}
    	self::$_controller = DEFAULT_ERROR;
    	self::$_method = 'error520';
	}
	public static function getAddressArray()
	{
		return array('controller'=>self::$_controller,'method'=>self::$_method,'arguments'=>self::$_arguments);
	}
}
?>