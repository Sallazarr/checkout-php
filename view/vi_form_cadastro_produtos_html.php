<!DOCTYPE html>
<?php
if (!isset($_SESSION)) {
  session_start();
}

if (!isset($_SESSION['usuario_logado'])) {
  header("Location: index.php");
  exit();
}

// Exibe mensagens de status
$mensagem = '';
if (isset($_GET['produto_atualizado'])) {
  if ($_GET['produto_atualizado'] == '1') {
    $mensagem = "Quantidade do produto atualizada com sucesso!";
  } else {
    $mensagem = "Produto cadastrado com sucesso!";
  }
}
if (isset($_GET['qtd_invalida'])) {
  $mensagem = "Quantidade inválida! Tente novamente.";
}
if (isset($_GET['erro'])) {
  $mensagem = "Erro ao processar o cadastro.";
}
?>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastro de Produtos</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100%;
      background-color: #f4f4f4;
    }

    .container {
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      width: 600px;
      text-align: center;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    form {
      margin-bottom: 10px;
    }

    label {
      display: block;
      margin-top: 10px;
      text-align: left;
    }

    input,
    textarea {
      width: 100%;
      padding: 8px;
      margin-top: 4px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }

    button {
      margin-top: 15px;
      padding: 10px;
      width: 100%;
      border: none;
      border-radius: 5px;
      background-color: #65e62a;
      color: #fff;
      font-size: 16px;
      cursor: pointer;
    }

    button:hover {
      background-color: #52b41b;
    }

    .secondary {
      background-color: #d9dfe6;
      color: #000;
    }

    .mensagem {
      margin: 10px 0;
      color: #333;
      font-weight: bold;
    }
  </style>
</head>

<body>
  <div class="container">
    <h2>Cadastro de Produtos</h2>

    <?php if ($mensagem != ''): ?>
      <div class="mensagem"><?= htmlspecialchars($mensagem) ?></div>
    <?php endif; ?>

    <!-- Formulário para cadastrar -->
    <form id="cadastro" action="../cont/ct_form_cadastro_produtos.php" method="post">
      <label for="produto">Produto:</label>
      <input type="text" name="produto" id="produto" required />

      <label for="qtd">Quantidade:</label>
      <input type="number" name="qtd" id="qtd" required min="0" />

      <label for="preco">Preço (ex.: 12,90):</label>
      <input type="text" name="preco" id="preco" required />

      <label for="descricao">Descrição:</label>
      <textarea id="descricao" name="descricao" rows="4" placeholder="Escreva a descrição do produto..."></textarea>

      <label for="imagem_path">URL da Imagem:</label>
      <input type="text" name="imagem_path" id="imagem_path" placeholder="https://..." />

      <button type="submit" id="botao">Cadastrar</button>
    </form>

    <!-- Botão voltar -->
    <form action="vi_tab_produtos_checkout_html.php" method="post">
      <button type="submit" class="secondary">Voltar ao Checkout</button>
    </form>
  </div>
</body>
</html>
