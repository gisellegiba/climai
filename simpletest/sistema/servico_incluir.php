<?php
/*
Autor: Giselle Machado
Data: 05/09/2015
Descrição: Formulário de cadastro de serviço
Versão: 1.0
*/

require('include/verificar_usuario.php');
$menu='servicos';
include('include/topo.php'); 

//importa a definição da classe Afiliado
require("include/autoload.php");
//error_reporting("E_ALL ~E_NOTICE");

if(isset($_GET['paciente'])){
	$paciente=$_GET['paciente'];
}

//recupera dados digitados pelo usuário
if (empty($_SESSION['form'])){
	$servico = new Servico(array());
}else{
	$servico = new Servico($_SESSION['form']);
}

//recupera as mensagens de erros
$erros = (empty($_SESSION['erros']))?array():$_SESSION['erros'];
$msg = (empty($_SESSION['msg']))?"":$_SESSION['msg'];

unset($_SESSION['erros']);
unset($_SESSION['msg']);
unset($_SESSION['form']);
?>

<head>
	<title>Cadastro de Servi&ccedil;o</title>
</head>
<body id="public">
	<form class="wufoo rightLabel" method="post" action="servico_salvar.php">
		<div class="info">
			<h2>Cadastro de Servi&ccedil;o</h2>
			<div>Campos marcados com * são requeridos</div>
		</div>
		<ul>
			<li class="<?php if(!empty($erros['valor'])): ?>error<?php endif; ?>">
				<label class="desc" id="title3" for="Field3">
					Valor:<span id="req_3" class="req">*</span>
				</label>
				<div>
					<input id="Field3" name="valor" type="text" class="field text small" maxlength="255" tabindex="2" /> 
				</div>
				<div class="msg_erro">
					<?php if(!empty($erros['valor'])): ?>
					<?php echo "<br />".$erros['valor'] ?>
					<?php endif; ?>
				</div>
			</li>
			<li class="<?php if(!empty($erros['nrGuia'])): ?>error<?php endif; ?>">
				<label class="desc" id="title3" for="Field3">
					Nr Guia:<span id="req_3" class="req"></span>
				</label>
				<div>
					<input id="Field3" name="nrGuia" type="text" class="field text small" maxlength="255" tabindex="2" /> 
				</div>
				<div class="msg_erro">
					<?php if(!empty($erros['nrGuia'])): ?>
					<?php echo "<br />".$erros['nrGuia'] ?>
					<?php endif; ?>
				</div>
			</li>
			<li class="<?php if(!empty($erros['qtdeSessoes'])): ?>error<?php endif; ?>">
				<label class="desc" id="title3" for="Field3">
					Quantidade de Sess&otilde;es:<span id="req_3" class="req">*</span>
				</label>
				<div>
					<input id="Field3" name="qtdeSessoes" type="text" class="field text small" maxlength="255" tabindex="2" /> 
				</div>
				<div class="msg_erro">
					<?php if(!empty($erros['qtdeSessoes'])): ?>
					<?php echo "<br />".$erros['qtdeSessoes'] ?>
					<?php endif; ?>
				</div>
			</li>
			<li class="<?php if(!empty($erros['paciente'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
				<label class="desc" id="title1" for="Field1">
					Paciente:<span id="req_1" class="req">*</span>
				</label>
				<div>
					<select name="paciente" onChange="">
						<option value="<?php echo $_GET['paciente']; ?>" selected="selected"><?php echo $_GET['nomepaciente']; ?></option>
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
			<li class="<?php if(!empty($erros['paciente'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
				<label class="desc" id="title1" for="Field1">
					Especialidade:<span id="req_1" class="req">*</span>
				</label>
				<div>
					<select name="especialidade" onChange="">
						<option value=""></option>
						<?php echo Especialidade::option_especialidade(); ?>
					</select>
					<?php if(!empty($erros['especialidade'])): ?>
					<?php echo "<br />".$erros['especialidade'] ?>
					<?php endif; ?>
					<?php if(!empty($msg)): ?>
					<?php echo "<br />".$msg ?>
					<?php endif; ?>
				</div>
			</li>
			<li class="<?php if(!empty($erros['descricao'])): ?>error<?php endif; ?>">
				<label class="desc" id="title3" for="Field3">
					Observa&ccedil;&atilde;o:
				</label>
				<div>
					<input id="Field3" name="descricao" type="text" class="field text small" maxlength="255" tabindex="2" /> 
				</div>
				<div class="msg_erro">
					<?php if(!empty($erros['descricao'])): ?>
					<?php echo "<br />".$erros['descricao'] ?>
					<?php endif; ?>
				</div>
			</li>
			<li class="buttons">
				<input id="saveForm" class="btTxt submit" type="submit" value="Salvar" />
			</li>
		</ul>
	</form>
	
<?php include('include/rodape.php'); ?>