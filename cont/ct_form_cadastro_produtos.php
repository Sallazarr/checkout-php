<?php
/**
 * Cadastra novo produto OU soma quantidade se o nome já existir (produto UNIQUE).
 */
if (!isset($_SESSION)) { session_start(); }
if (!isset($_SESSION['usuario_logado'])) {
    header('Location: ../view/index.php');
    exit();
}

require_once('../conf/conexao_db.php');

$produto      = trim($_POST['produto'] ?? '');
$quantidade   = (int)($_POST['qtd'] ?? 0);
$precoRaw     = trim($_POST['preco'] ?? '0');
$descricao    = trim($_POST['descricao'] ?? '');
$imagem_path  = trim($_POST['imagem_path'] ?? '');

/* Normaliza preço "1.234,56" -> 1234.56 */
$preco = (float)str_replace(',', '.', preg_replace('/\./', '', $precoRaw));

if ($quantidade <= 0 || $preco < 0 || $produto === '') {
    header('Location: ../view/vi_form_cadastro_produtos_html.php?qtd_invalida=1');
    exit();
}

/* Verifica existência pelo nome (coluna produto é UNIQUE) */
$check = $conexao->prepare("SELECT id FROM produtos WHERE produto = ?");
$check->bind_param('s', $produto);
$check->execute();
$checkRes = $check->get_result();

if ($checkRes->num_rows > 0) {
    /* Já existe: soma quantidade (mantém demais campos) */
    $upd = $conexao->prepare("UPDATE produtos SET quantidade = quantidade + ? WHERE produto = ?");
    $upd->bind_param('is', $quantidade, $produto);
    $ok = $upd->execute();
    $upd->close();
    $check->close();

    if ($ok) {
        header('Location: ../view/vi_form_cadastro_produtos_html.php?produto_atualizado=1');
        exit();
    } else {
        header('Location: ../view/vi_form_cadastro_produtos_html.php?erro=update');
        exit();
    }
} else {
    /* Novo produto: insere completo */
    $ins = $conexao->prepare("INSERT INTO produtos (produto, preco, quantidade, imagem_path, descricao) VALUES (?, ?, ?, ?, ?)");
    $ins->bind_param('sdiss', $produto, $preco, $quantidade, $imagem_path, $descricao);
    $ok = $ins->execute();
    $ins->close();
    $check->close();

    if ($ok) {
        header('Location: ../view/vi_form_cadastro_produtos_html.php?produto_atualizado=0');
        exit();
    } else {
        header('Location: ../view/vi_form_cadastro_produtos_html.php?erro=insert');
        exit();
    }
}
