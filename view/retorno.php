<?php
session_start();

// Verifica se há um payload de transação na sessão
$payload = isset($_SESSION['payload']) ? $_SESSION['payload'] : null;

// Limpa o payload da sessão após exibição para evitar que apareça novamente
unset($_SESSION['payload']);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retorno da Transação</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            width: 500px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border-top: 5px solid #dc3545; /* Borda vermelha para erro */
        }

        h1 {
            color: #dc3545; /* Vermelho para erro */
            margin-bottom: 20px;
        }

        p {
            font-size: 1.1em;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .details {
            background-color: #f8d7da; /* Fundo mais claro para detalhes */
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            padding: 15px;
            margin-top: 20px;
            text-align: left;
            font-size: 0.9em;
            color: #721c24;
        }

        .details strong {
            color: #490e13;
        }

        .btn-back {
            display: inline-block;
            margin-top: 25px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-back:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Transação Rejeitada!</h1>

        <?php if ($payload): ?>
            <p>Houve um problema ao processar sua transação.</p>
            <div class="details">
                <strong>Detalhes da Rejeição:</strong><br>
                <?php if (isset($payload['statusTransaction'])): ?>
                    Status: <?php echo htmlspecialchars($payload['statusTransaction']); ?><br>
                <?php endif; ?>
                <?php if (isset($payload['message'])): ?>
                    Mensagem: <?php echo htmlspecialchars($payload['message']); ?><br>
                <?php endif; ?>
                <?php if (isset($payload['code'])): ?>
                    Código: <?php echo htmlspecialchars($payload['code']); ?><br>
                <?php endif; ?>

                <?php
                // --- NOVAS INFORMAÇÕES DO PAYLOAD: REJECTION CODE E MESSAGE ---
                if (isset($payload['rejectionInfo']) && is_array($payload['rejectionInfo'])) {
                    if (isset($payload['rejectionInfo']['rejectionCode'])) {
                        echo "Código da Rejeição: " . htmlspecialchars($payload['rejectionInfo']['rejectionCode']) . "<br>";
                    }
                    if (isset($payload['rejectionInfo']['rejectionMessage'])) {
                        echo "Mensagem de Rejeição: " . htmlspecialchars($payload['rejectionInfo']['rejectionMessage']) . "<br>";
                    }
                }
                // --- FIM DAS NOVAS INFORMAÇÕES ---


                // --- EXEMPLOS DE COMO EXIBIR OUTRAS INFORMAÇÕES DO PAYLOAD ---
                // Para saber as chaves disponíveis, você pode usar print_r($payload) temporariamente
                // ou consultar a documentação da API de pagamento que você está usando.

                // Exemplo 1: Se houver uma chave 'transactionId' no payload
                if (isset($payload['transactionId'])) {
                    echo "ID da Transação: " . htmlspecialchars($payload['transactionId']) . "<br>";
                }

                // Exemplo 2: Se houver uma chave 'errors' que é um array de erros
                if (isset($payload['errors']) && is_array($payload['errors'])) {
                    echo "Erros Específicos:<br>";
                    echo "<ul>";
                    foreach ($payload['errors'] as $error) {
                        // Assumindo que cada erro pode ter 'code' e 'description'
                        echo "<li>";
                        if (isset($error['code'])) {
                            echo "Código do Erro: " . htmlspecialchars($error['code']) . " - ";
                        }
                        if (isset($error['description'])) {
                            echo htmlspecialchars($error['description']);
                        }
                        echo "</li>";
                    }
                    echo "</ul>";
                }

                // Exemplo 3: Se houver uma chave 'paymentDetails' que é um objeto/array aninhado
                if (isset($payload['paymentDetails']) && is_array($payload['paymentDetails'])) {
                    echo "Detalhes do Pagamento:<br>";
                    if (isset($payload['paymentDetails']['cardType'])) {
                        echo "Tipo de Cartão: " . htmlspecialchars($payload['paymentDetails']['cardType']) . "<br>";
                    }
                    if (isset($payload['paymentDetails']['last4Digits'])) {
                        echo "Últimos 4 Dígitos: " . htmlspecialchars($payload['paymentDetails']['last4Digits']) . "<br>";
                    }
                    // Adicione mais campos de 'paymentDetails' conforme necessário
                }

                // Se quiser exibir o payload completo para depuração (descomente para usar)
                
               /* echo "<hr><strong>Payload Completo (para depuração):</strong><br>";
                echo "<pre>";
                print_r($payload);
                echo "</pre>";
                */
                ?>
            </div>
        <?php else: ?>
            <p>Não foi possível obter detalhes sobre a transação.</p>
            <p>Por favor, tente novamente ou entre em contato com o suporte.</p>
        <?php endif; ?>

        <a href="../view/vi_tab_produtos_checkout_html.php" class="btn-back">Voltar para o Checkout</a>
    </div>
</body>

</html>
