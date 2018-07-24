<?php
/*
Autor: Giselle Machado
Data: 22/05/2011
Descrição: Tela principal
Versão: 1.0
*/
//abre a sessão com o usuário
session_start();

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
unset($_SESSION['form']);
unset($_SESSION['msg']);
unset($_SESSION['erros']);

?>
<?php include('include/topo.php'); ?>
<head>
	<title>Login de Usu&aacute;rios</title>
</head>
<body>
<div id="container">
<div class="<?php if(!empty($erros['usuario'])): ?>message error-message<?php endif; ?>">
	<?php if(!empty($erros['usuario'])): ?>
	<?php echo "<br />".$erros['usuario'] ?>
	<?php endif; ?>
</div>	
<form class="wufoo leftLabel page1" method="post" action="login.php">
<div class="info">
	<h2><font color="black">Login de Usuários</font></h2>
	<div><font color="black">Para acessar o sistema informe o login e a senha.</font></div>
</div>
<ul>
<li class="<?php if(!empty($erros['login'])): ?>error<?php endif; ?>">
	<label class="desc" id="title4" for="Field4">
		Login:
				<span id="req_4" class="req">*</span>
			</label>
	<div>
		<input id="Field4"	name="login" type="text" class="field text medium" value="<?php echo $usuario->login; ?>" maxlength="255" tabindex="3" />
		<div class="msg_erro"><?php if(!empty($erros['login'])): ?>
		<?php echo "<br />".$erros['login'] ?>
		<?php endif; ?>
		</div>
			</div>
	</li>

	<li>
		<label class="desc" id="title5" for="Field5">Senha:<span id="req_5" class="req">*</span></label>
		<div>
			<input id="Field5" 	name="senha" type="password" class="field text medium" 	value="" maxlength="255" tabindex="4" />
		</div>
		<div class="msg_erro">
			<?php if(!empty($erros['senha'])): ?>
			<?php echo "<br />".$erros['senha'] ?>
			<?php endif; ?>
			<?php if(!empty($erros['banco'])): ?>
			<?php echo "<br />".$erros['banco'] ?>
			<?php endif; ?>
		</div>
	</li>	
	<li class="buttons">
		<input type="submit" value="Login" />
	</li>
</ul>
</form>
</div><!--container-->
<?php include('include/rodape.php'); ?>
