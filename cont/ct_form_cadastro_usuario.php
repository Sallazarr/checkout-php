<?php
/**
 * Script para realizar o cadastro de usuários.
 */
require_once('../conf/conexao_db.php');

$nome = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['senha'];

// consulta no banco.
$verificacao = $conexao->query("SELECT * FROM usuarios WHERE email='$email'");

/**
 * Bloco pra validar se existe registro do email no banco. Se houver, avisa que já
 * existe e volta pra pagina de recuepração. Se nao houver, executa a query pra cadastrar
 * o usuário. Se a query der erro, manda de volta pra página de cadastro com o erro.
 */
if ($verificacao->num_rows > 0) {
    header('Location: ../view/vi_form_cadastro_usuario_html.php?email_repetido=1');
    exit();
} else {
    $input = $conexao->query("INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$password')");
    if ($input) {
        header('Location: ../index.php?cadastro=1');
        exit();
    } else {
        $erro = $conexao->error;
        header('Location: ../view/vi_form_cadastro_usuario_html.php?erro=$erro');
    }
}
$conexao->close();
?>