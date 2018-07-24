<?php
/*
Autor: Giselle Machado
Data: 05/09/2015
Descrição: Formulário de resultado de consulta de serviço
Versão: 1.0
*/

require('include/verificar_usuario.php');
$menu='servicos';
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
	<title>Resultado da consulta de Servi&ccedil;o</title>
</head>
<body id="public">
	<div class="info"><br/>
		<h2>Resultado da Consulta de Servi&ccedil;o</h2>
	</div>
	<ul>
		<label class="desc" id="title1" for="Field1">
			<center><?php echo $_SESSION['resultado']; ?></center>
		</label>
	</ul>
