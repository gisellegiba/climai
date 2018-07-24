<?php
/***************************************************
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Valida formulário de exclusao de planos
Versão: 1.0
***************************************************/
session_start();
//importa a definição da classe 
require("include/autoload.php");

//para salvar os dados digitados
$_SESSION['form'] = $_GET;
$resultado = Plano::excluir($_GET);

if ($resultado){
	$_SESSION['msg']="Plano excluido com sucesso";
}else{
	$_SESSION['erros'] = $planos->erros;	
}
header("location:planos.php");
exit();
?>
