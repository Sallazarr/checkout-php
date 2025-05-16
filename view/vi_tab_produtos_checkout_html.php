<!DOCTYPE html>
<?php
if (!isset($_SESSION)) {
  session_start();
}

if (!isset($_SESSION['usuario_logado'])) {
  header("Location: index.php");
}

// Aciona o script que busca todos os produtos no banco.
if (!isset($_SESSION["todos_produtos"])) {
  header('Location: ../cont/ct_tab_consulta_produtos_checkout.php');
  exit();
}

// Exibe alerta se for tentado finalizar uma venda com carrinho vazio.
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
      /*até eu descobrir que esse era o problema das tabelas não estarem cabendo na página... :( */
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

    th,
    td {
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

    /* CATEI NA INTERNET COMO FAZER ESSE ESITLO.
       O BLOCO ABAIXO É ESTILIZAÇÃO DA TABELA QUE MOSTRAOS PRODUTOS NA TELA PARA O OPERADOR.*/
    .produtos-container {
      max-height: 300px;
      overflow-y: auto;
      margin-bottom: 20px;
      border: 1px solid #ddd;
      border-radius: 4px;
    }
  </style>
</head>

<body>
  <div class="container">
    <h2>FARMACIA ZULU - PDV Mauricio 1.0 BETA</h2>
    <div class="produtos-container">
      <h3>Produtos (ID Referência)</h3>

      <!-- Tabela que mostra os produtos na tela para consulta do operador. -->
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Produto</th>
            <th>Preço Unitário</th>
          </tr>
        </thead>
        <tbody>
          <!-- Cria a tabela na tela com todos os produtos que foram passados para a variavel de sessão
           em 'ct_tab_consulta_produtos_checkout.php'. -->
          <?php
          foreach ($_SESSION['todos_produtos'] as $produto) {
            echo "
                  <tr>
                    <td>{$produto['id']}</td>
                    <td>{$produto['produto']}</td>
                    <td>R$ " . number_format($produto['preco'], 2, ',', '.') . "</td>
                  </tr>";
          }
          ?>
        </tbody>
      </table>
    </div>

    <!-- tabela que vai receber os produtos que estão sendo adicionados no carrinho. -->
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Produto</th>
          <th>Preço</th>
        </tr>
      </thead>
      <tbody>
        <!-- Lógica pra inserir os produtos na tabela (carrinho), e guardar a soma do valor total. -->
        <?php
        $total = 0;

        if (isset($_SESSION['produtos'])) {
          foreach ($_SESSION['produtos'] as $produto) {
            echo "
                  <tr>
                      <td>{$produto['id']}</td>
                      <td>{$produto['produto']}</td>
                      <td>R$ " . number_format($produto['preco'], 2, ',', '.') . "</td>
                  </tr>";
            $total += $produto['preco'];
          }
        }
        ?>
      </tbody>
    </table>

    <!-- Botão pra buscar o produto no banco pelo ID. -->
    <form action="../cont/ct_tab_produtos_checkout.php" id="form" method="post">
      <label for="id">ID:</label>
      <input type="number" id="id" name="id" required />
      <button type="submit" id="adicionar">Adicionar</button>
    </form>

    <!--mostrar o valor total dos produtos-->
    <div id="total">
      TOTAL: R$ <?php echo number_format($total, 2, ',', '.'); ?>
    </div>

    <!-- Botão pra enviar o valor total para página de pagamento. -->
    <form action="../view/vi_form_pagamento_html.php" method="post">
      <input type="hidden" name="total" value="<?php echo $total; ?>">
      <button id="pagar" type="submit">Finalizar</button>
    </form>

    <!-- Botão de logoff -->
    <form action="../cont/ct_logout.php" method="post">
      <button type="submit" id="logout">Logoff</button>
    </form>

    <form action="vi_form_cadastro_produtos_html.php" method="post">
      <button type="submit" id="cadastro_produtos">Cadastrar produtos</button>
    </form>
  </div>
</body>

</html>