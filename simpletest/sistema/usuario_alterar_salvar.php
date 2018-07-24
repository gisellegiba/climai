<?php
/***************************************************
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Valida formulário de cadastro de usuários
Versão: 1.0
***************************************************/
session_start();
//importa a definição da classe 
require("include/autoload.php");

//cria o objeto do tipo 
$usuario = new Usuario($_POST);

//para salvar os dados digitados
$_SESSION['form'] = $_POST;

//echo $usuario->alterar();
//exit();

//se existir erro retorna para página de login
if ($usuario->alterar()){
	$_SESSION['msg']="Usuario alterado com sucesso!";
}else{
	$_SESSION['erros'] = $usuario->erros;	
}
header("location:usuario.php");
exit();
?>
