<?php
class errorController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		view::Render('error/index');
	}
	public function error403()
	{
		View::Render('error/error403',array(),array('route'=>'layout/index',"Error 403 - Forbidden"));
	}
}
?>