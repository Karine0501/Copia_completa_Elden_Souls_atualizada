<?php require_once 'cabecalho.php';
require_once 'menu.php';

if (isset($_COOKIE['administrador'])||isset($_COOKIE['cliente'])){

if (isset($_GET['cod_liv'])) {
	require_once 'persistence/LivroPA.php';
	$livropa=new LivroPA();
	require_once 'model/Livro.php';
	$livro=new Livro();
	$consulta=$livropa->buscar($_GET['cod_liv'],
		'cod_liv');
	if (!$consulta) {
		echo "<h2>Livro não encontrado! 
		<a href='buscarliv.php'>Volte</a></h2>";

	}else{
		require_once 'persistence/LivroPA.php';
		$livropa=new LivroPA();
		$lista=$livropa->listarTitulo();
		$linha=$consulta->fetch_assoc();
		$livro->setCodLiv($linha['cod_liv']);
		$livro->setTitulo($linha['titulo']);
		$livro->setAutor($linha['autor']);
		$livro->setGenero($linha['genero']);
		$livro->setEditora($linha['editora']);
		$livro->setDataPubli($linha['data_publi']);
		$livro->setEstado($linha['estado']);
		$livro->setQuantidade($linha['quantidade']);
		$livro->setVCompra($linha['v_compra']);
		$livro->setVVenda($linha['v_venda']);
		$livro->setDescricao($linha['descricao']);
		$livro->setFoto($linha['foto']);
		
?>
<form action="alterarliv.php" method="POST"
id="form" enctype="multipart/form-data">
	<div id="loader" style="display: none;">
		<img src="img/loader.gif">
	</div>

	<h1>Alterar Livro</h1>
	<input type="hidden" name="cod_liv"
	value="<?= $livro->getCodLiv() ?>">

	<p>Título:</p>
	<p><input type="text" name="titulo"
		size="70" maxlength="70"
		pattern="[0-9a-zA-Z\/\s-,.s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{1,70}"
		value="<?= $livro->getTitulo() ?>"
		required></p>

	<p>Autor:</p>
	<p><input type="text" name="autor"
		size="30" maxlength="30"
		pattern="[0-9a-zA-Z\s-,.s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{1,30}"
		value="<?= $livro->getAutor() ?>"
		required></p>

	<p>Gênero:</p>
	<p><input type="text" name="genero"
		size="20" maxlength="20"
		pattern="[0-9a-zA-Z\/\s-,.s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{1,20}"
		value="<?= $livro->getGenero() ?>"
		required></p>

	<p>Editora:</p>
	<p><input type="text" name="editora"
		size="30" maxlength="30"
		pattern="[0-9a-zA-Z\/\s-,.s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{1,30}"
		value="<?= $livro->getEditora() ?>"
		required></p>

	<p>Publicação:</p>
	<p><input type="date" name="data_publi" min="<?= Livro::minimo() ?>"
		max="<?= date('Y-m-d') ?>" 
		value="<?= $livro->getDataPubli() ?>"
		required></p>

	<p>Estado:</p>
	<p><input type="text" name="estado"
		size="20" maxlength="20"
		pattern="[0-9a-zA-Z\s-,.s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{1,20}"
		value="<?= $livro->getEstado() ?>"
		required></p>

	<p>Quantidade:</p>
	<p><input type="number" name="quantidade"
		min="0" max="9999" 
		value="<?= $livro->getQuantidade() ?>"
		required></p>

	<p>Valor de compra:</p>
	<p><input type="number" name="v_compra"
		min="0.01" max="9999.99" step="0.01"
		value="<?= $livro->getVCompra() ?>"
		required></p>

	<p>Valor de venda:</p>
	<p><input type="number" name="v_venda"
		min="0.01" max="9999.99" step="0.01"
		value="<?= $livro->getVVenda() ?>"
		required></p>

	<p>Descrição:</p>
	<p><textarea name="descricao" cols="60" rows="4" maxlength="240" required placeholder="obs:descreva sobre seu produto." required><?= $livro->getDescricao() ?></textarea></p>

	<p>Foto atual:</p>
	<img src="data:image/jpg;base64,
	<?= base64_encode($livro->getFoto())?>">

	<p>Escolher outra?</p>
	<p><input type="file" name="foto" 
		accept=".jpg,.jpeg,.gif,.png,.bmp"></p>
	<p>Livro:</p>

<?php
	echo "</select></p>";
?>
	<p><input type="submit" name="botao"
		value="Alterar"></p>
</form>
<script src="js/loader.js"></script>
<?php
	}
}else if (isset($_POST['botao'])) {
	require_once 'persistence/LivroPA.php';
	require_once 'model/Livro.php';
	$livropa=new LivroPA();
	$livro=new Livro();

	if (isset($_FILES['foto'])&&$_FILES['foto']['tmp_name']!="") {
		$livro->setFoto($_FILES['foto']['tmp_name']);
		if ($livro->verificarTamanho($livro->getFoto())) {
			$livro->criarImagem();
			$flag=true;
		}else{
			echo "<h2>Imagem muito grande! Máx. 65Kb!</h2>";
			$flag=false;
		}
	}else{
	$livro->setFoto(addslashes(
	$livropa->retornarImagem($_POST['cod_liv'])));
		$flag=true;
	}
	if ($flag) {
		$livro->setCodLiv($_POST['cod_liv']);
		$livro->setTitulo($_POST['titulo']);
		$livro->setAutor($_POST['autor']);
		$livro->setGenero($_POST['genero']);
		$livro->setEditora($_POST['editora']);
		$livro->setDataPubli($_POST['data_publi']);
		$livro->setEstado($_POST['estado']);
		$livro->setQuantidade($_POST['quantidade']);
		$livro->setVCompra($_POST['v_compra']);
		$livro->setVVenda($_POST['v_venda']);
		$livro->setDescricao($_POST['descricao']);

	if($livropa->alterar($livro)){
			echo "<h2>Livro alterado com sucesso!</h2>";
		}else{
			echo "<h2>Tentativa frustrada! Tente 
			<a href='buscarliv.php?termo=".$livro->getCodliv().
			"&campo=cod_liv&botao=Buscar'>novamente</a>!</h2>";
		}
	}
}else{
	header('location: index.php');
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





	






