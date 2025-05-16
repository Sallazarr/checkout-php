<!DOCTYPE html>
<?php
if (!isset($_SESSION)) {
  session_start();
}
if (!isset($_SESSION['usuario_logado'])) {
  header("location:index.php");
}
?>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PAGAMENTO</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #f4f4f4;
    }

    .container {
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      width: 600px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .valor {
      text-align: center;
      font-size: 18px;
    }

    .metodos_pagamento {
      display: flex;
      flex-direction: column;
      text-align: center;
      align-items: center;
    }

    h2,
    h3 {
      margin: 5px 0;
    }

    button {
      padding: 10px;
      border: none;
      border-radius: 5px;
      background-color: #d9dfe6;
      color: rgb(0, 0, 0);
      cursor: pointer;
      font-size: 16px;
      width: 150px;
      margin: 5px 0;
    }

    button:hover {
      background-color: #65e62a;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="valor">
      <h2>VALOR A PAGAR:</h2>
      <h3>
        <!-- puxa o valor total dos produtos da pagina de checkout.-->
        R$ <?php
        if (isset($_POST['total'])) {
          echo number_format($_POST['total'], 2, ',', '.');
        } else {
          echo '0,00';
        }
        ?>
      </h3>
    </div>

    <!-- Botões com métodos de pagamentos. -->
    <div class="metodos_pagamento">
      <h3>MÉTODOS DE PAGAMENTO</h3>
      <form action="../cont/ct_form_pagamento.php" method="post">
        <input type="hidden" name="metodo_pagamento" value="Débito">
        <button type="submit">1 - DÉBITO</button>
      </form>
      <form action="../cont/ct_form_pagamento.php" method="post">
        <input type="hidden" name="metodo_pagamento" value="Crédito à vista">
        <button type="submit">2 - CRÉDITO (vista)</button>
      </form>
      <form action="../cont/ct_form_pagamento.php" method="post">
        <input type="hidden" name="metodo_pagamento" value="PIX">
        <button type="submit">3 - PIX</button>
      </form>
    </div>
</body>

</html>