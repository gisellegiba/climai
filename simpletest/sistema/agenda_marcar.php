<?php
/***************************************************
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Valida formulário de cadastro de Agendamento
Versão: 1.0
***************************************************/
session_start();
//importa a definição da classe 
require("include/autoload.php");

$retorno = Agenda::alterar_situacao($_GET);

//para salvar os dados digitados
$_SESSION['form'] = $_GET;

//se existir erro retorna para página de login
if ($retorno){
	$_SESSION['msg']="Situa&ccedil;&atilde;o alterada com sucesso!";
}else{
	$_SESSION['erros'] = $agenda->erros;	
}
header("location:agenda_consultar.php?funcionario=".$_GET['funcionario']."&mes=".$_GET['mes']."&ano=".$_GET['ano']);
exit();
?>
