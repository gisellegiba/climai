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

$paciente = $_POST['paciente'];
$_POST['plano'] = Paciente::seleciona_plano_paciente($paciente);

//para salvar os dados que o usuário digitou
$_SESSION['form'] = $_POST;
$servico = new Servico($_POST);

//se existir erro retorna para página de login
if ($servico->cadastrar()){
	$_SESSION['msg']="Servi&ccedil;o salvo com sucesso";
//	echo "aqui";
//	exit();
}else{
	$_SESSION['erros'] = $servico->erros;	
}
$mes_atual = date('m');
$ano_atual = date('Y');
$_POST['mes'] = $mes_atual;
$_POST['ano'] = $ano_atual;
//print_r($_POST);
//exit();
header("location:servico_consultar.php?paciente=".$_POST['paciente']."&mes=".$_POST['mes']."&ano=".$_POST['ano']);
exit();
?>
