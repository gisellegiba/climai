<?php
/*
Autor: Giselle Machado
Data: 22/05/2011
Descrição: Formulário de login
Versão: 1.0
*/
//abre a sessão com o usuário
session_start();
//importa a definição da classe Afiliado
require("include/autoload.php");
//error_reporting("E_ALL ~E_NOTICE");

//recupera dados digitados pelo usuário
$usuario = new Usuario($_POST);

$usuarioLogado = $usuario->logar();
if ($usuarioLogado === false){
	$_SESSION['form'] = $_POST;
	$_SESSION['erros']=$usuario->erros;
	header("location:index.php");
	exit();
}elseif(($usuarioLogado['login'] == $usuario->login) && 
	   ($usuarioLogado['senha'] == $usuario->senha)){
	//variável para controlar se o usuário está logado ou não   
	$_SESSION['usuario_logado'] = $usuarioLogado['id'];
	$_SESSION['usuario_perfil'] = $usuarioLogado['perfil'];
	$_SESSION['usuario_matricula'] = $usuarioLogado['matricula'];
	header("location:main.php");
	exit();
}
?>