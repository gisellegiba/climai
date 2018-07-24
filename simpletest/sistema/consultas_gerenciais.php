<?php
/*
Autor: Giselle Machado
Data: 22/05/2011
Descrição: Formulário para consultas gerenciais
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
	<title>Consultas Gerenciais</title>
</head>
<body id="public">
	<form class="wufoo rightLabel" method="post" action="consultas_gerenciais_resultado.php">
		<div class="info">
			<h2>Consultas Gerenciais</h2>
			<div>Campos marcados com * são requeridos</div>
		</div>
		<ul>
			<li class="<?php if(!empty($erros['funcionario'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
				<label class="desc" id="title1" for="Field1">
					Funcion&aacute;rio:<span id="req_1" class="req">*</span>
				</label>
				<div>
					<select name="funcionario" onChange="">
						<option value=""></option>
						<?php echo Funcionario::option_funcionario_especialidade(); ?>
					</select>
					<?php if(!empty($erros['horario'])): ?>
					<?php echo "<br />".$erros['horario'] ?>
					<?php endif; ?>
					<?php if(!empty($msg)): ?>
					<?php echo "<br />".$msg ?>
					<?php endif; ?>
				</div>
			</li>	
			<li class="<?php if(!empty($erros['despesa'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
				<label class="desc" id="title1" for="Field1">
					Tipo da despesa:<span id="req_1" class="req">*</span>
				</label>
				<div>
					<select name="tipo">
						<option value="anual">Anual</option>
						<option value="mensal" selected="selected">Mensal</option>
					</select>
				</div>
			</li>
			<li class="<?php if(!empty($erros['ano'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
				<label class="desc" id="title1" for="Field1">
					Ano:<span id="req_1" class="req">*</span>
				</label>
				<div>
					<select name="ano">
						<?php 
							$ano_atual = date('Y');
							for($i=$ano_atual;$i>=2000;$i--){
								echo "<option value='$i'>$i</option>";
							}
						?>
					</select>
				</div>
				<div class="msg_erro">
					<?php if(!empty($erros['ano'])): ?>
					<?php echo "<br />".$erros['ano'] ?>
					<?php endif; ?>
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

			<li class="buttons">
				<input id="saveForm" class="btTxt submit" type="submit" value="Consultar" />
			</li>
		</ul>
	</form>
	
	<img id="bottom" src="images/bottom.png" alt="" />
	
<?php include('include/rodape.php'); ?>