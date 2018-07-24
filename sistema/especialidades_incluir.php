<?php
/*
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Formulário de cadastro de especialidades
Versão: 1.0
*/

require('include/verificar_usuario.php');
$menu='especialidades_incluir';
include('include/topo.php'); 

//importa a definição da classe Afiliado
require("include/autoload.php");
//error_reporting("E_ALL ~E_NOTICE");

if (empty($_SESSION['form'])){
	$especialidade = new Especialidade(array());
}else{
	$especialidade = new Especialidade($_SESSION['form']);
}
//recupera as mensagens de erros
$erros = (empty($_SESSION['erros']))?array():$_SESSION['erros'];
$msg = (empty($_SESSION['msg']))?"":$_SESSION['msg'];

unset($_SESSION['erros']);
unset($_SESSION['msg']);
unset($_SESSION['form']);
?>

<head>
	<title>Cadastro de Especialidades</title>
</head>
<body id="public">
	<form class="wufoo rightLabel" method="post" action="especialidades_salvar.php">
		<div class="info">
			<h2>Cadastro de Especialidades</h2>
			<div>Campos marcados com * são requeridos</div>
		</div>
		<ul>
			<li class="<?php if(!empty($erros['descricao'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
				<label class="desc" id="title1" for="Field1">
					Descri&ccedil;&atilde;o:<span id="req_1" class="req">*</span>
				</label>
				<div>
					<input name="descricao" type="text" class="field text small" value="<?php echo $especialidade->descricao; ?>" maxlength="255" tabindex="1" />
				</div>
				<div class="msg_erro">
					<?php if(!empty($erros['descricao'])): ?>
					<?php echo "<br />".$erros['descricao'] ?>
					<?php endif; ?>
					<?php if(!empty($msg)): ?>
					<?php echo "<br />".$msg ?>
					<?php endif; ?>
				</div>
			</li>
			<li class="buttons">
				<input id="saveForm" class="btTxt submit" type="submit" value="Salvar" />
			</li>
		</ul>
	</form>

<?php include('include/rodape.php'); ?>