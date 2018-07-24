<?php
/*
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Formulário de consulta de especialidades
Versão: 1.0
*/

require('include/verificar_usuario.php');
$menu='planos';
include('include/topo.php'); 

//importa a definição da classe Afiliado
require("include/autoload.php");
//error_reporting("E_ALL ~E_NOTICE");

$login['login'] ="";
$resultado = Plano::consultar($login);

if ($resultado){
	$_SESSION['resultado'] = $resultado;
}else{
	$_SESSION['erros'] = $planos->erros;	
}
header("location:planos_consultar_resultado2.php");
exit();

?>