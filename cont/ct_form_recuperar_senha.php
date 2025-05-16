<?php
/**
 * Script para realizar a recuperação de senha do usuário. Ele gera uma senha aleatória.
 */
require_once('../conf/conexao_db.php');

$email = $_POST['email'];

// realiza a consulta no banco pra verificar se o email informado está na base.
$verificacao = $conexao->query("SELECT * FROM usuarios WHERE email='$email'");

// função para realizar a criação da nova senha e atualizar no banco.
function gerarSenhaAleatoria($conexao, $email)
{
    $senha = random_int(100000, 9999999); //gera um numero aleatório como senha.
    $conexao->query("UPDATE usuarios SET senha='$senha' WHERE email='$email'");
    header("Location: ../index.php?nova_senha=$senha");
    exit();
}

// validação do retorno da consulta no banco. Se houver registro válido, chama a função 'gerarSenhaAleatoria'.
// Se não encontrar registro, retorna mensagem informando que o email não existe na base e volta para página.
if ($verificacao->num_rows > 0) {
    gerarSenhaAleatoria($conexao, $email);
} else {
    header("Location: ../view/vi_form_recuperar_senha_html.php?email_invalido=1");
}

$conexao->close();
?>