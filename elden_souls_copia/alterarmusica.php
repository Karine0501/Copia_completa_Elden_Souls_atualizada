<?php require_once 'cabecalho.php';
require_once 'menu.php';

if (isset($_COOKIE['administrador'])||isset($_COOKIE['cliente'])){


if (isset($_GET['cod_mu'])) {
    require_once 'persistence/MusicaPA.php';
    $musicapa=new MusicaPA();
    require_once 'model/Musica.php';
    $musica=new Musica();
    $consulta=$musicapa->buscar($_GET['cod_mu'],'cod_mu',$musica);
    if (!$consulta) {
        echo "<h2>Musica não encontrada!<a href='buscarmusica.php'>Volte</a></h2>";
    }else{
        
        $linha=$consulta->fetch_assoc();
            $musica->setCodMu($linha['cod_mu']);
            $musica->setTitulo($linha['titulo']);
            $musica->setArtista($linha['artista']);
            $musica->setGenero($linha['genero']);
            $musica->setFormato($linha['formato']);
            $musica->setEstado($linha['estado']);
            $musica->setQuantidade($linha['quantidade']);
            $musica->setVCompra($linha['v_compra']);
            $musica->setVVenda($linha['v_venda']);
            $musica->setFoto($linha['foto']);
?>
    <form action="alterarmusica.php" method="POST" id="form" enctype="multipart/form-data">
    <div id="loader" style="display: none;">
        <img src="img/loader.gif">
    </div>
    <h1>Alterar Musica</h1>
    <input type="hidden" name="cod_mu" value="<?= $musica->getCodMu()?>">
    <p>Titulo:</p>
    <p><input type="text" name="titulo" size="70" maxlength="70" pattern="[0-9a-zA-Z\s-,.s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{2,70}" 
    value="<?= $musica->getTitulo() ?>" required></p>
    <p>Artista:</p>
  <p><input type="text" name="artista" size="70" maxlength="70" pattern="[0-9a-zA-Z\s-,.s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{2,70}" 
    value="<?= $musica->getArtista() ?>" required></p>
    <p>Genero:</p>
    <p><input type="text" name="genero" size="30" maxlength="30" pattern="[0-9a-zA-Z\s-,.s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{2,30}" 
    value="<?= $musica->getGenero() ?>" required></p>
    <p>Formato:</p>
    <p><input type="text" name="formato" size="20" maxlength="20" pattern="[0-9a-zA-Z\s-,.s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{2,20}" 
    value="<?= $musica->getFormato() ?>" required></p>
    <p>Estado:</p>
    <p><input type="text" name="estado" size="30" maxlength="30" pattern="[0-9a-zA-Z\s-,.s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{3,30}" 
    value="<?= $musica->getEstado() ?>" required></p>
    <p>Quantidade:</p>
    <p><input type="number" name="quantidade" min="1" max="9999"  
    value="<?= $musica->getQuantidade()?>" required></p>
    <p>Valor De Compra:</p>
    <p><input type="number" name="v_compra" min="0.01" max="9999.99" step="0.01"  
    value="<?= $musica->getVCompra()?>" required></p>
    <p>Valor De Venda:</p>
    <p><input type="number" name="v_venda" min="0.01" max="9999.99" step="0.01"  
    value="<?= $musica->getVVenda()?>" required></p>
    <p>Foto atual:</p>
    <img src="data:image/jpg;base64, 
    <?= base64_encode($musica->getFoto())?>">
    <p>Escolher Outra?</p>
    <p><input type="file" name="foto" 
		accept=".jpg,.jpeg,.gif,.png,.bmp"></p>
    <p>Musica:</p>
    <p><input type="submit" name="botao" value="Alterar"></p>
</form>
<script src="js/loader.js"></script>
<?php  
    }        
    }else if(isset($_POST['botao'])){
        require_once 'persistence/MusicaPA.php';
        require_once 'model/Musica.php';
        $musicapa=new MusicaPA();
        $musica=new Musica();

    if (isset($_FILES['foto'])&&$_FILES['foto']['tmp_name']!="") {
        $musica->setFoto($_FILES['foto']['tmp_name']);
    if ($musica->verificarTamanho($musica->getFoto())) {
        $musica->criarImagem();
        $flag=true;
        }else{
            echo "<h2>Imagem muito grande! Máx. 65kb!</h2>";
            $flag=false;
        }
        }else{
        $musica->setFoto(addslashes($musicapa->retornarImagem($_POST['cod_mu'])));
        $flag=true;
        }
    if ($flag) {
         $musica->setCodMu($_POST['cod_mu']);
         $musica->setTitulo($_POST['titulo']);
         $musica->setArtista($_POST['artista']);
         $musica->setGenero($_POST['genero']);
         $musica->setFormato($_POST['formato']);
         $musica->setEstado($_POST['estado']);
         $musica->setQuantidade($_POST['quantidade']);
         $musica->setVCompra($_POST['v_compra']);
         $musica->setVVenda($_POST['v_venda']);
        
        if($musicapa->alterar($musica)){
            echo "<h2>Musica Alterado com sucesso!</h2>";
            }else{
            echo "<h2>Erro na tentativa de alterar! Tente<a href='buscarmusica.php?termo=".$musica->getCodMu().
            "&campo=cod_mu&botao=buscar'>novamente</a>!</h2>";
            }
    }
    
}
    ?>
    <div id="btn-area">
    <a href="buscarmusica.php" id="btn-voltar">Voltar</a>
</div>
<?php
}else{
    header('location: index.php');
}
?> 
</body>
</html>