<?php
require_once 'define.php';
require_once APP_PATH . 'autoload.php';
require_once APP_PATH . 'Config.php';
require_once APP_PATH . 'Authentication.php';
require_once APP_PATH . 'Bootstrap.php';
require_once APP_PATH . 'Controller.php';
require_once APP_PATH . 'View.php';
require_once APP_PATH . 'MysqliBuilder/queryBuilder.php';
require_once APP_PATH . 'Model.php';
require_once APP_PATH . 'Session.php';
session_name("websystem");
Session::initSession();
try
{
	Bootstrap::run();
}
catch(Exception $e)
{
    echo $e->getMessage();
}
?>