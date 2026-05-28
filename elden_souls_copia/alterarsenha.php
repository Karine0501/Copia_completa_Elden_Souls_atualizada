<?php require_once 'cabecalho.php';
require_once 'menu.php';

if (isset($_COOKIE['administrador'])||isset($_COOKIE['cliente'])){

?>
<form action="alterarsenha.php" method="POST" id="form">
	<div id="loader" style="display: none;">
		<img src="img/loader.gif">		
	</div>
	<h1>Alterar Senha</h1>
	<p>Digite a senha atual:</p>
	<p><input type="password" name="senha"
		size="10" maxlength="20"
		pattern="[0-9a-zA-Z\_@.-]{8,20}"
		title="letras e números, _,@ e hífen.
		mín. 5 máx. 20" required></p>
	<p>Digite a nova senha:</p>
	<p><input type="password" name="nova_senha"
		size="10" maxlength="20"
		pattern="[0-9a-zA-Z\_@.-]{8,20}"
		title="letras e números, _,@ e hífen.
		mín. 5 máx. 10" required></p>
	<p>Redigite a nova senha:</p>
	<p><input type="password" name="confirmar"
		size="10" maxlength="20"
		pattern="[0-9a-zA-Z\_@.-]{8,20}"
		title="letras e números, _,@ e hífen.
		mín. 5 máx. 10" required></p>
	<p><input type="submit" name="botao" 
		value="Alterar"></p>
</form>
<?php
	if (isset($_POST['botao'])) {
		require_once 'model/Administrador.php';
		$administrador=new Administrador();
		$administrador->setCodAdm($_COOKIE['administrador']);
		$senha=$_POST['senha'];
		$nova_senha=$_POST['nova_senha'];
		$confirmar=$_POST['confirmar'];

		require_once 'persistence/AdministradorPA.php';
		$administradorpa=new AdministradorPA();
		if (!$administradorpa->verificarSenha(
				$administrador->getCodAdm(),$senha)) {
			echo "<h2>A senha atual não confere!
			Por favor redigite!</h2>";
		}else{
			if($nova_senha==$confirmar){
				$administrador->setSenha($nova_senha);
				$administrador->criptografarSenha();
				
				if($administradorpa->alterarSenha( 
					$administrador->getSenha(),
					$administrador->getCodAdm())){

					echo "<h2>Senha alterada com sucesso!</h2>";
				}else{
					echo "<h2>Erro na tentativa de Alterar!
					Tente novamente!</h2>";
				}
			}else{
				echo "<h2>A nova senha e a nova senha redigitada 
				não conferem! Por favor redigite!</h2>";
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