<?php
/*
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Formulário de resultado de consulta de agenda
Versão: 1.0
*/

require('include/verificar_usuario.php');
$menu='agenda';
include('include/topo.php'); 

//importa a definição da classe Afiliado
require("include/autoload.php");
//error_reporting("E_ALL ~E_NOTICE");

//recupera as mensagens de erros
$erros = (empty($_SESSION['erros']))?array():$_SESSION['erros'];
$msg = (empty($_SESSION['msg']))?"":$_SESSION['msg'];

unset($_SESSION['erros']);
unset($_SESSION['msg']);
unset($_SESSION['form']);
?>

<head>
	<title>Resultado da consulta de Agenda</title>
</head>
<body id="public">
	<div class="info"><br/>
		<h2>Resultado da Consulta de Agenda</h2>
	</div>
	<ul>
		<label class="desc" id="title1" for="Field1">
			<center><?php echo $_SESSION['resultado']; ?></center>
		</label>
	</ul>
