<?php require_once 'cabecalho.php';
require_once 'menu.php';
require_once 'model/Livro.php';

if (isset($_COOKIE['administrador'])||isset($_COOKIE['cliente'])){

?>
<form action="cadastrarliv.php#res" method="POST" id="form" enctype="multipart/form-data">
	<div id="loader" style="display:none;">
		<img src="img/loader.gif">
	</div>
	<h1>Cadastro de Livros</h1>

	<p>Título</p>
	<p><input type="text" name="titulo" size="70" maxlength="70" pattern="[0-9a-zA-Z\/\s-,.s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{2,70}"
	title="Somente letras e números e hífen e / e , e . , mín. 2 máx. 30" required></p>

	<p>Autor</p>
	<p><input type="text" name="autor" size="30" maxlength="30" pattern="[0-9a-zA-Z\s-,.s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{2,30}"
	title="Somente letras e números e hífen e , e . , mín. 2 máx. 30" required></p>

	<p>Gênero:</p>
	<p><input type="text" name="genero" size="20" maxlength="20" pattern="[0-9a-zA-Z\/\s-,.s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{3,20}"
	title="Somente letras e números e hífen e / e , e . , mín. 3 máx. 20" required></p>

	<p>Editora:</p>
	<p><input type="text" name="editora" size="30" maxlength="30" pattern="[0-9a-zA-Z\/\s-,.s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{3,30}"
	title="Somente letras e números e hífen e / e , e . , mín. 3 máx. 30" required></p>

	<p>Data de publicação:</p>
	<p><input type="date" name="data_publi" min="<?=Livro::minimo()?>" max="<?=date('Y-m-d')?>" required></p>

	<p>Estado:</p><!--OPÇOES-->
	<p><input type="text" name="estado" size="20" maxlength="20" pattern="[0-9a-zA-Z\s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{3,20}"
	title="Somente letras e números e hífen, mín. 3 máx. 70" required></p>

	<p>Quantidade:</p>
	<p><input type="number" name="quantidade"  min="0" max="9999" required ></p>

	<p>Valor da compra:</p>
	<p><input type="number" name="v_compra" step="0.01" min="0.01" max="9999" required ></p>

	<p>Valor da venda:</p>
	<p><input type="number" name="v_venda" step="0.01" min="0.01" max="9999" required ></p>

	<p>Descrição</p>
	<p><textarea name="descricao" cols="60" rows="4" maxlength="240" required placeholder="obs:descreva sobre seu produto." required></textarea></p>

	<p>Foto:</p>
	<p><input type="file" name="foto" accept=".jpg,.jpeg,.gif,.png,.bmb" required></p>

	<p><input type="submit" name="botao" value="Cadastrar"></p>

</form>
<?php 
	if (isset($_POST['botao'])) {
		require_once 'model/Livro.php';
		require_once 'persistence/LivroPA.php';

	$livro=new Livro();
	$livropa=new LivroPA();
	$livro->setFoto($_FILES['foto']['tmp_name']);
	if (!$livro->verificarTamanho($livro->getFoto())) {
		echo "<h2 id='res'>Imagem muito grande! Máx. 65Kb!</h2>";
	}else{
		$livro->criarImagem();
		$livro->setTitulo($_POST['titulo']);
		$livro->setAutor($_POST['autor']);
		$livro->setGenero($_POST['genero']);
		$livro->setEditora($_POST['editora']);
		$livro->setDataPubli($_POST['data_publi']);
		$livro->setEstado($_POST['estado']);
		$livro->setQuantidade($_POST['quantidade']);
		$livro->setDescricao($_POST['descricao']);
		$livro->setVCompra($_POST['v_compra']);
		$livro->setVVenda($_POST['v_venda']);
		
		if ($livropa->cadastrar($livro)) {
			echo "<h2 id='res'>Livro cadastrado com sucesso!</h2>";
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