<?php
/***************************************************
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Valida formulário de alteração de serviço
Versão: 1.0
***************************************************/
session_start();
//importa a definição da classe 
require("include/autoload.php");

//cria o objeto do tipo 
$servico = new Servico($_POST);

//para salvar os dados digitados
$_SESSION['form'] = $_POST;

//$servico->alterar();
//echo $servico->descricao;
//print_r($_POST);
//exit();


//se existir erro retorna para página de login
if ($servico->alterar()){
	$_SESSION['msg']="Servico alterado com sucesso!";
}else{
	$_SESSION['erros'] = $servico->erros;	
}
header("location:servico_consultar.php?paciente=".$_POST['paciente']);
exit();
?>
