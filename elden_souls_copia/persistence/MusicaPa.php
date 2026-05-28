<?php

require_once 'Banco.php';

class MusicaPA{

    private $con;
    public function __construct(){
        $this->con=new Banco();
    }
    
    public function cadastrar($musica)
    {
        $sql="INSERT INTO musica(titulo,artista,genero,formato,estado,quantidade,v_compra,v_venda,foto) 
        VALUES('".
            $musica->getTitulo()."','".
            $musica->getArtista()."','".
            $musica->getGenero()."','".
            $musica->getFormato()."','".
            $musica->getEstado()."',".
            $musica->getQuantidade().",".
            $musica->getVCompra().",".
            $musica->getVVenda().",'".
            $musica->getFoto()."')";
            
        $resposta=$this->con->executar($sql);
        $this->con->desconectar();
        return $resposta;    
    }

    public function retornarUltimo()
    {
        $sql="SELECT MAX(cod_mu) AS 'ultimo' FROM musica";
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
        $sql = "SELECT cod_mu,titulo,artista,genero,formato,estado,quantidade,v_compra,v_venda,foto FROM musica";
        if ($apenasEmEstoque) {
            $sql .= " WHERE quantidade > 0";
        }
        $sql .= " ORDER BY cod_mu LIMIT $limite OFFSET $offset";
        $consulta = $this->con->consultar($sql);
        $this->con->desconectar();
        return $consulta;
    }

    public function contar()
    {
        $sql="SELECT COUNT(cod_mu) AS 'total' FROM musica";
        $consulta=$this->con->consultar($sql);
        $linha=$consulta->fetch_assoc();
        return $linha['total'];
    }

    public function buscar($termo, $campo, $apenasEmEstoque = false)
    {
        if ($campo!="") {
            $sql = "SELECT cod_mu,titulo,artista,genero,formato,estado,quantidade,v_compra,v_venda,foto 
                    FROM musica 
                    WHERE $campo LIKE '%$termo%'";
        } else {
            $sql = "SELECT cod_mu,titulo,artista,genero,formato,estado,quantidade,v_compra,v_venda,foto 
                    FROM musica 
                    WHERE (cod_mu='$termo' 
                       OR titulo LIKE '%$termo%' 
                       OR artista LIKE '%$termo%'
                       OR genero LIKE '%$termo%' 
                       OR formato LIKE '%$termo%' 
                       OR estado LIKE '%$termo%' 
                       OR quantidade LIKE '%$termo%' 
                       OR v_compra LIKE '%$termo%' 
                       OR v_venda LIKE '%$termo%')";
        }
        if ($apenasEmEstoque) {
            $sql .= " AND quantidade > 0";
        }
        $sql .= " ORDER BY cod_mu";
        $consulta = $this->con->consultar($sql);
        $this->con->desconectar();
        return ($consulta->num_rows > 0) ? $consulta : false;
    }

    public function alterar($musica)
    {
        $sql="UPDATE musica SET titulo='".$musica->getTitulo()."', artista='".$musica->getArtista()."', genero='".$musica->getGenero()."', formato='".$musica->getFormato()."', estado='".$musica->getEstado()."', quantidade=".$musica->getQuantidade().", v_compra=".$musica->getVCompra().", v_venda=".$musica->getVVenda().", foto='".$musica->getFoto()."' WHERE cod_mu=".$musica->getCodMu();
        $resposta=$this->con->executar($sql);
        $this->con->desconectar();
        return $resposta;
    }

    public function retornarImagem($cod_mu)
    {
        $sql="SELECT foto FROM musica WHERE cod_mu=$cod_mu";
        $consulta=$this->con->consultar($sql);
        $linha=$consulta->fetch_assoc();
        return $linha['foto'];
    }

    public function excluir($cod_mu)
    {
        $sql="DELETE FROM musica WHERE cod_mu=$cod_mu";
        $resposta=$this->con->executar($sql);
        $this->con->desconectar();
        return $resposta;
    }    
}
?>