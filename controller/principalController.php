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
		Session::securitySession();
		$this->_view->renderizar('index','Title');
	}
}
?>