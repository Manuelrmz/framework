<?php
class Authentication
{
	public static function CheckPermission($username,$module)
	{
		$userAuth = self::getAccess($username);
		if(isset($userAuth[$module]))
		{
			if($userAuth[$module])
				return true;
			self::Redirect("error/error403");
		}
		self::Redirect("error/error403");
	}
	public static function Login($username,$password)
	{
		$user = self::getAccess($username);
		if($user)
		{
			if($user["password"] = $password)
			{
				users::where('username',$username)->update(array('lastaccess',date('Y-m-d H:m:s')));
				$user["lastaccess"] = date('Y-m-d H:m:s';
				$_SESSION["userdata"] = $user;
				return true;
			}
		}
		Header('Location: Auth/Login');
	}
	public static function Logout($username,$page)
	{
		Session::destroySession();
		Header('Location: '.$page);
	}
	public static function getAccess($username)
	{
		return $userAuth = users::select(array('ma.*'))->join(array('moduleaccess','ma'),'users.username','=','ma.username')->where('users.username',$username)->get()->fetch_assoc();
	}
	public static function Redirect($page)
	{
		Header('Location: '.$page);
	}
}
?>