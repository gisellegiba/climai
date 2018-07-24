<?php
/***************************************************
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Valida formulário de exclusao de horários
Versão: 1.0
***************************************************/
session_start();
//importa a definição da classe 
require("include/autoload.php");

//para salvar os dados digitados
$_SESSION['form'] = $_GET;
$resultado = Horario::excluir($_GET);

if ($resultado){
	$_SESSION['msg']="Horario excluido com sucesso";
}else{
	$_SESSION['erros'] = $horarios->erros;	
}
header("location:horarios_consultar_resultado.php?id=".$_GET['id']);
exit();
?>
