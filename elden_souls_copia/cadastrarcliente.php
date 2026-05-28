<?php require_once 'cabecalho.php'; require_once 'menu.php'; 

?>

<form action="cadastrarcliente.php#res" method="POST" id="form">
<div id="loader" style="display: none;">
        <img src="img/loader.gif">
    </div>

    <h1>Cadastro de Cliente</h1>
    <p>Digite o nome:</p>
<p><input type="text" name="nome"
    size="60" maxlength="60"
    pattern="[0-9a-zA-Z\s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{3,60}"
    title="Somente letras e números e hífen, mín. 3 máx. 60"
    required></p>

    <p>CPF</p>
    <p><input type="text" name="cpf" maxlength="14" title="Digite no formato XXX.XXX.XXX-XX" pattern="[0-9\.-]{14}" id="cpf" placeholder="XXX.XXX.XXX-XX" required></p>

    <p>Endereço:</p>
    <p><input type="text"
    name="endereco" size="70"
    maxlength="70" pattern="[0-9a-zA-Z\s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{2,70}"
    title="Somente letras e números e hífen, mín. 2 máx. 70"
    required></p>

    <p>Telefone:</p>
    <p><input type="text"
    name="telefone" size="20"
    maxlength="20"pattern="\([0-9]{2}\)[0-9]{4,5}-[0-9]{4}"
    title="Somente números"
    id="telefone"required></p>

    <p>Digite o Login:</p>
    <p><input type="text" name="login"
    size="40" maxlength="40"
    pattern="[0-9a-zA-Z_@]{3,20}" 
    title="Somente letras e números _ e @ mín. 3 máx. 40"
    required></p>

    <br>
    <p>Senha:</p>
    <p><input type="password" name="senha"
    size="10"maxlength="10"
    pattern="[0-9A-Za-z_@\-]{5,10}"
    title="letras e números, _,@ e hífen. mín. 5 máx. 10"
    required></p>

    <br>
    <p>Confirme a senha:</p>
    <p><input type="password" name="confirma"size="10"
    maxlength="10"pattern="[0-9A-Za-z_@\-]{5,10}"
    title="letras e números, _,@ e hífen. mín. 5 máx. 10"
    required></p>

    <br>
    <p><input type="submit" name="botao" value="Cadastrar"></p>

</form>

<?php
if (isset($_POST['botao'])) {

    require_once 'model/Cliente.php';
    require_once 'persistence/ClientePA.php';

    $cliente=new Cliente();
    $clientepa=new ClientePA();

    $cliente->setCpf($_POST['cpf']);

    if (!$clientepa->verificarCpf($cliente->getCpf())) {
        echo "<h2 id='res'>CPF já cadastrado!</h2>";
    } else {

        $cliente->setSenha($_POST['senha']);

        if ($cliente->getSenha()!=$_POST['confirma']) {
            echo "<h2 id='res'>Confirmação de senha não confere!</h2>";
        } else {

            $cliente->setNome($_POST['nome']);
            $cliente->setEndereco($_POST['endereco']);
            $cliente->setTelefone($_POST['telefone']);
            $cliente->setLogin($_POST['login']);

            $cliente->criptografarSenha();

            if ($clientepa->cadastrar($cliente)) {
                echo "<h2 id='res'>Cliente cadastrado com sucesso!</h2>";
            } else {
                echo "<h2 id='res'>Erro na tentativa de cadastrar! Tente novamente!</h2>";
            }
        }
    }
}
?>

<script src="js/loader.js"></script>
</body>
</html>