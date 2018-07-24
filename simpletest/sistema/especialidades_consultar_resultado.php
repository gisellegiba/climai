<?php
/***************************************************
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Valida formulário de consulta de Especialidades
Versão: 1.0
***************************************************/
session_start();
//importa a definição da classe 
require("include/autoload.php");

//para salvar os dados digitados
$_SESSION['form'] = $_POST;
$resultado = Especialidade::consultar($_POST);
//echo $resultado;
//exit();
if ($resultado){
	$_SESSION['resultado'] = $resultado;
}else{
	$_SESSION['erros'] = $especialidade->erros;	
}
header("location:especialidades_consultar_resultado2.php");
exit();
?>
