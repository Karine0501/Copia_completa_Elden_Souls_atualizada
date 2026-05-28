<?php

class Livro{
	private $cod_liv;
	private $quantidade;
	private $foto;
	private $estado;
	private $genero;
	private $autor;
	private $descricao;
	private $editora;
	private $data_publi;
	private $v_venda;
	private $v_compra;
	private $titulo;

	public function SetCodLiv($cod_liv)
	{
		$this->cod_liv=$cod_liv;
	}
	public function getCodLiv()
	{
		return $this->cod_liv;
	}
	public function setQuantidade($quantidade)
	{
		$this->quantidade=$quantidade;
	}

	public function getQuantidade()
	{
		return $this->quantidade;
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
	public function setGenero($genero)
	{
		$this->genero=$genero;
	}
	public function getGenero()
	{
		return $this->genero;
	}
	public function setAutor($autor)
	{
		$this->autor=$autor;
	}
	public function getAutor()
	{
		return $this->autor;
	}
	public function setDescricao($descricao)
	{
		$this->descricao=$descricao;
	}

	public function getDescricao()
	{
		return $this->descricao;
	}
	public function setEditora($editora)
	{
		$this->editora=$editora;
	}
	public function getEditora()
	{
		return $this->editora;
	}
	public function setDataPubli($data_publi)
	{
		$this->data_publi=$data_publi;
	}
	public function getDataPubli()
	{
		return $this->data_publi;
	}
	public function setVVenda($v_venda)
	{
		$this->v_venda=$v_venda;
	}
	public function getVVenda()
	{
		return $this->v_venda;
	}
	public function setVCompra($v_compra)
	{
		$this->v_compra=$v_compra;
	}
	public function getVCompra()
	{
		return $this->v_compra;
	}
	public function setTitulo($titulo)
	{
		$this->titulo=$titulo;
	}
	public function getTitulo()
	{
		return $this->titulo;
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

	public function converterBrasileira($data)
	{
		$nova_data=DateTime::createFromFormat('Y-m-d',$data);
		return $nova_data->format('d/m/Y');
	}

	public function converterAmericana($data)
	{
		$data_ame=DateTime::createFromFormat('d/m/Y',$data);
		if (!$data_ame) {
			return false;
		}else{
			return $data_ame->format('Y-m-d');
		}
	}

	public static function minimo()
	{
		$data=DateTime::createFromFormat('Y-m-d',date('Y-m-d'));
		return $data->modify("-50 years")->format('Y-m-d');
	}


}



?>