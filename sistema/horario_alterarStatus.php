<?php
/***************************************************
Autor: Giselle Machado
Data: 06/01/2016
Descrição: altera status do Horário Ativo / Inativo
Versão: 1.0
***************************************************/
session_start();
//importa a definição da classe 
require("include/autoload.php");

$retorno = Horario::alterar_situacao($_GET);

//para salvar os dados digitados
$_SESSION['form'] = $_GET;

//se existir erro retorna para página de login
if ($retorno){
  $_SESSION['msg']="Status alterado com sucesso!";
}else{
  $_SESSION['erros'] = $agenda->erros;  
}
header("location:horarios_consultar_resultado.php?idhorario=".$_GET['idhorario']."&id=".$_GET['id']);
exit();
?>
