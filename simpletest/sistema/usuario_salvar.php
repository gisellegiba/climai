<?php
/***************************************************
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Valida formulário de cadastro de usuário
Versão: 1.0
***************************************************/
session_start();
//importa a definição da classe Afiliado
require("include/autoload.php");

//cria o objeto do tipo Afiliado e salva na variável $afiliado

$funcionario = $_POST['funcionario'];
$_POST['especialidade'] = Funcionario::funcionario_especialidade($funcionario);

//para salvar os dados que o usuário digitou
$_SESSION['form'] = $_POST;
$usuario = new Usuario($_POST);

//se existir erro retorna para página de login
if ($usuario->cadastrar()){
	$_SESSION['msg']="Usu&aacute;rio salvo com sucesso";
}else{
	$_SESSION['erros'] = $usuario->erros;	
}
header("location:usuario.php");
exit();
?>
