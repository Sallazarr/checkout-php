<!DOCTYPE html>
<?php
if (!isset($_SESSION)) {
  session_start();
}

if (!isset($_SESSION['usuario_logado'])) {
  header("Location: index.php");
  exit();
}

/* Carrega SEMPRE os produtos do banco (opção 2) */
require_once('../conf/conexao_db.php');
$result = $conexao->query("SELECT * FROM produtos ORDER BY id");
$_SESSION['todos_produtos'] = [];
while ($row = $result->fetch_assoc()) {
  $_SESSION['todos_produtos'][] = $row;
}
$conexao->close();

/* Alerta carrinho vazio */
if (isset($_GET['carrinho_vazio']) && $_GET['carrinho_vazio'] == '1') {
  echo "<script>alert('Carrinho vazio! Adicione produtos antes de finalizar.');</script>";
}
?>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CHECKOUT</title>
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
      width: 800px;
      text-align: center;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    th, td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: center;
    }

    th {
      background-color: #f0f0f0;
    }

    input {
      padding: 8px;
      margin: 5px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    button {
      padding: 10px;
      border: none;
      border-radius: 5px;
      background-color: #d9dfe6;
      cursor: pointer;
      font-size: 16px;
      margin: 2px;
    }

    button:hover {
      background-color: #65e62a;
    }

    #total {
      font-size: 20px;
      font-weight: bold;
      margin-top: 10px;
    }

    #pagar {
      background-color: #65e62a;
    }

    .produtos-container {
      max-height: 300px;
      overflow-y: auto;
      margin-bottom: 20px;
      border: 1px solid #ddd;
      border-radius: 4px;
    }

    /* MODAL */
    .modal {
      display: none;
      position: fixed;
      z-index: 999;
      padding-top: 60px;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0,0,0,0.4);
    }

    .modal-content {
      background-color: #fff;
      margin: auto;
      padding: 20px;
      border-radius: 8px;
      width: 60%;
      box-shadow: 0 5px 10px rgba(0,0,0,0.3);
    }

    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
    }

    .close:hover { color: #000; }
  </style>
</head>

<script>
  function abrirModal(id) {
    document.getElementById('modal-' + id).style.display = 'block';
  }

  function fecharModal(id) {
    document.getElementById('modal-' + id).style.display = 'none';
  }

  window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
      event.target.style.display = "none";
    }
  }
</script>

<body>
  <div class="container">
    <h2>FARMACIA VanPel - PDV</h2>
    <div class="produtos-container">
      <h3>Produtos (ID Referência)</h3>

      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Imagem</th>
            <th>Produto</th>
            <th>Preço Unitário</th>
            <th>Saiba Mais</th>
            <th>Editar</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($_SESSION['todos_produtos'] as $produto) {
            $id = (int)$produto['id'];
            $nome = htmlspecialchars($produto['produto'] ?? '', ENT_QUOTES | ENT_HTML5);
            $img = htmlspecialchars($produto['imagem_path'] ?? '', ENT_QUOTES | ENT_HTML5);
            $preco = number_format((float)$produto['preco'], 2, ',', '.');
            $descricao = htmlspecialchars($produto['descricao'] ?? 'Sem descrição disponível', ENT_QUOTES | ENT_HTML5);

            echo "
              <tr>
                <td>{$id}</td>
                <td><img src='{$img}' alt='{$nome}' style='width: 50px; height: 50px; object-fit: cover;'></td>
                <td>{$nome}</td>
                <td>R$ {$preco}</td>
                <td><button onclick=\"abrirModal('{$id}')\">Saiba mais</button></td>
                <td><a href='vi_form_editar_produtos_html.php?id={$id}'>Editar</a></td>
              </tr>

              <div id='modal-{$id}' class='modal'>
                <div class='modal-content'>
                  <span class='close' onclick=\"fecharModal('{$id}')\">&times;</span>
                  <h3>{$nome}</h3>
                  <p>{$descricao}</p>
                </div>
              </div>
            ";
          }
          ?>
        </tbody>
      </table>
    </div>

    <!-- Carrinho -->
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Produto</th>
          <th>Preço</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $total = 0;
        if (isset($_SESSION['produtos'])) {
          foreach ($_SESSION['produtos'] as $p) {
            $pid = (int)$p['id'];
            $pnome = htmlspecialchars($p['produto'] ?? '', ENT_QUOTES | ENT_HTML5);
            $ppreco = (float)$p['preco'];
            echo "
              <tr>
                <td>{$pid}</td>
                <td>{$pnome}</td>
                <td>R$ " . number_format($ppreco, 2, ',', '.') . "</td>
              </tr>
            ";
            $total += $ppreco;
          }
          $_SESSION['totalzao'] = $total;
        }
        ?>
      </tbody>
    </table>

    <!-- Adicionar por ID -->
    <form action="../cont/ct_tab_produtos_checkout.php" id="form" method="post">
      <label for="id">ID:</label>
      <input type="number" id="id" name="id" required />
      <button type="submit" id="adicionar">Adicionar</button>
    </form>

    <!-- Total -->
    <div id="total">
      TOTAL: R$ <?php echo number_format($total, 2, ',', '.'); ?>
    </div>

    <!-- Pagamento -->
    <form action="../view/vi_form_pagamento_html.php" method="post">
      <input type="hidden" name="total" value="<?php echo $total; ?>">
      <button id="pagar" type="submit">Finalizar</button>
    </form>

    <!-- Logoff -->
    <form action="../cont/ct_logout.php" method="post">
      <button type="submit" id="logout">Logoff</button>
    </form>

    <!-- Cadastro -->
    <form action="vi_form_cadastro_produtos_html.php" method="post">
      <button type="submit" id="cadastro_produtos">Cadastrar produtos</button>
    </form>
  </div>
</body>
</html>
