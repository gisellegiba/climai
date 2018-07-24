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

//cria o objeto do tipo 
$agenda = new Agenda($_POST);

//para salvar os dados digitados
$_SESSION['form'] = $_POST;

//se existir erro retorna para página de login
if ($agenda->cadastrar()){
	$_SESSION['msg']="Agendamento salvo com sucesso";
}else{
	$_SESSION['erros'] = $agenda->erros;	
}
header("location:agenda_consultar.php?funcionario=".$_POST['funcionario_m']."&mes=".$_POST['mes']."&ano=".$_POST['ano']);
exit();
?>
