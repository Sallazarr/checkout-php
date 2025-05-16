<?php
// script de conexão com banco

$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "db_pagamento";

$conexao = new mysqli($servidor, $usuario, $senha, $banco);

// validação pra conexão
if ($conexao->connect_error) {
  die("Falha: " . $conexao->connect_error);
}
