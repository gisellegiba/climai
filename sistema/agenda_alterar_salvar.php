<?php
/***************************************************
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Valida formulário de cadastro de funcionarios
Versão: 1.0
***************************************************/
session_start();
//importa a definição da classe 
require("include/autoload.php");

//para salvar os dados digitados
$_SESSION['form'] = $_POST;

$resultado = Agenda::alterar_observacao($_POST);

//se existir erro retorna para página de login
if ($resultado){
	$_SESSION['msg']="Agenda alterada com sucesso";
}
header("location:agenda_consultar.php?funcionario=".$_POST['funcionario']."&observacao=".$_POST['observacao']."&mes=".$_POST['mes']."&ano=".$_POST['ano']);
exit();
?>
