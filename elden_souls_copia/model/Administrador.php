<?php

class Administrador {

	private $cod_adm;
	private $senha;
	private $nome;
	private $login;

	public function setCodAdm($cod_adm)
	{
		$this->cod_adm=$cod_adm;
	}

	public function getCodAdm()
	{
		return $this->cod_adm;
	}

	public function setSenha($senha)
	{
		$this->senha=$senha;
	}

	public function getSenha()
	{
		return $this->senha;
	}



	public function setNome($nome)
	{
		$this->nome=$nome;
	}

	public function getNome()
	{
		return $this->nome;
	}


	public function setLogin($login)
	{
		$this->login=$login;
	}

	public function getLogin()
	{
		return $this->login;
	}

	public function logar($cod_adm,$nivel)
	{
		setcookie("administrador",$cod_adm,time()+86400);
	}

	public function deslogar()
	{
		setcookie("administrador","");
	}

	public function criptografarSenha()
	{
		$this->senha=password_hash($this->senha, PASSWORD_DEFAULT);
	}

}

?>