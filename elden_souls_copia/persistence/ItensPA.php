<?php

require_once 'Banco.php';

class ItensPA {

    private $con;

    public function __construct()
    {
        $this->con=new Banco();
    }

    public function cadastrar($itens)
    {
        $sql = "INSERT INTO Itens
        (cod_ped, cod_produto, quantidade, tipo, valor)
        VALUES (
        " . $itens->getCodPed() . ",
        " . $itens->getCodProduto() . ",
        " . $itens->getQuantidade() . ",
        '" . $itens->getTipo() . "',
        " . $itens->getValor() . "
        )";

        $resposta=$this->con->executar($sql);
        $this->con->desconectar();

        return $resposta;
    }

    public function buscar($termo='',$campo='')
    {
        if ($campo!=''&&$termo!='') {

            $sql="SELECT *
            FROM itens
            WHERE $campo LIKE '%$termo%'";

        } else {

            $sql="SELECT *
            FROM itens";
        }

        $consulta=$this->con->consultar($sql);

        if (!$consulta) {

            $this->con->desconectar();
            return false;

        } else {

            $this->con->desconectar();
            return $consulta;
        }
    }

    public function alterar($itens)
    {
        $sql = "UPDATE Itens SET "
            . "cod_ped = " . $itens->getCodPed() . ", "
            . "cod_produto = " . $itens->getCodProduto() . ", "
            . "quantidade = " . $itens->getQuantidade() . ", "
            . "tipo = '" . $itens->getTipo() . "', "
            . "valor = " . $itens->getValor() . " "
            . "WHERE cod_item = " . $itens->getCodItem();

        $resposta=$this->con->executar($sql);
        $this->con->desconectar();

        return $resposta;
    }

    public function excluir($cod_item)
    {
        $sql="DELETE FROM itens
        WHERE cod_item=$cod_item";

        $resposta=$this->con->executar($sql);
        $this->con->desconectar();

        return $resposta;
    }

    public function contarItens()
    {
        $sql="SELECT COUNT(*) AS total FROM itens";

        $consulta=$this->con->consultar($sql);
        $linha=$consulta->fetch_assoc();

        $this->con->desconectar();

        return $linha['total'];
    }

    public function valorTotal($cod_ped)
    {
        $sql = "
        SELECT SUM(quantidade * valor) AS total
        FROM itens
        WHERE cod_ped = $cod_ped
        ";

        $consulta = $this->con->consultar($sql);
        $linha = $consulta->fetch_assoc();

        $this->con->desconectar();

        return $linha['total'];
    }

    public function listarItensPorPedido($cod_ped)
    {
        $sql = "SELECT * FROM itens 

        WHERE cod_ped=$cod_ped";

        $consulta=$this->con->consultar($sql);
        return $consulta;
    }

    public function converteNome($cod_produto, $tipo)
    {
        if ($tipo == "JOGO") {

            $sql = "
            SELECT nome
            FROM jogo
            WHERE cod_jogo = $cod_produto
            ";

        } else if ($tipo == "LIVRO") {

            $sql = "
            SELECT titulo AS nome
            FROM livro
            WHERE cod_liv = $cod_produto
            ";

        } else if ($tipo == "MUSICA") {

            $sql = "
            SELECT titulo AS nome
            FROM musica
            WHERE cod_mu = $cod_produto
            ";

        } else {

            return "Tipo inválido";
        }

        $consulta = $this->con->consultar($sql);

        if (!$consulta || $consulta->num_rows <= 0) {
            return "Produto não encontrado";
        }

        $linha = $consulta->fetch_assoc();

        return $linha['nome'];
    }
}

?>