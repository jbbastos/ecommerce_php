<?php

namespace Hcode\Model;
use \Hcode\DB\Sql;
use \Hcode\Model;

class User extends Model
{
	const SESSION = "User";
	
	public static function login($login, $password)
	{
		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(
			":LOGIN"=>$login
		));
		
		if(count($results) === 0)
		{
			throw new \Exception("Usuário inexistente ou senha inválida.");
		}
		
		$data = $results[0];
		
		if(password_verify($password, $data["despassword"]) === true)
		{
			$user = new User();
			//$user->setiduser($data["iduser"]);
			//var_dump($user);
			//exit;
			$user->setData($data);
			$_SESSION[User::SESSION] = $user->getValues();
			return $user;
		}
		else
		{
			throw new \Exception("Usuário inexistente ou senha inválida.");
		}
		
	}
	
	public static function verifyLogin($inadmin = true)
	{
		if(
			// verifica se existe a sessão
			!isset($_SESSION[User::SESSION]) ||
			// verifica se está vazio
			!$_SESSION[User::SESSION] ||
			// verifica se o id é maior que 0
			!(int)$_SESSION[User::SESSION]["iduser"] > 0 ||
			// verifica se está acessando admin
			(bool)$_SESSION[User::SESSION]["inadmin"] !== $inadmin
		)
		{
			header("Location: /admin/login");
			exit;
		}
		
	}
	
	public static function logout()
	{
		$_SESSION[User::SESSION] = NULL;
	}
}

?>