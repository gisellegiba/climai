<?php
/***************************************************
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Valida formulário de consulta de horários
Versão: 1.0
***************************************************/
session_start();
//importa a definição da classe 
require("include/autoload.php");

//para salvar os dados digitados
if(!isset($_POST['funcionario'])){
	$_POST['funcionario']=$_SESSION['usuario_matricula'];
}

$_SESSION['form'] = $_POST;
$resultado = Horario::consultar($_POST);

if ($resultado){
	$_SESSION['resultado'] = $resultado;
}else{
	$_SESSION['erros'] = $plano->erros;	
}
header("location:horarios_consultar_resultado2.php");
exit();
?>
