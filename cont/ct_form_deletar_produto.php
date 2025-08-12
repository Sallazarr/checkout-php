<?php
if (!isset($_SESSION)) { session_start(); }
if (!isset($_SESSION['usuario_logado'])) {
    header('Location: ../view/index.php');
    exit();
}

require_once('../conf/conexao_db.php');

$id = (int)($_POST['id'] ?? 0);

if ($id <= 0) {
    header('Location: ../view/vi_tab_produtos_checkout_html.php?erro=id_invalido');
    exit();
}


$stmt = $conexao->prepare("SELECT id FROM produtos WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    $stmt->close();
    $conexao->close();
    header('Location: ../view/vi_tab_produtos_checkout_html.php?erro=nao_encontrado');
    exit();
}
$stmt->close();


$stmt = $conexao->prepare("DELETE FROM itens_transacao WHERE id_produto = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->close();


$stmt = $conexao->prepare("DELETE FROM produtos WHERE id = ?");
$stmt->bind_param('i', $id);
$ok = $stmt->execute();
$stmt->close();
$conexao->close();


if ($ok) {
    header('Location: ../view/vi_tab_produtos_checkout_html.php?deletado=1');
    exit();
} else {
    header('Location: ../view/vi_tab_produtos_checkout_html.php?erro=delete');
    exit();
}
