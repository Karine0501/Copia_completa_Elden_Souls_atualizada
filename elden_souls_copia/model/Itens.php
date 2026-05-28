<?php

class Itens{
	private $cod_item;
	private $cod_ped;
	private $cod_produto;
	private $quantidade;
	private $tipo;
	private $valor;


	public function setCodItem($cod_item)
	{
		$this->cod_item=$cod_item;
	}
	public function getCodItem()
	{
		return $this->cod_item;

	}



	public function setCodPed($cod_ped)
	{
		$this->cod_ped=$cod_ped;
	}
	public function getCodPed()
	{
		return $this->cod_ped;

	}



	public function setCodProduto($cod_produto)
	{
		$this->cod_produto=$cod_produto;
	}
	public function getCodProduto()
	{
		return $this->cod_produto;
	}



	public function setQuantidade($quantidade)
	{
		$this->quantidade=$quantidade;
	}
	public function getQuantidade()
	{
		return $this->quantidade;
	}



	public function setTipo($tipo)
	{
		$this->tipo=$tipo;
	}
	public function getTipo()
	{
		return $this->tipo;

	}



	public function setValor($valor)
	{
		$this->valor=$valor;
	}
	public function getValor()
	{
		return $this->valor;

	}	

}
?>