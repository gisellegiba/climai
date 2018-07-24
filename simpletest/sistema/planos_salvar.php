<?php
/***************************************************
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Valida formulário de cadastro de planos
Versão: 1.0
***************************************************/
session_start();
//importa a definição da classe 
require("include/autoload.php");

//cria o objeto do tipo 
$plano = new Plano($_POST);

//para salvar os dados digitados
$_SESSION['form'] = $_POST;

//se existir erro retorna para página de login
if ($plano->cadastrar()){
	$_SESSION['msg']="Plano salvo com sucesso";
}else{
	$_SESSION['erros'] = $plano->erros;	
}
header("location:planos.php");
exit();
?>
