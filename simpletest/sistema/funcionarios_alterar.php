<?php
/*
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Formulário de cadastro de funcionário
Versão: 1.0
*/

require('include/verificar_usuario.php');
$menu='funcionarios';
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
	<title>Cadastro de Funcion&aacute;rios</title>
</head>
<body id="public">
	<form class="wufoo rightLabel" method="post" action="funcionarios_alterar_salvar.php">
		<div class="info">
			<h2>Cadastro de Funcionarios</h2>
			<div>Campos marcados com * são requeridos</div>
		</div>
		<ul>
			<li class="<?php if(!empty($erros['nome'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
				<input type="hidden" name="matricula" value="<?php echo $_GET['matricula']; ?>" />
				<label class="desc" id="title1" for="Field1">
					Nome:<span id="req_1" class="req">*</span>
				</label>
				<div>
					<input name="nome" type="text" class="field text small" value="<?php if(isset($_GET['nome'])) echo $_GET['nome']; ?>" maxlength="255" tabindex="1" />
				</div>
				<div class="msg_erro">
					<?php if(!empty($erros['nome'])): ?>
					<?php echo "<br />".$erros['nome'] ?>
					<?php endif; ?>
				</div>
			</li>
			<li class="<?php if(!empty($erros['nr_conselho'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
				<label class="desc" id="title1" for="Field1">
					N&uacute;mero do conselho:<span id="req_1" class="req">*</span>
				</label>
				<div>
					<input name="nr_conselho" type="text" class="field text small" value="<?php if(isset($_GET['conselho'])) echo $_GET['conselho']; ?>" maxlength="20" tabindex="1" />
				</div>
				<div class="msg_erro">
					<?php if(!empty($erros['nr_conselho'])): ?>
					<?php echo "<br />".$erros['nr_conselho'] ?>
					<?php endif; ?>
				</div>
			</li>
			<li class="<?php if(!empty($erros['percentual'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
				<label class="desc" id="title1" for="Field1">
					Percentual:<span id="req_1" class="req">*</span>
				</label>
				<div>
					<input name="percentual" type="text" class="field text small" value="<?php if(isset($_GET['percentual'])) echo $_GET['percentual']; ?>" maxlength="4" tabindex="1" />(%)
				</div>
				<div class="msg_erro">
					<?php if(!empty($erros['percentual'])): ?>
					<?php echo "<br />".$erros['percentual'] ?>
					<?php endif; ?>
				</div>
			</li>
			<li class="<?php if(!empty($erros['especialidade'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
				<label class="desc" id="title1" for="Field1">
					Especialidade:<span id="req_1" class="req">*</span>
				</label>
				<div>
					<select name="especialidade" onChange="">
						<option value="<?php echo $_GET['especialidade']; ?>" selected="selected"><?php echo $_GET['nome_especialidade']; ?></option>
						<?php echo Especialidade::option_especialidade(); ?>
					</select>
					<?php if(!empty($msg)): ?>
					<?php echo "<br />".$msg ?>
					<?php endif; ?>
				</div>
			</li>			
			<li class="buttons">
				<input id="saveForm" class="btTxt submit" type="submit" value="Alterar" />
			</li>
		</ul>
	</form>

<?php include('include/rodape.php'); ?>