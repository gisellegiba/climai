<?php 
/*
Autor: Giselle Machado
Data: 22/05/2011
Descrição: Para sair do login
Versão: 1.0
*/
//início da sessão
session_start();
//apaga todas as variáveis de sessão
session_destroy();
header('location:index.php');
exit();
?>