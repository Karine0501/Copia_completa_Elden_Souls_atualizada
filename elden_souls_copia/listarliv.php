<?php require_once 'cabecalho.php';
require_once 'menu.php';

require_once 'persistence/LivroPA.php';

if (isset($_COOKIE['administrador'])||isset($_COOKIE['cliente'])){

    $livropa = new LivroPA();
    $total = $livropa->contar();

    if($total <= 0){
        echo "<h2>Não há livros cadastrados! Cadastre-os primeiro!</h2>";
    }else{
        if(isset($_GET['pagina'])){
            $pagina = $_GET['pagina'];
        }else{
            $pagina = 1;
        }

        $limite = 2;
        $offset = ($pagina - 1) * $limite;

        $isAdmin = isset($_COOKIE['administrador']);
        $apenasEmEstoque = !$isAdmin;

        $consulta = $livropa->listar($limite, $offset, $apenasEmEstoque);

        require_once 'model/Livro.php';
        $livro = new Livro();

        echo "<section class='listaProdutos'>";

        while($linha = $consulta->fetch_assoc()){
            $livro->setCodliv($linha['cod_liv']);
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
                        <span>".$livro->getCodliv()."</span>
                    </div>
                    <div class='linhaInfo'>
                        <span class='tituloInfo'>Autor:</span>
                        <span>".$livro->getAutor()."</span>
                    </div>
                    <div class='linhaInfo'>
                        <span class='tituloInfo'>G&ecirc;nero:</span>
                        <span>".$livro->getGenero()."</span>
                    </div>
                    <div class='linhaInfo'>
                        <span class='tituloInfo'>Editora:</span>
                        <span>".$livro->getEditora()."</span>
                    </div>
                    <div class='linhaInfo'>
                        <span class='tituloInfo'>Data publi:</span>
                        <span class='status'>".$livro->getDataPubli()."</span>
                    </div>
                    <div class='linhaInfo'>
                        <span class='tituloInfo'>Estado:</span>
                        <span class='status'>".$livro->getEstado()."</span>
                    </div>
                    <div class='linhaInfo'>
                        <span class='tituloInfo'>Quantidade:</span>
                        <span>".$livro->getQuantidade()."</span>
                    </div>
                    <div class='linhaInfo'>
                        <span class='tituloInfo'>Valor Compra:</span>
                        <span>R$ ".number_format($livro->getVCompra(),2,",",".")."</span>
                    </div>
                    <div class='linhaInfo'>
                        <span class='tituloInfo'>Valor Venda:</span>
                        <span>R$ ".number_format($livro->getVVenda(),2,",",".")."</span>
                    </div>
                    <div class='descricaoProduto'>
                        <h3>Descri&ccedil;&atilde;o</h3>
                        <p>".$livro->getDescricao()."</p>
                    </div>
                </div>
            </div>
            ";
        }

        echo "</section>";

        echo "<section class='paginacao'>";
        if($pagina > 1){
            $voltar = $pagina - 1;
            echo "<a class='btnPagina' href='listarliv.php?pagina=$voltar'>❮ Anterior</a>";
        }
        $total_pag = ceil($total / $limite);
        echo "<span class='paginaAtual'>$pagina / $total_pag</span>";
        if($pagina < $total_pag){
            $proxima = $pagina + 1;
            echo "<a class='btnPagina' href='listarliv.php?pagina=$proxima'>Próxima ❯</a>";
        }
        echo "</section>";
    }
?>
<?php
}else{
    header('location: index.php');
}
?>
</body>
</html>