<!DOCTYPE html>
<?php
// se o email informado para for inválido exibe alerta na tela.
if (isset($_GET['email_invalido']) && $_GET['email_invalido'] == 1) {
  echo "<script>alert('E-mail inválido.');</script>";
}
?>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RECUPERAR SENHA</title>
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
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 450px;
      text-align: center;
    }

    h2 {
      color: #333;
      margin-bottom: 15px;
    }

    .form-group {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      margin-bottom: 15px;
    }

    label {
      font-size: 14px;
      color: #555;
    }

    input {
      flex: 1;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-size: 14px;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #65e62a;
      border: none;
      color: white;
      font-size: 16px;
      cursor: pointer;
      border-radius: 4px;
      transition: background-color 0.3s;
    }

    button:hover {
      background-color: #60bd14;
    }
  </style>
</head>

<body>
  <div class="container">
    <form id="recuperacao_senha" action="../cont/ct_form_recuperar_senha.php" method="post">
      <h2>Recuperação de Senha</h2>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" placeholder="Digite o e-mail cadastrado" name="email" required />
      </div>
      <button type="submit">Enviar</button>
    </form>
  </div>
</body>

</html>