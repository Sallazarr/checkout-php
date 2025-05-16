<?php

/**
 * funcao pra capturar o metodo de pagamento e chamar a funcao que realiza a requisição.                     
 */
function paymentType($post)
{
    require_once("api/chamaTransacao.php");
    if (isset($post)) {
        if ($post === "debito")
            chamaTransacao($_SESSION['totalzao'], "DEBIT");

        if ($post === "credito")
            chamaTransacao($_SESSION['totalzao'], "CREDIT");
    }
}

?>