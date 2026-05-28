<?php require_once 'cabecalho.php';
require_once 'menu.php';
if (isset($_COOKIE['administrador'])||isset($_COOKIE['cliente'])){

?>

<?php $isAdmin = isset($_COOKIE['administrador']); ?>

<form action="buscarliv.php" method="GET" id="form">
    <div id="loader" style="display: none;">
        <img src="img/loader.gif">
    </div>
    <h1>Buscar livro</h1>
    <p><input type="search" name="termo" size="30" maxlength="240" pattern="[0-9a-zA-Z\s.-çÇãÃáÁéÉêÊíÍóÓúÚ]{1,240}" required></p>

    <div class="grupoRadio">
        <label class="radioItem">
            <input type="radio" name="campo" value="titulo">
            <span>Título</span>
        </label>
        <label class="radioItem">
            <input type="radio" name="campo" value="autor">
            <span>Autor</span>
        </label>
        <label class="radioItem">
            <input type="radio" name="campo" value="genero">
            <span>Gênero</span>
        </label>
        <label class="radioItem">
            <input type="radio" name="campo" value="editora">
            <span>Editora</span>
        </label>
    </div>
    <p><input type="submit" name="botao" value="Buscar"></p>
</form>

<?php
if (isset($_GET['botao'])) {
    require_once 'persistence/LivroPA.php';
    $livropa = new LivroPA();
    require_once 'model/Livro.php';
    $livro = new Livro();

    $apenasEmEstoque = !$isAdmin;

    if (isset($_GET['campo']) && $_GET['campo'] != "") {
        $consulta = $livropa->buscar($_GET['termo'], $_GET['campo'], $apenasEmEstoque);
    } else {
        $consulta = $livropa->buscar($_GET['termo'], "", $apenasEmEstoque);
    }

    if (!$consulta) {
        echo "<h2>Nenhum resultado encontrado!</h2>";
    } else {
        echo "<section class='resultado'>";
        while($linha = $consulta->fetch_assoc()){
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
            echo "
            <div class='cardProduto'>
                <div class='imagemProduto'>
                    <img src='data:image/jpg;base64,".base64_encode($livro->getFoto())."'>
                </div>
                <div class='infoProduto'>
                    <h1>".$livro->getTitulo()."</h1>
                    <div class='linhaInfo'>
                        <span class='tituloInfo'>C&oacute;digo:</span>
                        <span>".$livro->getCodLiv()."</span>
                    </div>
                    <div class='linhaInfo'>
                        <span class='tituloInfo'>Autor:</span>
                        <span>".$livro->getAutor()."</span>
                    </div>
                    <div class='linhaInfo'>
                        <span class='tituloInfo'>Gênero:</span>
                        <span>".$livro->getGenero()."</span>
                    </div>
                    <div class='linhaInfo'>
                        <span class='tituloInfo'>editora:</span>
                        <span>".$livro->getEditora()."</span>
                    </div>
                    <div class='linhaInfo'>
                        <span class='tituloInfo'>data_publi:</span>
                        <span class='status'>".$livro->getDataPubli()."</span>
                    </div>
                    <div class='linhaInfo'>
                        <span class='tituloInfo'>Estado:</span>
                        <span class='status'>".$livro->getEstado()."</span>
                    </div>
                    <div class='linhaInfo'>
                        <span class='tituloInfo'>Quantidade:</span>
                        <span>".$livro->getQuantidade()."</span>
                    </div>";

            if ($isAdmin){
                echo "
                    <div class='linhaInfo'>
                        <span class='tituloInfo'>Valor Compra:</span>
                        <span>R$ ".number_format($livro->getVCompra(),2,",",".")."</span>
                    </div>";
            }
            echo "
                    <div class='linhaInfo'>
                        <span class='tituloInfo'>Valor Venda:</span>
                        <span>R$ ".number_format($livro->getVVenda(),2,",",".")."</span>
                    </div>
                </div>";

            if ($isAdmin){
                echo "
                    <a class='icones' href='alterarliv.php?cod_liv=".$livro->getCodLiv()."'>
                        <img src='img/edit.png'/>
                    </a>
                    <a class='icones' href='excluirliv.php?cod_liv=".$livro->getCodLiv()."'>
                        <img src='img/lixo.png'/>
                    </a>";
            }

            if (!$isAdmin){
                echo "
                    <form action='comprarliv.php' method='POST'>
                        <input type='hidden' name='cod_liv' value='".$livro->getCodLiv()."'>
                        <button class='icones' type='submit'>
                            <img src='img/comprar.png'/>
                        </button>
                    </form>";
            }

            echo "
                </div>
            </div>";
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