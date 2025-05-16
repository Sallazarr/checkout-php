<?php
/**
 * Script para cadastro dos produtos no banco de dados. Além de cadastrar, ele também
 * atualiza a quantidade do produto se ele ja existir na base.
 */
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['usuario_logado'])) {
    header('location:index.php');
}

$produto = $_POST['produto'];
$quantidade = (int) $_POST['qtd'];
$preco = $_POST['preco'];

// verifica no banco se existe registro do produto.
require_once('../conf/conexao_db.php');
$verificacao = $conexao->query("SELECT * FROM produtos WHERE produto='$produto'");

/**
 * Se houver o produto na base, ele soma a quantidade do produto. Se não houver,
 * cria o produto. Se a quantidade for menor que 1, ele retorna para o formulário.
 */
if ($quantidade > 0) {
    if ($verificacao->num_rows > 0) {
        $conexao->query("UPDATE produtos SET quantidade=quantidade + $quantidade WHERE produto='$produto'");
        header('location:../view/vi_form_cadastro_produtos_html.php?produto_atualizado=1');
        exit();
    } else {
        $conexao->query("INSERT INTO produtos (produto, quantidade, preco) VALUES ('$produto', '$quantidade', '$preco')");
        header('location:../view/vi_form_cadastro_produtos_html.php?produto_atualizado=0');
        exit();
    }
} else {
    header('location:../view/vi_form_cadastro_produtos_html.php?qtd_invalida=0');
    exit();
}
?>