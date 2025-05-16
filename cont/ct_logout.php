<?php

/**
 * Script pra realizar o logoff do sistema.
 */
session_start();
session_unset();
session_destroy();

header("Location: ../index.php");
exit();
?>