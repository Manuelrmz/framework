<?php
class principalController extends Controller
{
	public function __construct() 
    {
        parent::__construct();
    }
	public function index()
	{
		Authentication::CheckPermission('admin','principal');
		View::Render('principal/index',['name'=>'hola prueba'],array('route'=>'layout/index'));
	}
	public function login()
	{
		View::Render('principal/login');
	}
}
?>