<?php
/***************************************************
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Valida formulário de exclusao de funcionarios
Versão: 1.0
***************************************************/
session_start();
//importa a definição da classe 
require("include/autoload.php");

//para salvar os dados digitados
$_SESSION['form'] = $_GET;
$resultado = Funcionario::excluir($_GET);

if ($resultado){
	$_SESSION['msg']="Funcionario excluido com sucesso";
}else{
	$_SESSION['erros'] = $funcionarios->erros;	
}
header("location:funcionarios.php");
exit();
?>
