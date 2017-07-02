<?php
class Authentication
{
	public static function CheckPermission($username,$module)
	{
		Session::securitySession();
		$userAuth = self::getAccess($username);
		if(isset($userAuth[$module]))
		{
			if($userAuth[$module])
				return true;
			self::Redirect("error/error403");
		}
		self::Redirect("error/error403");
	}
	public static function Login()
	{
		$userFound = false;
		if(isset($_POST["username"]) && isset($_POST["password"]))
		{
			$user = users::select(array('users.*','ma.access'))->join(array('moduleaccess','ma'),'users.username','=','ma.username')->where('users.username',$_POST["username"])->get()->fetch_assoc();
			if($user)
			{
				if($user["access"])
				{
					if($user["password"] == $_POST["password"])
					{
						users::where('username',$_POST["username"])->update(array('lastaccess'=>date('Y-m-d H:m:s')));
						$user["lastaccess"] = date('Y-m-d H:m:s');
						$_SESSION["userdata"] = $user;
						$userFound = true;
					}
				}
			}
		}
		if($userFound)
			self::Redirect('principal');
		else
		{
			$_SESSION["loginError"] = "Usuario o contraseña incorrectos";
			self::Redirect('principal/login');
		}
	}
	public static function Logout($username,$page)
	{
		Session::destroySession();
		self::Redirect($page);
	}
	public static function Redirect($page)
	{
		Header('Location: /'.BASE_DIR.DS.$page);
	}
	public static function getAccess($username)
	{
		return $userAuth = users::select(array('ma.*'))->join(array('moduleaccess','ma'),'users.username','=','ma.username')->where('users.username',$username)->get()->fetch_assoc();
	}
}
?>