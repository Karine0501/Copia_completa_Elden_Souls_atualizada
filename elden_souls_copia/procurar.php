 <?php require_once 'cabecalho.php';
 require_once 'menu.php';

if (isset($_GET['pesquisa'])) {

    require_once 'persistence/LivroPA.php';
    $livropa=new LivroPA();
    require_once 'model/Livro.php';
    $livro=new Livro();

    require_once 'persistence/JogoPA.php';
    $jogopa=new JogoPA();
      require_once 'model/Jogo.php';
    $jogo=new Jogo();

    require_once 'persistence/MusicaPA.php';
    $musicapa=new MusicaPA();
     require_once 'model/Musica.php';
    $musica=new Musica();

   $livros=$livropa->buscar($_GET['pesquisa'],"",$livro);
    $jogo=$jogopa->buscar($_GET['pesquisa'],"",$jogo);
    $musica=$musicapa->buscar($_GET['pesquisa'],"",$musica);

    if($livros){
        echo "<section class='resultado'>";

        while ($linha=$livros->fetch_assoc()) {

      //Livro          
        echo "
        <div class='cardProduto'>

            <div class='imagemProduto'>
                <img src='data:image/jpg;base64,".base64_encode($linha['foto'])."'>
            </div>

            <div class='infoProduto'>
                <span class='caixaNumeroPedido'>Livro</span>
                <h1>".$linha['titulo']."</h1>

                <div class='linhaInfo'>
                    <span class='tituloInfo'>C&oacute;digo:</span>
                    <span>".$linha['cod_liv']."</span>
                </div>

                <div class='linhaInfo'>
                    <span class='tituloInfo'>Autor:</span>
                    <span>".$linha['autor']."</span>
                </div>

                <div class='linhaInfo'>
                    <span class='tituloInfo'>G&ecirc;nero:</span>
                    <span>".$linha['genero']."</span>
                </div>

                <div class='linhaInfo'>
                    <span class='tituloInfo'>Editora:</span>
                    <span>".$linha['editora']."</span>
                </div>

                <div class='linhaInfo'>
                    <span class='tituloInfo'>Data de Publicação:</span>
                    <span class='status'>".$linha['data_publi']."</span>
                </div>

                <div class='linhaInfo'>
                    <span class='tituloInfo'>Estado:</span>
                    <span class='status'>".$linha['estado']."</span>
                </div>

                <div class='linhaInfo'>
                    <span class='tituloInfo'>Quantidade:</span>
                    <span >".$linha['quantidade']."</span>
                </div>

                <div class='linhaInfo'>
                    <span class='tituloInfo'>Valor da compra:</span>
                    <span >".$linha['v_compra']."</span>
                </div>

                <div class='linhaInfo'>
                    <span class='tituloInfo'>Descrição:</span>
                    <span>".$linha['descricao']."</span>
                </div>
        </div>
</div>

";
}
        echo "</section>";

    }else{
        echo "<h2> Nenhum resultado encontrado!</h2>";
    }

    if($jogo){
        echo "<section class='resultado'>";
        while ($linha=$jogo->fetch_assoc()) {

      //jogo        
         echo "<div class='cardProduto'>

            <div class='imagemProduto'>
                <img src='data:image/jpg;base64,".base64_encode($linha['foto'])."'>
            </div>

            <div class='infoProduto'>
                   <span class='caixaNumeroPedido'>Jogo</span>
                <h1>".$linha['nome']."</h1>

                <div class='linhaInfo'>
                    <span class='tituloInfo'>C&oacute;digo:</span>
                    <span>".$linha['cod_jogo']."</span>
                </div>

                <div class='linhaInfo'>
                    <span class='tituloInfo'>Console:</span>
                    <span>".$linha['console']."</span>
                </div>

                <div class='linhaInfo'>
                    <span class='tituloInfo'>G&ecirc;nero:</span>
                    <span>".$linha['genero']."</span>
                </div>

                <div class='linhaInfo'>
                    <span class='tituloInfo'>Desenvolvedora:</span>
                    <span>".$linha['desenvolvedora']."</span>
                </div>

                  <div class='linhaInfo'>
                    <span class='tituloInfo'>Estado:</span>
                    <span class='status'>".$linha['estado']."</span>
                </div>

                  <div class='linhaInfo'>
                    <span class='tituloInfo'>Quantidade:</span>
                    <span >".$linha['quantidade']."</span>
                </div>


                <div class='linhaInfo'>
                    <span class='tituloInfo'>Valor da compra:</span>
                    <span>".$linha['v_compra']."</span>
                </div>

                <div class='linhaInfo'>
                    <span class='tituloInfo'>Descrição:</span>
                    <span>".$linha['descricao']."</span>
                </div>

                </div>
</div>

                ";

}
        echo "</section>";

    }else{
        echo "<h2> Nenhum resultado encontrado!</h2>";
    }

    if($musica){
        echo "<section class='resultado'>";
        while ($linha=$musica->fetch_assoc()) {

      //musica       
          echo "
      
        <div class='cardProduto'>

            <div class='imagemProduto'>
                <img src='data:image/jpg;base64,".base64_encode($linha['foto'])."'>
            </div>

            <div class='infoProduto'>
                <span class='caixaNumeroPedido'>Música</span>
                <h1>".$linha['titulo']."</h1>

                <div class='linhaInfo'>
                    <span class='tituloInfo'>C&oacute;digo:</span>
                    <span>".$linha['cod_mu']."</span>
                </div>

                <div class='linhaInfo'>
                    <span class='tituloInfo'>Artista:</span>
                    <span>".$linha['artista']."</span>
                </div>

                 <div class='linhaInfo'>
                    <span class='tituloInfo'>G&ecirc;nero:</span>
                    <span>".$linha['genero']."</span>
                </div>


                <div class='linhaInfo'>
                    <span class='tituloInfo'>Formato:</span>
                    <span>".$linha['formato']."</span>
                </div>

                <div class='linhaInfo'>
                    <span class='tituloInfo'>Estado:</span>
                    <span class='status'>".$linha['estado']."</span>
                </div>
               

                  <div class='linhaInfo'>
                    <span class='tituloInfo'>Quantidade:</span>
                    <span>".$linha['quantidade']."</span>
                </div>


                <div class='linhaInfo'>
                    <span class='tituloInfo'>Valor da compra:</span>
                    <span>".$linha['v_compra']."</span>
                </div>

                </div>
            </div>
            </div>

            ";


}
        echo "</section>";

    }else{
        echo "<h2> Nenhum resultado encontrado!</h2>";
    }
}

?>
<script src="js/loader.js"></script>
</body>
</html>