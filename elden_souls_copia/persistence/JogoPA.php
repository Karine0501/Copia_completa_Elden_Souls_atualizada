<?php 

require_once 'Banco.php';

class JogoPA{

    private $con;
    public function __construct(){
        $this->con= new Banco();			
    }

    public function cadastrar($jogo)
    {
        $sql="INSERT INTO jogo(nome,console,genero,desenvolvedora,estado,quantidade,v_compra,v_venda,descricao,foto) VALUES('".
        $jogo->getNome()."','".
        $jogo->getConsole()."','".
        $jogo->getGenero()."','".
        $jogo->getDesenvolvedora()."','".
        $jogo->getEstado()."',".
        $jogo->getQuantidade().",".
        $jogo->getVCompra().",".
        $jogo->getVVenda().",'".
        $jogo->getDescricao()."','".
        $jogo->getFoto()."')";
        $resposta=$this->con->executar($sql);
        $this->con->desconectar();
        return $resposta;
    }

    public function listar($limite, $offset, $apenasEmEstoque = false)
    {
        $sql = "SELECT cod_jogo,nome,console,genero,desenvolvedora,estado,quantidade,v_compra,v_venda,descricao,foto 
                FROM jogo";
        if ($apenasEmEstoque) {
            $sql .= " WHERE quantidade > 0";
        }
        $sql .= " ORDER BY cod_jogo LIMIT $limite OFFSET $offset";
        $consulta = $this->con->consultar($sql);
        $this->con->desconectar();
        return $consulta;
    }

    public function contar()
    {
        $sql="SELECT COUNT(cod_jogo) AS 'total' FROM jogo";
        $consulta=$this->con->consultar($sql);
        $linha=$consulta->fetch_assoc();
        return $linha['total'];
    }

    public function buscar($termo, $campo, $jogo, $apenasEmEstoque = false)
    {
        if ($campo != "") {
            $sql = "SELECT cod_jogo,nome,console,genero,desenvolvedora,estado,quantidade,v_compra,v_venda,descricao,foto 
                    FROM jogo 
                    WHERE $campo LIKE '%$termo%'";
        } else {
            $sql = "SELECT cod_jogo,nome,console,genero,desenvolvedora,estado,quantidade,v_compra,v_venda,descricao,foto 
                    FROM jogo 
                    WHERE (cod_jogo='$termo' 
                       OR nome LIKE '%$termo%' 
                       OR console LIKE '%$termo%' 
                       OR genero LIKE '%$termo%' 
                       OR desenvolvedora LIKE '%$termo%' 
                       OR estado LIKE '%$termo%' 
                       OR quantidade LIKE '%$termo%' 
                       OR v_compra LIKE '%$termo%' 
                       OR v_venda LIKE '%$termo%' 
                       OR descricao LIKE '%$termo%')";
        }
        if ($apenasEmEstoque) {
            $sql .= " AND quantidade > 0";
        }
        $sql .= " ORDER BY cod_jogo";
        $consulta = $this->con->consultar($sql);
        $this->con->desconectar();
        return ($consulta->num_rows > 0) ? $consulta : false;
    }


    public function alterar($jogo)
    {
        $sql="UPDATE jogo SET nome='".
        $jogo->getNome()."', console='".
        $jogo->getConsole()."', genero='".
        $jogo->getGenero()."', desenvolvedora='".
        $jogo->getDesenvolvedora()."', estado='".
        $jogo->getEstado()."', quantidade=".
        $jogo->getQuantidade().", v_compra=".
        $jogo->getVCompra().", v_venda=".
        $jogo->getVVenda().", descricao='".
        $jogo->getDescricao()."', foto='".
        $jogo->getFoto()."' WHERE cod_jogo=".
        $jogo->getCodJogo();
        $resposta=$this->con->executar($sql);
        $this->con->desconectar();
        return $resposta;
    }

    public function retornarImagem($cod_jogo)
    {
        $sql="SELECT foto FROM jogo WHERE cod_jogo=$cod_jogo";
        $consulta=$this->con->consultar($sql);
        $linha=$consulta->fetch_assoc();
        return $linha['foto'];
    }

    public function excluir($cod_jogo)
    {
        $sql="DELETE FROM jogo WHERE cod_jogo=$cod_jogo";
        $resposta=$this->con->executar($sql);
        $this->con->desconectar();
        return $resposta;
    }
}

?>