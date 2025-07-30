<?php
if (!isset($_SESSION)) { session_start(); }
if (!isset($_SESSION['usuario_logado'])) {
    header('Location: index.php');
    exit();
}

require_once('../conf/conexao_db.php');

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header('Location: vi_tab_produtos_checkout_html.php');
    exit();
}
$id = (int)$_GET['id'];

$stmt = $conexao->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    $stmt->close();
    $conexao->close();
    header('Location: vi_tab_produtos_checkout_html.php');
    exit();
}
$produto = $res->fetch_assoc();
$stmt->close();
$conexao->close();

function e($v){ return htmlspecialchars($v ?? '', ENT_QUOTES | ENT_HTML5); }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Editar Produto</title>
  <style>
    body { font-family: Arial, sans-serif; background-color:#f4f4f4; display:flex; align-items:center; justify-content:center; min-height:100vh; margin:0; }
    .container { background:#fff; padding:20px; border-radius:8px; width:500px; box-shadow:0 4px 8px rgba(0,0,0,.1); }
    label { display:block; margin-top:10px; }
    input, textarea { width:100%; padding:8px; margin-top:4px; border:1px solid #ccc; border-radius:4px; box-sizing:border-box; }
    .row { display:flex; gap:10px; }
    .row > div { flex:1; }
    button { margin-top:14px; padding:10px; width:100%; border:none; border-radius:5px; background:#65e62a; color:#fff; font-size:16px; cursor:pointer; }
    button:hover { background:#52b41b; }
    .secondary { background:#d9dfe6; color:#000; }
    .actions { display:flex; gap:10px; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Editar Produto - ID <?= e($produto['id']) ?></h2>

    <form action="../cont/ct_form_editar_produtos.php" method="post">
      <input type="hidden" name="id" value="<?= e($produto['id']) ?>" />

      <label for="produto">Nome do Produto:</label>
      <input type="text" id="produto" name="produto" required value="<?= e($produto['produto']) ?>" />

      <div class="row">
        <div>
          <label for="quantidade">Quantidade:</label>
          <input type="number" id="quantidade" name="quantidade" required min="0" value="<?= e($produto['quantidade']) ?>" />
        </div>
        <div>
          <label for="preco">Preço (ex: 12,90):</label>
          <input type="text" id="preco" name="preco" required value="<?= number_format((float)$produto['preco'], 2, ',', '.') ?>" />
        </div>
      </div>

      <label for="descricao">Descrição:</label>
      <textarea id="descricao" name="descricao" rows="4"><?= e($produto['descricao'] ?? '') ?></textarea>

      <label for="imagem_path">URL da Imagem:</label>
      <input type="text" id="imagem_path" name="imagem_path" value="<?= e($produto['imagem_path'] ?? '') ?>" />

      <div class="actions">
        <button type="submit">Salvar Alterações</button>
        <a class="secondary" href="vi_tab_produtos_checkout_html.php" style="text-decoration:none; display:inline-block; text-align:center; padding:10px; border-radius:5px; flex:1;">
            Voltar
        </a>
      </div>
    </form>
  </div>
</body>
</html>
