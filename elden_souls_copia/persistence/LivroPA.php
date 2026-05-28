<?php

require_once 'Banco.php';

class LivroPA{

    private $con;

    public function __construct()
    {
        $this->con=new Banco();
    }

    public function cadastrar($livro)
    {
        $sql="INSERT INTO livro(titulo,autor,genero,editora,data_publi,estado,quantidade,v_compra,v_venda,descricao,foto) 
        VALUES('".
            $livro->getTitulo()."','".
            $livro->getAutor()."','".
            $livro->getGenero()."','".
            $livro->getEditora()."','".
            $livro->getDataPubli()."','".
            $livro->getEstado()."',".
            $livro->getQuantidade().",".
            $livro->getVCompra().",".
            $livro->getVVenda().",'".
            $livro->getDescricao()."','".
            $livro->getFoto()."')";
            
        $resposta=$this->con->executar($sql);
        $this->con->desconectar();
        return $resposta;    
    }

    public function retornarUltimo()
    {
        $sql="SELECT MAX(cod_liv) AS 'ultimo' FROM livro";
        $consulta=$this->con->consultar($sql);
        $linha=$consulta->fetch_assoc();
        if ($linha['ultimo']!=NULL) {
            return $linha['ultimo']+1;
        }else{
            return 1;
        }
    }

    public function listar($limite, $offset, $apenasEmEstoque = false)
    {
        $sql = "SELECT * FROM livro";
        if ($apenasEmEstoque) {
            $sql .= " WHERE quantidade > 0";
        }
        $sql .= " ORDER BY cod_liv LIMIT $limite OFFSET $offset";
        $consulta = $this->con->consultar($sql);
        $this->con->desconectar();
        return $consulta;
    }

    public function contar()
    {
        $sql="SELECT COUNT(cod_liv) AS 'total' FROM livro";
        $consulta=$this->con->consultar($sql);
        $linha=$consulta->fetch_assoc();
        return $linha['total'];
    }

    public function buscar($termo, $campo, $apenasEmEstoque = false)
    {
        if($campo!=''){
            $sql = "SELECT * FROM livro WHERE $campo LIKE '%$termo%'";
        } else {
            $sql = "SELECT * FROM livro
                    WHERE (cod_liv='$termo' 
                       OR titulo LIKE '%$termo%' 
                       OR autor LIKE '%$termo%' 
                       OR genero LIKE '%$termo%' 
                       OR editora LIKE '%$termo%'
                       OR data_publi LIKE '%$termo%'
                       OR estado LIKE '%$termo%'
                       OR quantidade LIKE '%$termo%'
                       OR v_compra LIKE '%$termo%'
                       OR v_venda LIKE '%$termo%'
                       OR descricao LIKE '%$termo%')";
        }
        if ($apenasEmEstoque) {
            $sql .= " AND quantidade > 0";
        }
        $consulta = $this->con->consultar($sql);
        $this->con->desconectar();
        return ($consulta->num_rows > 0) ? $consulta : false;
    }

    public function alterar($livro)
    {
        $sql="UPDATE livro SET titulo='".$livro->getTitulo()."', autor='".$livro->getAutor()."', genero='".$livro->getGenero()."', editora='".$livro->getEditora()."', data_publi='".$livro->getDataPubli()."', estado='".$livro->getEstado()."', quantidade=".$livro->getQuantidade().", v_compra=".$livro->getVCompra().", v_venda=".$livro->getVVenda().", descricao='".$livro->getDescricao()."', foto='".$livro->getFoto()."' WHERE cod_liv=".$livro->getCodLiv();
        $resposta=$this->con->executar($sql);
        $this->con->desconectar();
        return $resposta;
    }

    public function excluir($cod_liv)
    {
        $sql="DELETE FROM livro WHERE cod_liv=$cod_liv";
        if($this->con->executar($sql)){
            $sql="DELETE FROM livro WHERE cod_liv=$cod_liv";
            if ($this->con->executar($sql)) {
                $this->con->desconectar();
                return true;
            } else {
                $this->con->desconectar();
                return "livro";
            }
        }
    }

    public function listarTitulo()
    {
        $sql="SELECT cod_liv,titulo FROM livro";
        $consulta=$this->con->consultar($sql);
        $this->con->desconectar();
        return $consulta;
    }

    public function retornarImagem($cod_liv)
    {
        $sql="SELECT foto FROM livro WHERE cod_liv=$cod_liv";
        $consulta=$this->con->consultar($sql);
        $linha=$consulta->fetch_assoc();
        return $linha['foto'];
    }
}
?>