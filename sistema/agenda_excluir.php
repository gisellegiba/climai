<?php
/***************************************************
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Valida formulário de exclusao de agendamento
Versão: 1.0
***************************************************/
session_start();
//importa a definição da classe 
require("include/autoload.php");

//para salvar os dados digitados
$_SESSION['form'] = $_GET;
$resultado = Agenda::excluir($_GET);

if ($resultado){
	$_SESSION['msg']="Agendamento excluido com sucesso";
}else{
	$_SESSION['erros'] = $agenda->erros;	
}
header("location:agenda_consultar.php?funcionario=".$_GET['funcionario']."&mes=".$_GET['mes']."&ano=".$_GET['ano']);
exit();
?>
