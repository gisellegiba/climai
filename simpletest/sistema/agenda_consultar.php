<?php
/***************************************************
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Valida formulário de consulta de agenda
Versão: 1.0
***************************************************/
session_start();
//importa a definição da classe 
require("include/autoload.php");

//para salvar os dados digitados
if(!isset($_POST['funcionario_m'])){
	$_POST['funcionario_m']=$_GET['funcionario'];
}
if(!isset($_POST['mes'])){
	$_POST['mes']=$_GET['mes'];
}
if(!isset($_POST['ano'])){
	$_POST['ano']=$_GET['ano'];
}
$_SESSION['form'] = $_POST;
$_SESSION['resultado'] = "";
$resultado = Agenda::consultar($_POST);

//echo $resultado;
//exit();
if ($resultado){
	$_SESSION['resultado'] = $resultado;
}else{
	$_SESSION['erros'] = $agenda->erros;	
}
header("location:agenda_consultar_resultado.php");
exit();
?>
