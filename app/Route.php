<?php
/*Principal Controller (Could be use for no secure reasons)*/
Router::get('principal');
Router::get('principal/login');
Router::post('principal/login',function()
{
	Authentication::Login();
});
/*Error Controler (Could be use for customs errors pages*/
Router::get('error');
Router::get('error/error403');
Router::get('error/error404');
?>