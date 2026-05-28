<?php require_once 'cabecalho.php'; require_once 'menu.php';
require_once 'persistence/JogoPA.php';
$jogopa= new JogoPA();
require_once 'model/Jogo.php';
if (isset($_COOKIE['administrador'])||isset($_COOKIE['cliente'])){
?>

<form action="cadastrarjogo.php#res" method="POST" id="form" enctype="multipart/form-data">
	<div id="loader" style="display:none;">
		<img src="img/loader.gif">
	</div>
	<h1>Cadastro de Jogos</h1>
	<p>Nome:</p>
	<input type="text" name="nome" size="70" maxlength="70" pattern="[0-9a-zA-Z\s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{2,70}"
	title="Somente letras e números e hífen, mín. 2 máx. 70" required>
	<p>Console:</p>
	<input type="text" name="console" size="20" maxlength="20" pattern="[0-9a-zA-Z\s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{3,20}"
	title="Somente letras e números e hífen, mín. 3 máx. 20" required>
	<p>Genero:</p>
	<input type="text" name="genero" size="20" maxlength="20" pattern="[0-9a-zA-Z\/\s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{3,20}"
	title="Somente letras e números e hífen e /, mín. 3 máx. 20" required>
	<p>Desenvolvedora:</p>
	<input type="text" name="desenvolvedora" size="50" maxlength="50" pattern="[0-9a-zA-Z\/\s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{2,50}"
	title="Somente letras e números e hífen e /, mín. 3 máx. 50" required>
	<p>Estado:</p>
	<input type="text" name="estado" size="20" maxlength="20"  pattern="[0-9a-zA-Z\s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{2,20}"
	title="Somente letras e números e hífen, mín. 3 máx. 20" required>
	<p>Quantidade:</p>
	<input type="number" name="quantidade" min="1" max="9999" required>
	<p>Valor Compra:</p>
	<input type="number" name="v_compra" min="0.01" max="9999.99" step="0.01" required>
	<p>Valor Venda:</p>
	<input type="number" name="v_venda" min="0.01" max="9999.99" step="0.01" required>
	<p>Descrição:</p>
	<p><textarea name="descricao" cols="60" rows="4" maxlength="240" required></textarea></p>
	<p>Foto:</p>
	<p><input type="file" name="foto" accept=".jpg,.jpeg,.gif,.png,.bmp" required></p>
    <p><input type="submit" name="botao" value="Cadastrar"></p>

	
</form>
<?php
if (isset($_POST['botao'])) {
	require_once 'model/Jogo.php';
	require_once 'persistence/JogoPA.php';
	$jogo= new Jogo();
	$jogopa=new JogoPA();
	$jogo->setFoto($_FILES['foto']['tmp_name']);
	if (!$jogo->verificarTamanho($jogo->getFoto())) {
		echo "<h2 id='res'>Imagem muito grande! Máx. 65Kb!</h2>";
	}else{
		$jogo->criarImagem();
		$jogo->setNome($_POST['nome']);
		$jogo->setConsole($_POST['console']);
		$jogo->setGenero($_POST['genero']);
		$jogo->setDesenvolvedora($_POST['desenvolvedora']);
		$jogo->setEstado($_POST['estado']);
		$jogo->setQuantidade($_POST['quantidade']);
		$jogo->setVCompra($_POST['v_compra']);
		$jogo->setVVenda($_POST['v_venda']);
		$jogo->setDescricao($_POST['descricao']);
		if ($jogopa->cadastrar($jogo)) {
			echo "<h2 id='res'>Jogo cadastrado com sucesso!</h2>";
		}else{
			echo "<h2 id='res'>Erro na tentativa de cadastrar! Tente novamente!</h2>";
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
</body>
</html>