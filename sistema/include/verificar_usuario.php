<?php 
//verificar se o usuário está logados
session_start();

if (empty($_SESSION['usuario_logado'])){
	$_SESSION['erros'] = array('usuario'=>'Usuário não está; logado!');
	header('location:index.php');
	exit();
}
?>