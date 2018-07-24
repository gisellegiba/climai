<?php
/*
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Formulário de consulta de funcionarios
Versão: 1.0
*/

require('include/verificar_usuario.php');
$menu='pacientes';
include('include/topo.php'); 

//importa a definição da classe Afiliado
require("include/autoload.php");
//error_reporting("E_ALL ~E_NOTICE");

$login['login'] ="";
$resultado = Paciente::consultar($login);
//echo $resultado;
//exit();
if ($resultado){
	$_SESSION['resultado'] = $resultado;
}else{
	$_SESSION['erros'] = $pacientes->erros;	
}
header("location:pacientes_consultar_resultado2.php");
exit();

?>