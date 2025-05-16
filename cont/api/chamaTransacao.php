<?php
/**
 * funcao que faz a requisicao de pagamento para a payer.
 */
function chamaTransacao($value, $paymentType)
{
    $payload = [
        'command' => 'payment',                     // comando de pagamento
        'value' => $value,                          // valor da transação
        'paymentMethod' => 'CARD',                  // meio de pagamento (cartao, pix, link)
        'paymentType' => $paymentType,              // metodo de pagamento (debito, credito)
        'paymentMethodSubType' => 'FULL_PAYMENT'    // a vista
    ];

    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/json\r\n",
            'content' => json_encode($payload)
        ]
    ]);

    $response = @file_get_contents("http://localhost:6060/Client/request", false, $context);

    if ($response != true) {
        throw new Exception("Requisição de pagamento falhou.");
    }
}
?>