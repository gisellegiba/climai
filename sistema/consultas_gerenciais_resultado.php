<?php
/***************************************************
Autor: Giselle Machado
Data: 22/05/2011
Descrição: Valida formulário de cadastro de despesas
Versão: 1.0
***************************************************/
session_start();
//importa a definição da classe 
require("include/autoload.php");

//para salvar os dados digitados
$_SESSION['form'] = $_POST;
if($_POST['tipo'] == 'mensal'){
	$resultado_consulta = Servico::consulta_mensal($_POST);
}else{
	$resultado_consulta = "Anual";
}
$_SESSION['resultado_consulta'] = $resultado_consulta;
$_SESSION['ano'] = $_POST['ano'];
$_SESSION['mes'] = $_POST['mes'];
$_SESSION['tipo'] = $_POST['tipo'];
$_SESSION['funcionario'] = $_POST['funcionario'];
	
header("location:consultas_gerenciais_resultado2.php");
exit();
?>
