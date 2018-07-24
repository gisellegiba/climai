<?php
/***************************************************
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Valida formulário de cadastro de Especialidades
Versão: 1.0
***************************************************/
session_start();
//importa a definição da classe 
require("include/autoload.php");

//cria o objeto do tipo 
$especialidade = new Especialidade($_POST);

//para salvar os dados digitados
$_SESSION['form'] = $_POST;

//se existir erro retorna para página de login
if ($especialidade->cadastrar()){
	$_SESSION['msg']="Especialidade salva com sucesso";
}else{
	$_SESSION['erros'] = $especialidade->erros;	
}
header("location:especialidades.php");
exit();
?>
