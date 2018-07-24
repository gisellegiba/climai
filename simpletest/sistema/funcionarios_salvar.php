<?php
/***************************************************
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Valida formulário de cadastro de funcionarios
Versão: 1.0
***************************************************/
session_start();
//importa a definição da classe 
require("include/autoload.php");

//cria o objeto do tipo 
$funcionario = new Funcionario($_POST);

//para salvar os dados digitados
$_SESSION['form'] = $_POST;

//se existir erro retorna para página de login
if ($funcionario->cadastrar()){
	$_SESSION['msg']="Funcionario salvo com sucesso";
}else{
	$_SESSION['erros'] = $funcionario->erros;	
}
header("location:funcionarios.php");
exit();
?>
