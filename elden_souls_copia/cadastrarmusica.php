<?php require_once 'cabecalho.php';
require_once 'menu.php';

if (isset($_COOKIE['administrador'])||isset($_COOKIE['cliente'])){

?>
  <form action="cadastrarmusica.php#res" method="POST" id="form" enctype="multipart/form-data">
    <div id="loader" style="display: none;">
        <img src="img/loader.gif">
    </div>
       <h1>Cadastro da Música</h1>
    <p>Titulo:</p>
    <p><input type="text" name="titulo"  size="70" maxlength="70" pattern="[0-9a-zA-Z\/\s-,.s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{2,70}"
    title="Somente letras e números e hífen e / e , e . , mín. 2 máx. 70" required></p>
    <p>Artista:</p>
    <p><input type="text" name="artista" size="50" maxlength="50" pattern="[0-9a-zA-Z\/\s-,.s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{2,50}"
    title="Somente letras e números e hífen e / e , e . , mín. 2 máx. 50" required></p>
    <p>Gênero:</p>
    <p><input type="text" name="genero" size="70" maxlength="70" pattern="[0-9a-zA-Z\/\s-,.s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{3,70}" title="Somente letras e números e hífen e / e , e . , mín. 3 máx. 70" required></p>
    <p>Formato:</p>
    <p><input type="text" name="formato" size="20" maxlength="20" pattern="[0-9a-zA-Z\/\s-,.s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{2,20}" 
    title="Somente letras e números e hífen e / e , e . , mín. 2 máx. 20" required></p>
    <p>Estado:</p>
    <p><input type="text" name="estado" size="20" maxlength="20" pattern="[0-9a-zA-Z\s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{3,20}" title="Somente letras e números e hífen e / e , e . , mín. 3 máx. 20" required></p>
    <p>Quantidade:</p>
    <p><input type="number" name="quantidade" min="1.0" max="9999.99" required></p>
    <p>Valor De Compra:</p>
    <p><input type="number" name="v_compra" min="0.01" max="9999.99" step="0.01" required></p>
    <p>Valor De Venda:</p>
    <p><input type="number" name="v_venda" min="0.01" max="9999.99" step="0.01" required></p>
    <p>Foto:</p>
    <p><input type="file" name="foto" accept=".jpg,.jpeg,.gif,.png,.bmp" required></p>
    <p><input type="submit" name="botao" value="Cadastrar"></p>
</form>
<?php 

  if (isset($_POST['botao'])) {
    require_once 'model/Musica.php';
    require_once 'persistence/MusicaPA.php';
    $musica=new Musica();
    $musicapa=new MusicaPA();
    $musica->setFoto($_FILES['foto']['tmp_name']);
    if (!$musica->verificarTamanho($musica->getFoto())) {
        echo "<h2 id='res'>Imagem muito grande! Máx. 65Kb!</h2>";
    }else{
        $musica->criarImagem();
        $musica->setTitulo($_POST['titulo']);
        $musica->setArtista($_POST['artista']);
        $musica->setGenero($_POST['genero']);
        $musica->setFormato($_POST['formato']);
        $musica->setEstado($_POST['estado']);
        $musica->setQuantidade($_POST['quantidade']);
        $musica->setVCompra($_POST['v_compra']);
        $musica->setVVenda($_POST['v_venda']);
        if($musicapa->cadastrar($musica)){
        
            echo "<h2 id='res'>Musica cadastrada com sucesso!</h2>";
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
