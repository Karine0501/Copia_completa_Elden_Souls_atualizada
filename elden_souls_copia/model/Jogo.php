<?php 

 class Jogo{

    private $cod_jogo;
    private $nome;
    private $console;
    private $genero;
    private $desenvolvedora;
    private $estado;
    private $quantidade;
    private $v_compra;
    private $v_venda;
    private $descricao;
    private $foto;

 public function setCodJogo($cod_jogo){
    $this->cod_jogo=$cod_jogo;
 }
 public function getCodJogo(){
    return $this->cod_jogo;
 }
 public function setNome($nome){
    $this->nome=$nome;
 }
 public function getNome(){
    return $this->nome;
 }
 public function setConsole($console){
    $this->console=$console;
 }
 public function getConsole(){
    return $this->console;
 }
 public function setGenero($genero){
    $this->genero=$genero;
 }
 public function getGenero(){
    return $this->genero;
 }
 public function setDesenvolvedora($desenvolvedora){
    $this->desenvolvedora=$desenvolvedora;
 } 
 public function getDesenvolvedora(){
    return $this->desenvolvedora;
 }
 public function setEstado($estado){
    $this->estado=$estado;
 }
 public function getEstado(){
    return $this->estado;
 }
 public function setQuantidade($quantidade){
    $this->quantidade=$quantidade;
 }
 public function getQuantidade(){
    return $this->quantidade;
 }
 public function setVCompra($v_compra){
    $this->v_compra=$v_compra;
 }
 public function getVCompra(){
    return $this->v_compra;
 }
 public function setVVenda($v_venda){
    $this->v_venda=$v_venda;
 }
 public function getVVenda(){
    return $this->v_venda;
 }
 public function setDescricao($descricao){
    $this->descricao=$descricao;
 }
 public function getDescricao(){
    return $this->descricao;
 }
 public function setFoto($foto){
    $this->foto=$foto;
 }
 public function getFoto(){
    return $this->foto;
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