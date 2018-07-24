<?php
/***************************************************
Autor: Giselle Machado
Data: 05/09/2015
Descrição: Valida formulário de consulta serviço
Versão: 1.0
***************************************************/
session_start();
//importa a definição da classe 
require("include/autoload.php");

//para salvar os dados digitados
if(!isset($_POST['paciente'])){
	$_POST['paciente']=$_GET['paciente'];
}

$_SESSION['form'] = $_POST;
$_SESSION['resultado'] = "";

//print_r($_GET);
//exit();
$resultado = Servico::consultar($_POST);

//echo $resultado;

if ($resultado){
	$_SESSION['resultado'] = $resultado;
}else{
	$_SESSION['erros'] = $agenda->erros;	
}
header("location:servico_consultar_resultado.php");
exit();
?>
