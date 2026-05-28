<?php require_once 'cabecalho.php';
require_once 'menu.php';

if (isset($_COOKIE['administrador'])||isset($_COOKIE['cliente'])){

if (isset($_GET['cod_mu'])) {
    require_once 'persistence/MusicaPA.php';
    require_once 'model/Musica.php';
    $musica=new Musica();
    $musicapa= new MusicaPA();
    $consulta=$musicapa->buscar($_GET['cod_mu'],'cod_mu',$musica);
    if(!$consulta){
        echo "<h2>Musica não encontrado! <a href='buscarmusica.php'>Tente novamente</a></h2>";
    }else{
        $linha=$consulta->fetch_assoc();
        $musica->setCodMu($linha['cod_mu']);
        $musica->setTitulo($linha['titulo']);

?>
<form action="excluirmusica.php" method="POST" id="form">
    <div id="loader" style="display: none;">
        <img src="img/loader.gif">
    </div>
    <h1>Excluir Musica</h1>
    <p>Tem certeza que deseja exluir o <?= $musica->getTitulo() ?>?</p>
    <input type="hidden" name="cod_mu" value="<?= $musica->getCodMu() ?>">
    <p>
        <input type="submit" name="botao" value="Sim">
        <button><a href="buscarmusica.php">Não</a></button>
    </p>

</form>
    <script src="js/loader.js"></script>
<?php
}
    }else if (isset($_POST['botao'])) {
    require_once 'persistence/MusicaPA.php';
    require_once 'model/Musica.php';
    $musica=new Musica();
    $musicapa=new MusicaPA();

    $musica->setCodMu($_POST['cod_mu']);

    $resposta=$musicapa->excluir($musica->getCodMu());
    if($resposta) {
        echo "<h2>Musica excluida com sucesso!</h2>";
    }else{
        echo "<h2>Erro ao tentar excluir Musica!</h2>";
    }
    }else{
        header('location: index.php');
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