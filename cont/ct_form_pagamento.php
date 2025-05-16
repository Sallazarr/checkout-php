<?php
/**
 * O script realiza as operações de registro da transação no banco.
 */

require_once('../conf/conexao_db.php');
session_start();

// Se tentar pagar com carrinho vazio, redireciona para a página de checkout onde será exibida uma mensagem de erro.
if (!isset($_SESSION['produtos']) || count($_SESSION['produtos']) == 0) {
    header("Location: ../view/vi_tab_produtos_checkout_html.php?carrinho_vazio=1");
    exit();
}

// Validação se o verbo da requisição é post. Se sim, entra no bloco da lógica.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $metodo = $_POST['metodo_pagamento'];
    $produtos = $_SESSION['produtos'];
    $total = 0;

    // captura os valores da coluna 'preco' de todos os produtos do carrinho.
    foreach ($produtos as $produto) {
        $total += $produto['preco'];
    }

    // insere na tabela o valor total, o metodo de pagamento e o id do usuario que operou a venda.
    $id_usuario = $_SESSION['id_usuario_logado'];
    $conexao->query("INSERT INTO transacoes (total, metodo_pagamento, id_usuario) VALUES ('$total', '$metodo', '$id_usuario')");
    $id_transacao = $conexao->insert_id; // captura o id da transacao que foi salva.

    // insere na tabela os produtos, o preco unitário e o id da transação.
    $insercao = $conexao->prepare("INSERT INTO itens_transacao (id_transacao, id_produto, preco_unitario) VALUES (?, ?, ?)");
    foreach ($produtos as $produto) {
        $insercao->bind_param('iid', $id_transacao, $produto['id'], $produto['preco']);
        $insercao->execute();
    }
    $insercao->close();

    unset($_SESSION['produtos']); // limpa o carrinho.
    header('Location: ../view/vi_venda_concluida_html.php');
    exit();
}
?>