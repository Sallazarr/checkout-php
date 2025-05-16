<?php
/**
 * Script para realizar a lógica de login / autenticação do usuário, no banco de dados.
 */
require_once('../conf/conexao_db.php');

$email = $_POST['email'];
$password = $_POST['password'];

// consulta as crenciais do usuário.
$login = $conexao->query("SELECT * FROM usuarios WHERE email='$email' AND senha='$password'");

// Validação da consulta.
if ($login->num_rows > 0) {
        session_start();
        $_SESSION['usuario_logado'] = $login; // cria sessão de usuario logado.

        // Captura o id do usuário logado para uso posterior
        $id_usuario_logado = $login->fetch_assoc();
        $_SESSION['id_usuario_logado'] = $id_usuario_logado['id'];

        header('Location: ../view/vi_tab_produtos_checkout_html.php');
        exit();
    }
header('Location: ../index.php?credenciais_incorretas=1');
exit();
?>