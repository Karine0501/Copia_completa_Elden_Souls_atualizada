<?php require_once 'cabecalho.php'; 
require_once 'menu.php'; ?>

<section class="home">

    <div class="textoHome">

        <h1>Biblioteca & Sebo</h1>

        <p>
            Explore livros, jogos e músicas em um universo sombrio
            inspirado em fantasia medieval.
        </p>

        <div class="botoesHome">

            <?php if(!isset($_COOKIE['administrador']) && !isset($_COOKIE['cliente'])) { ?>

                <a href="cadastrarcliente.php" class="btnHome">Quero me cadastrar</a>

                <a href="login.php" class="btnHome">Faça login</a>

            <?php } ?>

        </div>

    </div>

    <div class="imagemHome">
        <img src="img/logo_sem_fundo.png">
    </div>

</section>

</body>
</html>