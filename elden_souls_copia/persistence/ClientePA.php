<?php

require_once 'Banco.php';

class ClientePA{

    private $con;

    public function __construct()
    {
        $this->con=new Banco();
    }

    public function logar($login,$senha)
    {
        $sql="SELECT cod_cli,login,senha FROM cliente WHERE login='$login'";
        $consulta=$this->con->consultar($sql);

        if(!$consulta){
            return false;
        }

        $linha=$consulta->fetch_assoc();

        if(password_verify($senha,$linha['senha'])){
            $this->con->desconectar();
            return $linha['cod_cli'];
        }

        $this->con->desconectar();
        return false;
    }

    public function cadastrar($cliente)
    {
        $sql = "INSERT INTO cliente(cpf,nome,endereco,telefone,login,senha)
        VALUES(
            '".$cliente->getCpf()."',
            '".$cliente->getNome()."',
            '".$cliente->getEndereco()."',
            '".$cliente->getTelefone()."',
            '".$cliente->getLogin()."',
            '".$cliente->getSenha()."'
        )";

        $resposta=$this->con->executar($sql);
        $this->con->desconectar();

        return $resposta;
    }

    public function verificarCpf($cpf)
    {
        $sql="SELECT cpf FROM cliente WHERE cpf='$cpf'";
        $consulta=$this->con->consultar($sql);

        return ($consulta->num_rows==0);
    }

    public function listar($limite,$offset)
    {
        $sql="SELECT * FROM cliente ORDER BY cod_cli LIMIT $limite OFFSET $offset";
        $consulta=$this->con->consultar($sql);
        $this->con->desconectar();

        return ($consulta->num_rows > 0) ? $consulta : false;
    }

    public function contar()
    {
        $sql="SELECT COUNT(cod_cli) AS total FROM cliente";
        $consulta=$this->con->consultar($sql);
        $linha=$consulta->fetch_assoc();

        return $linha['total'];
    }

    public function buscar($termo,$campo)
    {
        if($campo!=''){
            $sql="SELECT * FROM cliente WHERE $campo LIKE '%$termo%'";
        }else{
            $sql="SELECT * FROM cliente
            WHERE cod_cli='$termo'
            OR nome LIKE '%$termo%'
            OR cpf LIKE '%$termo%'
            OR endereco LIKE '%$termo%'
            OR telefone LIKE '%$termo%'";
        }

        $consulta=$this->con->consultar($sql);
        $this->con->desconectar();

        return ($consulta->num_rows > 0)?$consulta : false;
    }

    public function alterar($cliente)
    {
        $sql="UPDATE cliente SET
        cpf='".$cliente->getCpf()."',
        nome='".$cliente->getNome()."',
        endereco='".$cliente->getEndereco()."',
        telefone='".$cliente->getTelefone()."'
        WHERE cod_cli=".$cliente->getCodCli();

        $resposta=$this->con->executar($sql);
        $this->con->desconectar();

        return $resposta;
    }

     public function alterarDados($cliente)
    {
        $sql="UPDATE cliente SET endereco='".
        $cliente->getEndereco()."',telefone='".
        $cliente->getTelefone()."'WHERE cod_cli=".
        $cliente->getCodCli();
        $resposta=$this->con->executar($sql);
        $this->con->desconectar();

        return $resposta;

       
    }

    public function excluir($cod_cli)
    {
        $sql="DELETE FROM cliente WHERE cod_cli=$cod_cli";
        $resposta=$this->con->executar($sql);
        $this->con->desconectar();

        return $resposta;
    }

    public function listarClientes()
    {
        $sql="SELECT cod_cli, nome FROM cliente";
        $consulta=$this->con->consultar($sql);
        $this->con->desconectar();

        return $consulta;
    }

    public function verificarSenha($cod_cli,$senha)
    {
        $sql="SELECT senha FROM cliente WHERE cod_cli=$cod_cli";
        $consulta=$this->con->consultar($sql);

        if(!$consulta){
            return false;
        }

        $linha=$consulta->fetch_assoc();

        return password_verify($senha,$linha['senha']);
    }

    public function alterarSenha($nova_senha,$cod_cli)
    {
        $sql="UPDATE cliente SET senha='$nova_senha' WHERE cod_cli=$cod_cli";
        $resposta=$this->con->executar($sql);
        $this->con->desconectar();

        return $resposta;
    }
}
?>