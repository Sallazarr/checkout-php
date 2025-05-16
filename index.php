<?php
// exibe alerta de cadastro realizado.
if (isset($_GET['cadastro']) && $_GET['cadastro'] == 1) {
  echo "<script>alert('Cadastro realizado! Voltando para a tela de login.');</script>";
}

// exibe alerta se as credenciais inseridas estiverem incorretas.
if (isset($_GET['credenciais_incorretas']) && $_GET['credenciais_incorretas'] == 1) {
  echo "<script>alert('Email ou senha incorretos!');</script>";
}
// exibe nova senha gerada se o usuário solicitar recuperação de senha.
if (isset($_GET['nova_senha'])) {
  echo "<script>alert('Sua senha temporária é: " . $_GET['nova_senha'] . ".Voltando para a tela de login.');</script>";
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>LOGIN</title>
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
      text-align: center;
      width: 350px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    h2 {
      margin-bottom: 20px;
      color: #333;
    }

    label {
      display: block;
      font-size: 14px;
      color: #555;
      text-align: left;
      margin-top: 10px;
    }

    input {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }

    button {
      width: 100%;
      padding: 12px;
      margin-top: 15px;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      transition: 0.3s;
    }

    #botao {
      background-color: #65e62a;
      color: #000;
    }

    #botao:hover {
      background-color: #4cb91f;
    }

    #botao2,
    #criar_conta {
      background-color: #d9dfe6;
      color: #000;
    }

    #botao2:hover,
    #criar_conta:hover {
      background-color: #b0b7bf;
    }
  </style>
</head>

<body>
  <div class="container">
    <form name="login" action="cont/ct_form_login.php" method="post">
      <h2>FAÇA LOGIN</h2>
      <label for="email">E-mail:</label>
      <input name="email" type="email" id="email" required />
      <label for="senha">Senha:</label>
      <input name="password" type="password" id="senha" required />

      <button type="submit" id="botao">Logar</button>

      <a href="view/vi_form_recuperar_senha_html.php">
        <button type="button" id="botao2">Esqueci a senha</button>
      </a>

      <a href="view/vi_form_cadastro_usuario_html.php">
        <button type="button" id="criar_conta">Criar conta</button>
      </a>
    </form>
  </div>
</body>

</html>