<?php
/**
 * Adiciona um produto ao carrinho por ID.
 */
require_once('../conf/conexao_db.php');
if (!isset($_SESSION)) { session_start(); }
if (!isset($_SESSION['produtos'])) { $_SESSION['produtos'] = []; }

$id = (int)($_POST['id'] ?? 0);
if ($id <= 0) {
    header("Location: ../view/vi_tab_produtos_checkout_html.php");
    exit();
}

$res = $conexao->query("SELECT * FROM produtos WHERE id = {$id}");
if ($res && $row = $res->fetch_assoc()) {
    $_SESSION['produtos'][] = $row;
}
$conexao->close();

header("Location: ../view/vi_tab_produtos_checkout_html.php");
exit();
