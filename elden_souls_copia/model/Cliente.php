<?php
class Cliente{

private $cod_cli;
private $cpf;
private $nome;
private $endereco;
private $telefone;
private $cod_adm;
private $login;
private $senha;

public function setCodCli($cod_cli)
{
	$this->cod_cli=$cod_cli;
}
public function getCodCli()
{
	return $this->cod_cli;

}
public function setCpf($cpf)
{
	$this->cpf=$cpf;
}
public function getCpf()
{
	return $this->cpf;
}
public function setNome($nome)
{
	$this->nome=$nome;
}
public function getNome()
{
	return $this->nome;
}

public function setEndereco($endereco)
{
	$this->endereco=$endereco;
}
public function getEndereco()
{
	return $this->endereco;
}

public function setTelefone($telefone)
{
	$this->telefone=$telefone;
}
public function getTelefone()
{
	return $this->telefone;
}
public function setCodAdm($cod_adm)
{
	$this->cod_adm=$cod_adm;
}
public function getCodAdm()
{
	return $this->cod_adm;
}

public function setLogin($login)
	{
		$this->login=$login;
	}
public function getLogin()
	{
		return $this->login;

	}

public function setSenha($senha)
	{
		$this->senha=$senha;
	}
public function getSenha()
	{
		return $this->senha;

	}
public function logar($cod_cli)
	{
		setcookie("cliente",$cod_cli,time()+86400);
	}

public function deslogar(){
		setcookie("cliente","");

	}
public function criptografarSenha()
	{
		$this->senha=password_hash($this->senha, PASSWORD_DEFAULT);
	}
}

?>
