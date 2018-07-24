<?php
/***************************************************
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Valida formulário de cadastro de pacientes
Versão: 1.0
***************************************************/
session_start();
//importa a definição da classe 
require("include/autoload.php");

//cria o objeto do tipo 
$paciente = new Paciente($_POST);

//para salvar os dados digitados
$_SESSION['form'] = $_POST;

//se existir erro retorna para página de login
if ($paciente->cadastrar()){
	$_SESSION['msg']="Paciente salvo com sucesso";
}else{
	$_SESSION['erros'] = $paciente->erros;	
}
header("location:pacientes.php");
exit();
?>
