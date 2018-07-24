<?php
/***************************************************
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Valida formulário de cadastro de horários
Versão: 1.0
***************************************************/
session_start();
//importa a definição da classe 
require("include/autoload.php");

//cria o objeto do tipo 
$horario = new Horario($_POST);

//para salvar os dados digitados
$_SESSION['form'] = $_POST;

//se existir erro retorna para página de login
if ($horario->cadastrar()){

	$_SESSION['msg']="Horario salvo com sucesso";
}else{
	$_SESSION['erros'] = $horario->erros;	
}
header("location:horarios_consultar_resultado.php?id=".$_POST['funcionario']);
exit();
?>
