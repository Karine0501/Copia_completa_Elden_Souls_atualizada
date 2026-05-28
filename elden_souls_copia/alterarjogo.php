<?php require_once 'cabecalho.php'; require_once 'menu.php';


if (isset($_COOKIE['administrador'])||isset($_COOKIE['cliente'])){

if (isset($_GET['cod_jogo'])) {
	require_once 'persistence/JogoPA.php';
	$jogopa=new JogoPA();
	require_once 'model/Jogo.php';
	$jogo=new Jogo();
	$consulta=$jogopa->buscar($_GET['cod_jogo'],'cod_jogo',$jogo);
	if (!$consulta) {
		echo "<h2>Jogo não encontrado! <a href='buscarjogo.php'>Volte</a></h2>";
	}else{
		$linha=$consulta->fetch_assoc();
		$jogo->setCodJogo($linha['cod_jogo']);
		$jogo->setNome($linha['nome']);
		$jogo->setConsole($linha['console']);
		$jogo->setGenero($linha['genero']);
		$jogo->setDesenvolvedora($linha['desenvolvedora']);
		$jogo->setEstado($linha['estado']);
		$jogo->setQuantidade($linha['quantidade']);
		$jogo->setVCompra($linha['v_compra']);
		$jogo->setVVenda($linha['v_venda']);
		$jogo->setDescricao($linha['descricao']);
		$jogo->setFoto($linha['foto']);
?>

<form action="alterarjogo.php" method="POST" id="form" enctype="multipart/form-data">
	<div id="loader" style="display:none;">
		<img src="img/loader.gif">
	</div>
	<h1>Alterar Jogos</h1>
	<input type="hidden" name="cod_jogo" value="<?= $jogo->getCodJogo() ?>">
	<p>Nome:</p>
	<input type="text" name="nome" size="70" maxlength="70" pattern="[0-9a-zA-Z\s-,.s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{2,70}" value="<?= $jogo->getNome() ?>" required>
	<p>Console:</p>
	<input type="text" name="console" size="20" maxlength="20" pattern="[0-9a-zA-Z\s-,.s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{2,30}" value="<?= $jogo->getConsole() ?>" required>
	<p>Genero:</p>
	<input type="text" name="genero" size="20" maxlength="20" pattern="[0-9a-zA-Z\/\s-,.s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{3,20}" value="<?= $jogo->getGenero() ?>" required>
	<p>Desenvolvedora:</p>
	<input type="text" name="desenvolvedora" size="50" maxlength="50" pattern="[0-9a-zA-Z\s-,.s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{3,50}" value="<?= $jogo->getDesenvolvedora() ?>" required>
	<p>Estado:</p>
	<input type="text" name="estado" size="20" maxlength="20" pattern="[0-9a-zA-Z\s-,.s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{4,20}" value="<?= $jogo->getGenero() ?>" required>
	<p>Quantidade:</p>
	<input type="number" name="quantidade" min="1" max="9999" value="<?= $jogo->getQuantidade() ?>" required>
	<p>Valor Compra:</p>
	<input type="number" name="v_compra" min="0.01" max="9999.99" step="0.01" value="<?= $jogo->getVCompra() ?>" required>
	<p>Valor Venda:</p>
	<input type="number" name="v_venda" min="0.01" max="9999.99" step="0.01" value="<?= $jogo->getVVenda() ?>" required>
	<p>Descrição:</p>
	<p><textarea name="descricao" cols="60" rows="4" maxlength="240"  required><?= $jogo->getDescricao() ?></textarea></p>
	<p>Foto Atual:</p>
	<img src="data:image/jpg;base64, <?= base64_encode($jogo->getFoto())?>">
	<p>Escolher outra?</p>
	<p><input type="file" name="foto" accept=".jpg,.jpeg,.gif,.png,.bmp"></p>
	<p>Fabricante:</p>

<p><input type="submit" name="botao" value="Alterar"></p>

	
</form>
<script src="js/loader.js"></script>

<?php
	}
}else if (isset($_POST['botao'])) {
		require_once 'persistence/JogoPA.php';
		require_once 'model/Jogo.php';
		$jogopa=new JogoPA();
		$jogo=new Jogo();

		if (isset($_FILES['foto'])&&$_FILES['foto']['tmp_name']!="") {
			$jogo->setFoto($_FILES['foto']['tmp_name']);
			if ($jogo->verificarTamanho($jogo->getFoto())) {
				$jogo->criarImagem();
				$flag=true;
			}else{
				echo "<h2>Imagem muito grande! Max. ¨65Kb!</h2>";
				$flag=false;
			}
		}else{
			$jogo->setFoto(addslashes($jogopa->retornarImagem($_POST['cod_jogo'])));
			$flag=true;
		}
		if ($flag) {
			$jogo->setCodJogo($_POST['cod_jogo']);
			$jogo->setNome($_POST['nome']);
			$jogo->setConsole($_POST['console']);
			$jogo->setGenero($_POST['genero']);
			$jogo->setDesenvolvedora($_POST['desenvolvedora']);
			$jogo->setEstado($_POST['estado']);			
			$jogo->setQuantidade($_POST['quantidade']);
			$jogo->setVCompra($_POST['v_compra']);
			$jogo->setVVenda($_POST['v_venda']);
			$jogo->setDescricao($_POST['descricao']);

			if ($jogopa->alterar($jogo)) {
				echo "<h2>Jogo alterado com sucesso!!!</h2>";
			}else{
				echo "<h2>Erro na tentativa de alterar! Tente <a href='buscarjogo.php?termo=".$jogo->getCodJogo()."&campo=cod_jogo&botao=Buscar'>novamente</a>!</h2>";
			}
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