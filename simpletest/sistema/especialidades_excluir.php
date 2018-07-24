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
$resultado = Especialidade::excluir($_GET);

if ($resultado){
	$_SESSION['msg']="Especialidade excluida com sucesso";
}else{
	$_SESSION['erros'] = $especialidades->erros;	
}
header("location:especialidades.php");
exit();
?>
