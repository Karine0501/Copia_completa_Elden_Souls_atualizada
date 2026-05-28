<?php
class Musica{
    private $cod_mu;
    private $titulo;
    private $artista;
    private $genero;
    private $formato;
    private $foto;
    private $estado;
    private $quantidade;
    private $v_compra;
    private $v_venda;


    public function setCodMu($cod_mu)
    {
        $this->cod_mu=$cod_mu;
    }
    public function getCodMu()
    {
        return $this->cod_mu;
    }


    public function setTitulo($titulo)
    {
        $this->titulo=$titulo;
    }
    public function getTitulo()
    {
        return $this->titulo;
    }


    public function setArtista($artista)
    {
        $this->artista=$artista;
    }
    public function getArtista()
    {
        return $this->artista;
    }


    public function setGenero($genero)
    {
        $this->genero=$genero;
    }
    public function getGenero()
    {
        return $this->genero;
    }


    public function setFormato($formato)
    {
        $this->formato=$formato;
    }
    public function getFormato()
    {
        return $this->formato;
    }


    public function setFoto($foto)
    {
        $this->foto=$foto;
    }
    public function getFoto()
    {
        return $this->foto;
    }


    public function setEstado($estado)
    {
        $this->estado=$estado;
    }
    public function getEstado()
    {
        return $this->estado;
    }


    public function setQuantidade($quantidade)
    {
        $this->quantidade=$quantidade;
    }
    public function getQuantidade()
    {
        return $this->quantidade;
    }


    public function setVCompra($v_compra)
    {
        $this->v_compra=$v_compra;
    }
    public function getVCompra()
    {
        return $this->v_compra;
    }


    public function setVVenda($v_venda)
    {
        $this->v_venda=$v_venda;
    }
    public function getVVenda()
    {
        return $this->v_venda;
    }
    
    public function verificarTamanho($foto)
    {
        if (filesize($foto)>65530) {
            return false;
        }else{
            return true;
        }
    }   
    public function criarImagem()
    {
        $this->foto=addslashes(file_get_contents($this->foto));
    }


}

?>