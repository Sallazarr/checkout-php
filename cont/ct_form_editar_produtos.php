<?php
if (!isset($_SESSION)) { session_start(); }
if (!isset($_SESSION['usuario_logado'])) {
    header('Location: ../view/index.php');
    exit();
}

require_once('../conf/conexao_db.php');

$id          = (int)($_POST['id'] ?? 0);
$produto     = trim($_POST['produto'] ?? '');
$quantidade  = (int)($_POST['quantidade'] ?? 0);
$precoRaw    = trim($_POST['preco'] ?? '0');
$descricao   = trim($_POST['descricao'] ?? '');
$imagem_path = trim($_POST['imagem_path'] ?? '');

if ($id <= 0 || $produto === '' || $quantidade < 0) {
    header('Location: ../view/ct_form_editar_produtos_html.php?id=' . $id . '&erro=validacao');
    exit();
}

$preco = (float)str_replace(',', '.', preg_replace('/\./', '', $precoRaw));

$stmt = $conexao->prepare("UPDATE produtos SET produto = ?, preco = ?, quantidade = ?, imagem_path = ?, descricao = ? WHERE id = ?");
$stmt->bind_param('sdissi', $produto, $preco, $quantidade, $imagem_path, $descricao, $id);
$ok = $stmt->execute();
$stmt->close();
$conexao->close();

if ($ok) {
    header('Location: ../view/vi_tab_produtos_checkout_html.php?editado=1');
    exit();
} else {
    header('Location: ../view/ct_form_editar_produtos_html.php?id=' . $id . '&erro=update');
    exit();
}
