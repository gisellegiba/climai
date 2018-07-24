<?php
/***************************************************
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Valida formulário de consulta de funcionarios
Versão: 1.0
***************************************************/
session_start();
//importa a definição da classe 
require("include/autoload.php");

//para salvar os dados digitados
$_SESSION['form'] = $_POST;
$resultado = Funcionario::consultar($_POST);

if ($resultado){
	$_SESSION['resultado'] = $resultado;
}else{
	$_SESSION['erros'] = $funcionarios->erros;	
}
header("location:funcionarios_consultar_resultado2.php");
exit();
?>
