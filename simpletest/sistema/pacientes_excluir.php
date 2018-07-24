<?php
/***************************************************
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Valida formulário de exclusao de pacientes
Versão: 1.0
***************************************************/
session_start();
//importa a definição da classe 
require("include/autoload.php");

//para salvar os dados digitados
$_SESSION['form'] = $_GET;
$resultado = Paciente::excluir($_GET);

if ($resultado){
	$_SESSION['msg']="Paciente excluido com sucesso";
}else{
	$_SESSION['erros'] = $paciente->erros;	
}
header("location:pacientes.php");
exit();
?>
