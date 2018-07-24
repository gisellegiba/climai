<?php
/*
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Formulário de consulta de usuário
Versão: 1.0
*/

require('include/verificar_usuario.php');
$menu='usuario_consultar';
include('include/topo.php'); 

//importa a definição da classe Afiliado
require("include/autoload.php");
//error_reporting("E_ALL ~E_NOTICE");

//recupera dados digitados pelo usuário
if (empty($_SESSION['form'])){
	$usuario = new Usuario(array());
}else{
	$usuario = new Usuario($_SESSION['form']);
}

//recupera as mensagens de erros
$erros = (empty($_SESSION['erros']))?array():$_SESSION['erros'];
$msg = (empty($_SESSION['msg']))?"":$_SESSION['msg'];

unset($_SESSION['erros']);
unset($_SESSION['msg']);
unset($_SESSION['form']);
?>

<head>
	<title>Consulta de Usu&aacute;rios</title>
</head>
<body id="public">
	<form class="wufoo rightLabel" method="post" action="usuario_consultar_resultado.php">
		<div class="info">
			<h2>Consulta de Usuários</h2>
			<div>Campos marcados com * são requeridos</div>
		</div>
		<ul>
			<li class="<?php if(!empty($erros['login'])): ?>error<?php endif; ?>">
				<label class="desc" id="title4" for="Field4">
					Login:<span id="req_4" class="req">*</span>
				</label>
				<div>
					<input id="Field4"	name="login" type="text" class="field text small" value="<?php echo $usuario->login; ?>" maxlength="255" tabindex="3" />
					<div class="msg_erro"><?php if(!empty($erros['login'])): ?>
					<?php echo "<br />".$erros['login'] ?>
					<?php endif; ?>
					</div>
				</div>
			</li>
			<li class="buttons">
				<input id="saveForm" class="btTxt submit" type="submit" value="Consultar" />
			</li>
		</ul>
	</form>

<?php include('include/rodape.php'); ?>