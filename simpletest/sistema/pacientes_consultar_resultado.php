<?php
/***************************************************
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Valida formulário de consulta de pacientes
Versão: 1.0
***************************************************/
session_start();
//importa a definição da classe 
require("include/autoload.php");

//para salvar os dados digitados
$_SESSION['form'] = $_POST;
$resultado = Paciente::consultar($_POST);

if ($resultado){
	$_SESSION['resultado'] = $resultado;
}else{
	$_SESSION['erros'] = $paciente->erros;	
}
header("location:pacientes_consultar_resultado2.php");
exit();
?>
