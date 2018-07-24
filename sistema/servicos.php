<?php
/*
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Formulário de consulta de usuário
Versão: 1.0
*/

require('include/verificar_usuario.php');
$menu='servicos';
include('include/topo.php'); 

//importa a definição da classe Afiliado
require("include/autoload.php");
//error_reporting("E_ALL ~E_NOTICE");

//recupera dados digitados pelo usuário
if (empty($_SESSION['form'])){
	$agenda = new Agenda(array());
}else{
	$agenda = new Agenda($_SESSION['form']);
}

$_POST['idservico'] = "";
//recupera as mensagens de erros
$erros = (empty($_SESSION['erros']))?array():$_SESSION['erros'];
$msg = (empty($_SESSION['msg']))?"":$_SESSION['msg'];

unset($_SESSION['erros']);
unset($_SESSION['msg']);
unset($_SESSION['form']);
?>

<head>
	<title>Consulta de Agenda</title>
</head>
<body id="public">
	<form class="wufoo rightLabel" method="post" action="servico_consultar.php">
		<div class="info">
			<h2>Consulta Servi&ccedil;os</h2>
			<div>Campos marcados com * são requeridos</div>
		</div>
		<ul>
			<li class="<?php if(!empty($erros['paciente'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
				<label class="desc" id="title1" for="Field1">
					Paciente:<span id="req_1" class="req">*</span>
				</label>
				<div>
					<select name="paciente" onChange="">
						<option value=""></option>
						<?php echo Paciente::option_paciente(); ?>
					</select>
					<?php if(!empty($erros['servico'])): ?>
					<?php echo "<br />".$erros['servico'] ?>
					<?php endif; ?>
					<?php if(!empty($msg)): ?>
					<?php echo "<br />".$msg ?>
					<?php endif; ?>
				</div>
			</li>			
			<li class="buttons">
				<input id="saveForm" class="btTxt submit" type="submit" value="Consultar" />
			</li>
		</ul>
	</form>

<?php include('include/rodape.php'); ?>