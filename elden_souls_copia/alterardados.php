<?php require_once 'cabecalho.php';
require_once 'menu.php';

if (isset($_COOKIE['cliente'])){
	if (!isset($_POST['botao'])) {
		
	require_once 'persistence/ClientePA.php';
	$clientepa=new ClientePA();

	$consulta=$clientepa->buscar($_COOKIE['cliente'],"cod_cli");
	if (!$consulta) {
		echo "<h2>Dados não encontrado! <a href='alterardados.php'> Tente novamente</a></h2>";
	}else{
		require_once 'model/Cliente.php';
		$cliente=new Cliente();

		$linha=$consulta->fetch_assoc();
		$cliente->setCodCli($linha['cod_cli']);
		$cliente->setEndereco($linha['endereco']);
		$cliente->setTelefone($linha['telefone']);
?>
<form action="alterardados.php" method="POST" id="form">
	<div id="loader" style="display:none;">
		<img src="img/loader.gif">
	</div>
	<h1>Alterar Dados </h1>
	<p>Endereço:</p>
	<p><input type="text" name="endereco" size="50" maxlength="50" pattern="[0-9a-zA-Z\s-,.s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{3,50}"value="<?=$cliente->getEndereco() ?>" required ></p>
	<p>Telefone:</p>
	<p><input type="text" name="telefone" size="20" maxlength="20" pattern="\([0-9]{2}\)[0-9]{4,5}-[0-9]{4}" id="telefone" value="<?=$cliente->getTelefone() ?>" required></p>
	<br>
	<input type="hidden" name="cod_cli" value="<?= $cliente->getCodCli() ?>">
	<p><input type="submit" name="botao" value="Alterar"></p>
</form>
<script src="js/loader.js"></script>
<?php
	}
 }else{
	require_once 'model/Cliente.php';
	require_once 'persistence/ClientePA.php';
	$cliente=new cliente();
	$clientepa=new ClientePA();

	$cliente->setCodCli($_POST['cod_cli']);
	$cliente->setEndereco($_POST['endereco']);
	$cliente->setTelefone($_POST['telefone']);

		if ($clientepa->alterarDados($cliente)) {
			echo "<h2>Dados alterado com sucesso</h2>";
		}else{
			echo "<h2> Erro na tentaiva de alterar!<a href='alterardados.php?termo=".$cliente->getCodCli()."&campo=cod_cli&botao=Alterar'> Tente novamente!</a></h2>";
		}
		echo "<meta http-equiv='refresh' content='2;url=alterardados.php'>";
}		
}else{
	header('location:index.php');
}
?>

</body>
</html>