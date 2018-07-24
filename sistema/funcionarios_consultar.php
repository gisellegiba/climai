<?php
/*
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Formulário de consulta de funcionarios
Versão: 1.0
*/

require('include/verificar_usuario.php');
$menu='funcionarios_consultar';
include('include/topo.php'); 

//importa a definição da classe Afiliado
require("include/autoload.php");
//error_reporting("E_ALL ~E_NOTICE");

if (empty($_SESSION['form'])){
	$funcionario = new Funcionario(array());
}else{
	$funcionario = new Funcionario($_SESSION['form']);
}
//recupera as mensagens de erros
$erros = (empty($_SESSION['erros']))?array():$_SESSION['erros'];
$msg = (empty($_SESSION['msg']))?"":$_SESSION['msg'];

unset($_SESSION['erros']);
unset($_SESSION['msg']);
unset($_SESSION['form']);
?>

<head>
	<title>Consulta de Funcionarios</title>
</head>
<body id="public">
	<form class="wufoo rightLabel" method="post" action="funcionarios_consultar_resultado.php">
		<div class="info">
			<h2>Consulta de Funcionarios</h2>
			<div>Campos marcados com * são requeridos</div>
		</div>
		<ul>
			<li class="<?php if(!empty($erros['matricula'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
				<label class="desc" id="title1" for="Field1">
					Matr&iacute;cula:<span id="req_1" class="req">*</span>
				</label>
				<div>
					<input type="text" name="matricula" />
				</div>
			</li>
			<li class="buttons">
				<input id="saveForm" class="btTxt submit" type="submit" value="Consultar" />
			</li>
		</ul>
	</form>

<?php include('include/rodape.php'); ?>