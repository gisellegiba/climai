<?php
/*
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Formulário de consulta de usuário
Versão: 1.0
*/

if($_SESSION['usuario_perfil'] <> 'Profissional'){

require('include/verificar_usuario.php');
$menu='agenda';
include('include/topo.php'); 
//importa a definição da classe Afiliado
require("include/autoload.php");
}

//error_reporting("E_ALL ~E_NOTICE");

//recupera dados digitados pelo usuário
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
	<title>Consulta de Agenda</title>
</head>
<body id="public">
	<form class="wufoo rightLabel" method="post" action="agenda_consultar.php">
		<div class="info">
			<h2>Consulta de Agenda</h2>
			<div>Campos marcados com * são requeridos</div>
		</div>
		<ul>
			<li class="<?php if(!empty($erros['ano'])): ?>error<?php endif; ?>">
				<label class="desc" id="title4" for="Field4">
					Ano:<span id="req_4" class="req">*</span>
				</label>
				<div>
					<select name="ano">
						<?php
							$ano_atual = date('Y');
							$ano_seguinte = $ano_atual + 1;
							$ano_anterior = $ano_atual - 1;
							echo "<option value='".$ano_anterior."'>".$ano_anterior."</option>
							      <option value='".$ano_atual."' selected>".$ano_atual."</option>
								  <option value='".$ano_seguinte."'>".$ano_seguinte."</option>";
						?>
					</select>
					<div class="msg_erro">
					<?php if(!empty($erros['ano'])): ?>
					<?php echo "<br />".$erros['ano'] ?>
					<?php endif; ?>
					</div>
				</div>
			</li>
			<li class="<?php if(!empty($erros['mes'])): ?>error<?php endif; ?>">
				<label class="desc" id="title4" for="Field4">
					M&ecirc;s:<span id="req_4" class="req">*</span>
				</label>
				<div>
						<?php
							$mes_atual = date('m');
							$jan = "";
							$fev = "";
							$mar = "";
							$abr = "";
							$mai = "";
							$jun = "";
							$jul = "";
							$ago = "";
							$set = "";
							$out = "";
							$nov = "";
							$dez = "";
							switch($mes_atual){
								case '01': $jan = 'selected'; 
								break;
								case '02': $fev = 'selected'; 
								break;
								case '03': $mar = 'selected'; 
								break;
								case '04': $abr = 'selected'; 
								break;
								case '05': $mai = 'selected'; 
								break;
								case '06': $jun = 'selected'; 
								break;
								case '07': $jul = 'selected'; 
								break;
								case '08': $ago = 'selected'; 
								break;
								case '09': $set = 'selected'; 
								break;
								case '10': $out = 'selected'; 
								break;
								case '11': $nov = 'selected'; 
								break;
								case '12': $dez = 'selected'; 
								break;
							}
							
						?>
					<select name="mes">
						<option value="1" <?php echo $jan; ?> >Janeiro</option>
						<option value="2" <?php echo $fev; ?> >Fevereiro</option>
						<option value="3" <?php echo $mar; ?> >Mar&ccedil;o</option>
						<option value="4" <?php echo $abr; ?> >Abril</option>
						<option value="5" <?php echo $mai; ?> >Maio</option>
						<option value="6" <?php echo $jun; ?> >Junho</option>
						<option value="7" <?php echo $jul; ?> >Julho</option>
						<option value="8" <?php echo $ago; ?> >Agosto</option>
						<option value="9" <?php echo $set; ?> >Setembro</option>
						<option value="10" <?php echo $out; ?> >Outubro</option>
						<option value="11" <?php echo $nov; ?> >Novembro</option>
						<option value="12" <?php echo $dez; ?> >Dezembro</option>
					</select>
					<div class="msg_erro">
					<?php if(!empty($erros['mes'])): ?>
					<?php echo "<br />".$erros['mes'] ?>
					<?php endif; ?>
					</div>
				</div>
			</li>
			<li class="<?php if(!empty($erros['funcionario_m'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
				<div>
					<input type="hidden" name="funcionario_m" value="<?php echo $_SESSION['usuario_matricula']; ?>" />
					<?php if(!empty($erros['agenda'])): ?>
					<?php echo "<br />".$erros['agenda'] ?>
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

<?php 

if($_SESSION['usuario_perfil'] <> 'Profissional'){
	include('include/rodape.php'); 
}
?>