<?php
/***************************************************
Autor: Giselle Machado
Data: 01/04/2012
Descrição: Valida formulário de cadastro de paciente
Versão: 1.0
***************************************************/
session_start();
//importa a definição da classe 
require("include/autoload.php");

//cria o objeto do tipo 
$paciente = new Paciente($_POST);

//para salvar os dados digitados
$_SESSION['form'] = $_POST;

//echo $paciente->alterar();
//exit();

//se existir erro retorna para página de login
if ($paciente->alterar()){
	$_SESSION['msg']="Paciente alterado com sucesso!";
}else{
	$_SESSION['erros'] = $paciente->erros;	
}
header("location:pacientes.php");
exit();
?>
