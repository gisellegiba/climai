<?php
/*
Autor: Giselle Machado
Data: 06/09/2015
Descrição: Formulário de alteracao de agenda
Versão: 1.0
*/

require('include/verificar_usuario.php');
$menu='agenda';
include('include/topo.php'); 

//importa a definição da classe Afiliado
require("include/autoload.php");
//error_reporting("E_ALL ~E_NOTICE");

if (empty($_SESSION['form'])){
	$agenda = new Agenda(array());
}else{
	$agenda = new Agenda($_SESSION['form']);
}
//recupera as mensagens de erros
$erros = (empty($_SESSION['erros']))?array():$_SESSION['erros'];
$msg = (empty($_SESSION['msg']))?"":$_SESSION['msg'];

unset($_SESSION['erros']);
unset($_SESSION['msg']);
unset($_SESSION['form']);
?>

<head>
	<title>Cadastro de Agenda</title>
</head>
<body id="public">
	<form class="wufoo rightLabel" method="post" action="agenda_alterar_salvar.php">
		<div class="info">
			<h2>Cadastro de Agenda</h2>
			<div>Campos marcados com * são requeridos</div>
		</div>
		<ul>
			<li class="<?php if(!empty($erros['observacao'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
				<input type="hidden" name="funcionario" value="<?php echo $_GET['funcionario']; ?>" />
				<input type="hidden" name="mes" value="<?php echo $_GET['mes']; ?>" />
				<input type="hidden" name="ano" value="<?php echo $_GET['ano']; ?>" />
				<input type="hidden" name="idagenda" value="<?php echo $_GET['idagenda']; ?>" />
				<label class="desc" id="title1" for="Field1">
					Observa&ccedil;&atilde;o:<span id="req_1" class="req">*</span>
				</label>
				<div>
					<input name="observacao" type="text" class="field text small" value="<?php if(isset($_GET['observacao'])) echo $_GET['observacao']; ?>" maxlength="100" size="50" />
				</div>
				<div class="msg_erro">
					<?php if(!empty($erros['observacao'])): ?>
					<?php echo "<br />".$erros['observacao'] ?>
					<?php endif; ?>
				</div>
			</li>
			<li class="buttons">
				<input id="saveForm" class="btTxt submit" type="submit" value="Alterar" />
			</li>
		</ul>
	</form>

<?php include('include/rodape.php'); ?>