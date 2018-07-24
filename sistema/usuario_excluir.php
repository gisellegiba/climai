<?php
/***************************************************
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Valida formulário de exclusão de usuário
Versão: 1.0
***************************************************/
session_start();
//importa a definição da classe 
require("include/autoload.php");

//para salvar os dados digitados
$_SESSION['form'] = $_GET;
$resultado = Usuario::excluir($_GET);

if ($resultado){
	$_SESSION['msg']="Usuario excluido com sucesso";
}else{
	$_SESSION['erros'] = $usuario->erros;	
}
header("location:usuario.php");
exit();
?>
