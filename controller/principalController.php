<?php
class principalController extends Controller
{
	public function __construct() 
    {
        parent::__construct();
    }
	public function index()
	{
		Session::regenerateId();
		$this->_view->renderizar('index','Titulo Nuevo');
	}
	public function login()
	{
		
	}
}
?>