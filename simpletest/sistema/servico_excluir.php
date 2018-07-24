<?php
/***************************************************
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Valida formulário de exclusao de especialidades
Versão: 1.0
***************************************************/
session_start();
//importa a definição da classe 
require("include/autoload.php");

//para salvar os dados digitados
$_SESSION['form'] = $_GET;
$resultado = Servico::excluir($_GET);

if ($resultado){
	$_SESSION['msg']="Servico excluido com sucesso";
}
//print_r($_GET);
//echo $_GET['paciente'];
//exit();
header("location:servico_consultar.php?paciente=".$_GET['paciente']."&mes=".$_GET['mes']."&ano=".$_GET['ano']);
exit();
?>
