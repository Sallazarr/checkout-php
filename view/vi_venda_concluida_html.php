<!DOCTYPE html>
<?php
if (!isset($_SESSION)) {
  session_start();
}
if (!isset($_SESSION['usuario_logado'])) {
  header("Location: index.php");
}
?>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <title>Venda Concluída</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .container {
      background-color: #fff;
      padding: 30px 40px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    h2 {
      color: #4caf50;
      margin-bottom: 10px;
    }

    p {
      font-size: 18px;
      margin-bottom: 20px;
    }

    a {
      display: inline-block;
      padding: 10px 20px;
      background-color: #65e62a;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    a:hover {
      background-color: #4cb91a;
    }
  </style>
</head>

<body>
  <div class="container">
    <h2>✅ Venda Concluída!</h2>
    <p>O pagamento foi registrado com sucesso.</p>
    <a href="vi_tab_produtos_checkout_html.php">Nova venda</a>
  </div>
</body>

</html>