<?php
/**
 * Script para para exibir todos os produtos dentro de uma tabela, na página de checkout.
 */
require_once('../conf/conexao_db.php');

session_start();
$_SESSION['todos_produtos'] = [];

$resultado = $conexao->query("SELECT id, produto, preco FROM produtos ORDER BY id");

if ($resultado) {
  while ($produto = $resultado->fetch_assoc()) {
    $_SESSION['todos_produtos'][] = $produto;
  }
  $resultado->free();
}

$conexao->close();
header('Location: ../view/vi_tab_produtos_checkout_html.php');
exit();
?>