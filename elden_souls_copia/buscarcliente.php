<?php require_once 'cabecalho.php'; 
require_once 'menu.php';
if (isset($_COOKIE['administrador'])||isset($_COOKIE['cliente'])){
	
?>

<form action="buscarcliente.php" method="GET" id="form">
	<div id="loader" style="display: none;">
		<img src="img/loader.gif">
	</div>
	<h1>Buscar Cliente</h1>
	<p><input type="search" name="termo" size="30" maxlength="240" pattern="[0-9a-zA-Z\s-,.s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{1,240}" required></p>

		<div class="grupoRadio">
	
	    <label class="radioItem">
	        <input type="radio" name="campo" value="nome">
	        <span>Nome</span>
	    </label>
	
	    <label class="radioItem">
	        <input type="radio" name="campo" value="cpf">
	        <span>CPF</span>
	    </label>
	
	    <label class="radioItem">
	        <input type="radio" name="campo" value="endereco">
	        <span>Endereco</span>
	    </label>
	
	    <label class="radioItem">
	        <input type="radio" name="campo" value="telefone">
	        <span>Telefone</span>
	    </label>
	
	</div>
	<p><input type="submit" name="botao" value="Buscar"></p>

</form>
<?php
if (isset($_GET['botao'])) {
	require_once 'persistence/ClientePA.php';
	$clientepa=new ClientePA();
	require_once 'model/Cliente.php';
	$cliente=new Cliente();
	if (isset($_GET['campo'])&&$_GET['campo']!="") {
		$consulta=$clientepa->buscar($_GET['termo'],$_GET['campo']);
	}else{
		$consulta=$clientepa->buscar($_GET['termo'],"");
	}

	if (!$consulta) {
		echo "<h2>Nenhum resultado correspondente</h2>";
	}else{
		echo "<section class='resultado'>";
		while ($linha=$consulta->fetch_assoc()) {
			$cliente->setCodCli($linha['cod_cli']);
			$cliente->setNome($linha['nome']);
			$cliente->setCpf($linha['cpf']);
			$cliente->setEndereco($linha['endereco']);
			$cliente->setTelefone($linha['telefone']);
			
				echo "
		<div class='cardProduto'>

			<div class='infoProduto'>

				<h1>".$cliente->getNome()."</h1>

				<div class='linhaInfo'>
					<span class='tituloInfo'>C&oacute;digo:</span>
					<span>".$cliente->getCodCli()."</span>
				</div>

				<div class='linhaInfo'>
					<span class='tituloInfo'>Cpf:</span>
					<span>".$cliente->getCpf()."</span>
				</div>

				<div class='linhaInfo'>
					<span class='tituloInfo'>Endereco:</span>
					<span>".$cliente->getEndereco()."</span>
				</div>

				<div class='linhaInfo'>
					<span class='tituloInfo'>Telefone:</span>
					<span>".$cliente->getTelefone()."</span>
				</div>
				</div>";

			echo "

				    
				        <a class='icones' href='alterarcliente.php?cod_cli=".$cliente->getCodCli()."'>
				            <img src='img/edit.png'/>
				        </a>
				        <a class='icones' href='excluircliente.php?cod_cli=".$cliente->getCodCli()."'>
				            <img src='img/lixo.png'/>
				        </a>
				   
				    
			</div>
		</div>
		";

		}
		echo "</section>";
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

