<?php

require_once "Banco.php";

class PedidoPA{

	private $con;

	public function __construct()
	{
		$this->con=new Banco();
	}
	public function  cadastrar($pedido)
	{
		$sql = "INSERT INTO Pedido (cod_cli, data_ped, total, status) VALUES (" .
        $pedido->getCodCli() . ", '" .
        $pedido->getDataPed() . "', " .
        $pedido->getTotal() . ", " .
        "'ABERTO')";

	$resposta=$this->con->executar($sql);
	$this->con->desconectar();
	return $resposta;

	}
	public function listar($limite,$offset)
	{
		$sql = "SELECT p.cod_ped, p.data_ped, p.cod_cli, c.nome, p.total, p.status
        FROM cliente c
        JOIN pedido p USING (cod_cli)
        ORDER BY p.cod_ped 
        LIMIT $limite OFFSET $offset";

		$consulta=$this->con->consultar($sql);
		$this->con->desconectar();
		return $consulta;

	}

	public function contar()
	{
		$sql = "SELECT COUNT(cod_ped) AS total FROM pedido";
	    $consulta = $this->con->consultar($sql);
	    $linha = $consulta->fetch_assoc();
	    return $linha['total'];

		}
	public function buscar($termo, $campo, $pedido)
	{
	    if ($campo != "") {

	        if ($campo == "data_ped") {

	            $data_ame = $pedido->converterAmericana($termo);

	            if (!$data_ame) {
	                return false;
	            } else {
	                $sql = "SELECT p.cod_ped, p.data_ped, p.cod_cli, c.nome, p.total, p.status
				        FROM cliente c
				        JOIN pedido p USING (cod_cli)
				        WHERE p.data_ped = '$data_ame'
				        ORDER BY p.cod_ped";
	            }

	        } else if ($campo == "cliente") {

	           		$sql = "SELECT p.cod_ped, p.data_ped, p.cod_cli, c.nome, p.total, p.status
			        FROM cliente c
			        JOIN pedido p USING (cod_cli)
			        WHERE c.nome LIKE '%$termo%'
			        ORDER BY p.cod_ped";

	        } else {

	            $sql = "SELECT p.cod_ped, p.data_ped, p.cod_cli, c.nome, p.total, p.status
			        FROM cliente c
			        JOIN pedido p USING (cod_cli)
			        WHERE p.$campo LIKE '%$termo%'
			        ORDER BY p.cod_ped";
	        }

	    } else {

	        $sql = "SELECT p.cod_ped, p.data_ped, p.cod_cli, c.nome, p.total, p.status
			        FROM cliente c
			        JOIN pedido p USING (cod_cli)
			        WHERE p.cod_ped = $termo
			           OR p.data_ped LIKE '%$termo%'
			           OR p.cod_cli LIKE '%$termo%'
			           OR c.nome LIKE '%$termo%'
			           OR p.total LIKE '%$termo%'
			        ORDER BY p.cod_ped";
	    }

	    $consulta = $this->con->consultar($sql);
	    return $consulta;
	}


	public function alterar($pedido)
	{
	    $sql = "UPDATE pedido SET "
	        . "cod_cli = " . $pedido->getCodCli() . ", "
	        . "data_ped = '" . $pedido->getDataPed() . "', "
	        . "total = " . $pedido->getTotal() . ", "
	        . "status = '" . $pedido->getStatus() . "' "
	        . "WHERE cod_ped = " . $pedido->getCodPed();

	    $resposta = $this->con->executar($sql);
	    $this->con->desconectar();

	    return $resposta;
	}


	public function excluir($cod_ped)
	{
	    $sql = "DELETE FROM itens WHERE cod_ped = $cod_ped";

	    if (!$this->con->executar($sql)) {
	        $this->con->desconectar();
	        return false;
	    }

	    $sql = "DELETE FROM pedido WHERE cod_ped = $cod_ped";

	    if (!$this->con->executar($sql)) {
	        $this->con->desconectar();
	        return false;
	    }

	    $this->con->desconectar();
	    return true;
	}

	public function listarPedido($cod_cli,$limite,$offset)
	{
		$sql = "SELECT * FROM pedido WHERE cod_cli=$cod_cli 
		LIMIT $limite OFFSET $offset";
		
		$consulta=$this->con->consultar($sql);
		return $consulta;
	}
}
?>

