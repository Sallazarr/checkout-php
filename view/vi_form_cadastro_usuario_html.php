<!DOCTYPE html>
<?php
// Exibe um alerta se o email para cadastro já existir na base de dados.
if (isset($_GET['email_repetido']) && $_GET['email_repetido'] == 1) {
  echo "<script>alert('Email já existe na base dados!');</script>";
}
// se houver erro na query de cadastro, exibe a descrição do erro.
if (isset($_GET['erro'])) {
  echo "Erro: " . $_GET['erro'];
}
?>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CADASTRO USUÁRIO</title>
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
      max-width: 400px;
    }

    h2 {
      text-align: center;
      color: #333;
    }

    label {
      font-size: 14px;
      color: #555;
      margin-bottom: 5px;
      display: block;
    }

    input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ddd;
      border-radius: 4px;
      box-sizing: border-box;
      font-size: 14px;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #28a745;
      border: none;
      color: white;
      font-size: 16px;
      cursor: pointer;
      border-radius: 4px;
      transition: background-color 0.3s;
    }

    button:hover {
      background-color: #218838;
    }
  </style>
</head>

<body>
  <div class="container">
    <!-- Só envia o form se a função retornar 'true'-->
    <form id="cadastro" action="../cont/ct_form_cadastro_usuario.php" method="post" onsubmit="return verificaSenha()">
      <h2>CADASTRO DE USUÁRIO</h2>
      <label for="name">Nome:</label>
      <input type="text" id="name" name="name" required />
      <label for="email">E-mail:</label>
      <input type="email" id="email" name="email" required />
      <label for="senha">Senha:</label>
      <input type="password" id="senha" name="senha" required />
      <label for="senha_confirma">Confirma senha:</label>
      <input type="password" id="senha_confirma" name="senha_confirma" required />
      <button type="submit" id="cadastrar">CADASTRAR</button>
    </form>
  </div>
  <script>
    // Função pra validar se as senhas digitadas são iguais.
    function verificaSenha() {
      let senha = document.getElementById("senha").value;
      let senha_confirma = document.getElementById("senha_confirma").value;

      if (senha !== senha_confirma) {
        alert("As senhas não conferem.");
        return false;
      }
      return true;
    }
  </script>
</body>

</html>