<?php
require_once APP_PATH."Route.php";
class Router
{
	private static $_routes;
	private static $_path;
	private static $_method ;
	private static $_controller = "";
	private static $_metodo = "";
	private static $_args = array();
	public static function get($ruta,$action = ""){self::$_routes['GET'][$ruta] = $action;}
	public static function post($ruta,$action = ""){self::$_routes['POST'][$ruta] = $action;}
	public static function put($ruta,$action = ""){self::$_routes['PUT'][$ruta] = $action;}
	public static function delete($ruta,$action = ""){self::$_routes['DELETE'][$ruta] = $action;}
	public static function match()
	{
		self::$_method = $_SERVER['REQUEST_METHOD'];
		self::$_path = isset($_GET['url']) ? filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL) : DEFAULT_CONTROLLER;
	    $_tmp = self::$_routes[self::$_method];
	    if(count($_tmp) > 0)
    	{
    		$pathArray = explode('/',self::$_path);
            $pathArray = array_filter($pathArray);
            self::$_controller = strtolower(array_shift($pathArray));
            self::$_metodo = strtolower(array_shift($pathArray));
            self::$_args = $pathArray;
    		foreach ($_tmp as $ruta => $action) 
    		{
				$rutaTmp = explode('/',$ruta);
				if(sizeof($rutaTmp) > 0)
				{
					if($rutaTmp[0] == self::$_controller)
					{
						if(isset($rutaTmp[1]) && $rutaTmp[1] != "")
						{
							if(self::$_metodo != "")
							{
								if(self::$_metodo == $rutaTmp[1])
								{
									self::$_metodo = $action != "" ? $action : $rutaTmp[1];
									return;
								}
							}
							else
							{
								if($rutaTmp[1] == 'index')
								{
									self::$_metodo = $action != "" ? $action : "index";
									return;
								}
							}
						}
						else
						{
							if(self::$_metodo == "" || self::$_metodo == "index")
							{
								$this->_metodo = 'index';
								return;
							}
						}
					}
				}
    		}
    	}
    	self::$_controller = DEFAULT_ERROR;
    	self::$_metodo = 'error520';
	}
	public static function getAddressArray()
	{
		return array('controller'=>self::$_controller,'method'=>self::$_metodo,'arguments'=>self::$_args);
	}
}
?>