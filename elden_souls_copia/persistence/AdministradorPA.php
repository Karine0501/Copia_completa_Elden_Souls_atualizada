<?php

require_once 'Banco.php';
 
 class AdministradorPA{
	 	private $con;

	 	public function __construct()
	 	{
	 		$this->con=new Banco();
	 	}

	 	public function logar($login,$senha)
	 	{
	 		$sql="SELECT cod_adm,nome,login,senha FROM
	 		admin WHERE login='$login'"; 
			$consulta=$this->con->consultar($sql);
	 		if(!$consulta){
	 			return false;
	 	}else{
	 		$linha=$consulta->fetch_assoc();
	 		if(password_verify($senha,$linha['senha'])){
	 			$this->con->desconectar();
	 			return $linha['cod_adm'];
	 		}else{
	 			$this->con->desconectar();
	 			return false;
	 		}
	 	}
	 }

	 public function alterarSenha($nova_senha,$cod_adm)
	 {
	 	$sql="UPDATE admin SET senha='$nova_senha'
	 	WHERE cod_adm=$cod_adm";
	 	$resposta=$this->con->executar($sql);
	 	$this->con->desconectar();
	 	return $resposta;
	 }

	 public function verificarSenha($cod_adm,$senha)
	 {
	 	$sql="SELECT senha FROM admin
	 	WHERE cod_adm=$cod_adm";
	 	$consulta=$this->con->consultar($sql);
	 	if(!$consulta){
	 		return false;
	 	}else{
	 		$linha=$consulta->fetch_assoc();
	 		if (password_verify($senha,$linha['senha'])) {
	 			return true;
	 		}else{
	 			return false;
	 		}
	 	}
	 }

}

?>