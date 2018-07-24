<?php
/*
Autor: Giselle Machado
Data: 22/05/2011
Descrição: Formulário de cadastro de despesas
Versão: 1.0
*/

require('include/verificar_usuario.php');
$menu='consultas_gerenciais';
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
	<title>Resultado da consulta</title>
</head>
<body id="public">
	<div class="info"><br/>
		<h2>Resultado da Consulta (<?php echo 'Tipo de pesquisa: '.$_SESSION['tipo'].' periodo: '.$_SESSION['ano'].'/'.$_SESSION['mes']; ?>)</h2>
	</div>
	<ul>
		<label class="desc" id="title1" for="Field1">
			<center>
				<?php 
					echo $_SESSION['resultado_consulta'];
				?>
			</center>
		</label>
	</ul>

	
	
