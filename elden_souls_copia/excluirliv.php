<?php
	require_once 'cabecalho.php';
	require_once 'menu.php';

	if (isset($_COOKIE['administrador'])||isset($_COOKIE['cliente'])){

	if (isset($_GET['cod_liv'])) {
	require_once 'persistence/LivroPA.php';
	require_once 'model/Livro.php';
	$livro=new Livro();
	$livropa=new LivroPA();
	$livro->setCodLiv($_GET['cod_liv']); 
	$consulta=$livropa->buscar($livro->getCodliv(),'cod_liv',$livro);
	if (!$consulta) {
		echo "<h2>Livro não encontrado! <a href='buscarliv.php'>Volte</a>!</h2>";
	}else{
		$linha=$consulta->fetch_assoc();
		$livro->setTitulo($linha['titulo']);
?>
<form action="excluirliv.php" method="POST" id="form">
	<div id="loader" style="display: none;">
		<img src="img/loader.gif">
	</div>
	<h1>Excluir Livro</h1>
	<p>Tem certeza que deseja excluir o :</p>
	<p><big><b><?= $livro->getTitulo() ?></b></big></p>
	<input type="hidden" name="cod_liv" value="<?= $livro->getCodLiv() ?>">
	<p><input type="submit" name="botao" value="sim">
	<button><a href="buscarliv.php?termo=<?= $livro->getCodLiv() ?>&campo=cod_liv&botao=Buscar">Não</a></button></p>
</form>
<script src="js/loader.js"></script>


<?php
	}
}else if(isset($_POST['botao'])){
	require_once 'persistence/LivroPA.php';
	$livropa=new livroPA();
	if ($livropa->excluir($_POST['cod_liv'])) {
		echo "<h2>Livro excluido com sucesso!</h2>";
	}else{
		echo "<h2>Erro na tentativa de excluir! Tente <a href='buscarliv.php?termo=",$_POST['cod_liv']."&campo=cod_liv&botao=Buscar'>novamente</a>!</h2>";
		}
}
?>
<div id="btn-area">
    <a href="buscarliv.php" id="btn-voltar">Voltar</a>
</div>
<?php
}else{
	header('location: index.php');
}
?>
</body>
</html>