<?php require_once 'cabecalho.php'; require_once 'menu.php';
if (isset($_COOKIE['administrador'])||isset($_COOKIE['cliente'])){

if (isset($_GET['cod_jogo'])) {
	require_once 'persistence/JogoPA.php';
	require_once 'model/Jogo.php';
	$jogo=new Jogo();
	$jogopa=new JogoPA();
	$jogo->setCodJogo($_GET['cod_jogo']);
	$consulta=$jogopa->buscar($jogo->getCodJogo(),'cod_jogo',$jogo);
	if (!$consulta) {
		echo "<h2>Jogo não encontrado! <a href='buscarjogo.php'>Volte</a>!</h2>";
	}else{
		$linha=$consulta->fetch_assoc();
		$jogo->setNome($linha['nome']);
?>
<form action="excluirjogo.php" method="POST" id="form">
	<div id="loader" style="display: none;">
		<img src="img/loader.gif">
	</div>
	<h1>Excluir Jogo</h1>
	<p>Tem certeza que deseja excluir o :</p>
	<p><big><b><?= $jogo->getNome() ?></b></big></p>
	<input type="hidden" name="cod_jogo" value="<?= $jogo->getCodJogo() ?>">
	<p><input type="submit" name="botao" value="sim">
	<button><a href="buscarjogo.php?termo=<?= $jogo->getCodJogo() ?>&campo=cod_jogo&botao=Buscar">Não</a></button></p>
</form>
<script src="js/loader.js"></script>


<?php
	}
}else if(isset($_POST['botao'])){
	require_once 'persistence/JogoPA.php';
	$jogopa=new JogoPA();
	if ($jogopa->excluir($_POST['cod_jogo'])) {
		echo "<h2>Jogo excluido com sucesso!</h2>";
	}else{
		echo "<h2>Erro na tentativa de excluir! Tente <a href='buscarjogo.php?termo=",$_POST['cod_jogo']."&campo=cod_jogo&botao=Buscar'>novamente</a>!</h2>";
	}
}
?>
<script src="js/loader.js"></script>
<?php
}else{
	header('location: index.php');
}
?>
<div id="btn-area">
    <a href="buscarjogo.php" id="btn-voltar">Voltar</a>
</div>
</body>
</html>