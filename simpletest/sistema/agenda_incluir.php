<?php
/*
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Formulário de cadastro de agendamento
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

//recebendo parâmetros do GET
$dia          = $_GET['dia'];
$mes          = $_GET['mes'];
$ano          = $_GET['ano'];
$funcionario      = $_GET['funcionario'];
$nome_funcionario   = $_GET['nome_funcionario'];
$especialidade      = $_GET['especialidade'];
$nome_especialidade = $_GET['nome_especialidade'];
$cod_hora        = $_GET['cod_hora'];
$horario      = $_GET['hora'];
$observacao = $_GET['observacao'];

unset($_SESSION['erros']);
unset($_SESSION['msg']);
unset($_SESSION['form']);
?>

<head>
  <title>Cadastro Agenda</title>
      <title>Exemplo: Populando selects de cidades e estados com AJAX (PHP e jQuery) | DaviFerreira blog!</title>
    <style type="text/css">
      *, html {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        margin: 0px;
        padding: 0px;
        font-size: 12px;
      }

      a {
        color: #0099CC;
      }

      body {
        margin: 10px;
      }
      .carregando{
        color:#666;
        display:none;
      }
    </style>
</head>
<body id="public">
  <form class="wufoo rightLabel" method="post" action="agenda_salvar.php">
    <div class="info">
      <h2>Cadastro Agenda</h2>
      <div>Campos marcados com * são requeridos</div>
    </div>
    <ul>
      <li class="<?php if(!empty($erros['dia'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
        <label class="desc" id="title1" for="Field1">
          Dia:<span id="req_1" class="req">*</span>
        </label>
        <div>
          <input name="dia" type="text" value="<?php if($agenda->dia){ echo $agenda->dia; }else{ echo $dia; } ?>" maxlength="2" size="2" />
        </div>
        <div class="msg_erro">
          <?php if(!empty($erros['dia'])): ?>
          <?php echo "<br />".$erros['dia'] ?>
          <?php endif; ?>
        </div>
      </li>
      <li class="<?php if(!empty($erros['mes'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
        <label class="desc" id="title1" for="Field1">
          M&ecirc;s:<span id="req_1" class="req">*</span>
        </label>
        <div>
          <input name="mes" type="text" value="<?php if($agenda->mes){ echo $agenda->mes; }else{ echo $mes; } ?>" maxlength="2" size="2" />
        </div>
        <div class="msg_erro">
          <?php if(!empty($erros['mes'])): ?>
          <?php echo "<br />".$erros['mes'] ?>
          <?php endif; ?>
        </div>
      </li>
      <li class="<?php if(!empty($erros['ano'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
        <label class="desc" id="title1" for="Field1">
          Ano:<span id="req_1" class="req">*</span>
        </label>
        <div>
          <input name="ano" type="text" value="<?php if($agenda->ano){ echo $agenda->ano; }else{ echo $ano; } ?>" maxlength="4" size="4" />
        </div>
        <div class="msg_erro">
          <?php if(!empty($erros['ano'])): ?>
          <?php echo "<br />".$erros['ano'] ?>
          <?php endif; ?>
        </div>
      </li>
      <li class="<?php if(!empty($erros['hora'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
        <label class="desc" id="title1" for="Field1">
          Hor&aacute;rio:<span id="req_1" class="req">*</span>
        </label>
        <div>
          <input type="hidden" name="cod_hora" value="<?php if($agenda->cod_hora){ echo $agenda->cod_hora; }else{ echo $cod_hora; } ?>" />
          <input name="hora" type="text" value="<?php if($agenda->hora){ echo $agenda->hora; }else{ echo $horario; } ?>" maxlength="2" size="2" />
        </div>
        <div class="msg_erro">
          <?php if(!empty($erros['hora'])): ?>
          <?php echo "<br />".$erros['hora'] ?>
          <?php endif; ?>
        </div>
      </li>
      <li class="<?php if(!empty($erros['especialidade'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
        <label class="desc" id="title1" for="Field1">
          Especialidade:<span id="req_1" class="req">*</span>
        </label>
        <div>
          <select name="funcionario_e">
          <?php
          
          	if($funcionario == 3){
          	  //echo Especialidade::option_especialidade();
          	  echo "<option value='7'>Acupuntura </option>";
          	  echo "<option value='2'> Psicologia</option>";          	  
          	}elseif($funcionario == 39){
          	  echo "<option value='10'>Drenagem </option>";
          	  echo "<option value='3'>Fisioterapia</option>";  
          	}else{
          	  echo '<option value="'.$especialidade.'" selected="selected">'.$nome_especialidade.'</option>';
          	}
          
          ?>
            
          </select>
        </div>
        <div class="msg_erro">
          <?php if(!empty($erros['especialidade'])): ?>
          <?php echo "<br />".$erros['especialidade'] ?>
          <?php endif; ?>
        </div>
      </li>
      <li class="<?php if(!empty($erros['funcionario'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
        <label class="desc" id="title1" for="Field1">
          Funcion&aacute;rio:<span id="req_1" class="req">*</span>
        </label>
        <div>
          <select name="funcionario_m">
            <option value="<?php echo $funcionario; ?>" selected="selected"><?php echo $nome_funcionario; ?></option>
          </select>
        </div>
        <div class="msg_erro">
          <?php if(!empty($erros['funcionario'])): ?>
          <?php echo "<br />".$erros['funcionario'] ?>
          <?php endif; ?>
        </div>
      </li>
      <li class="<?php if(!empty($erros['situacao'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
        <label class="desc" id="title1" for="Field1">
          Situa&ccedil;&atilde;o:<span id="req_1" class="req">*</span>
        </label>
        <div>
          <select name="situacao">
            <option value="Atendido">Atendido</option>
            <option value="Confirmado" >Confirmado</option>            
            <option value="Faltou">Faltou</option>
            <option value="Nao Confirmado" selected="selected">Nao Confirmado</option>
          </select>
        </div>
        <div class="msg_erro">
          <?php if(!empty($erros['situacao'])): ?>
          <?php echo "<br />".$erros['situacao'] ?>
          <?php endif; ?>
        </div>
      </li>
      <li class="<?php if(!empty($erros['paciente'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
        <label class="desc" for="cod_estados" id="title1">
          Paciente:<span id="req_1" class="req">*</span>
        </label>
        <div>
          <select name="paciente" id="cod_estados">
            <option value=""></option>
            <?php echo Paciente::option_paciente() ?>
          </select>
        </div>
        <div class="msg_erro">
          <?php if(!empty($erros['paciente'])): ?>
          <?php echo "<br />".$erros['paciente'] ?>
          <?php endif; ?>
        </div>
      </li>
      <li class="<?php if(!empty($erros['servico'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
        <label class="desc" for="cod_cidades" id="title1">Servico:<span id="req_1" class="req">*</span></label>
        <span class="carregando">Aguarde, carregando...</span>
        <select name="servico" id="cod_cidades">
          <option value="">-- Escolha um servico --</option>
        </select>
        <script src="http://www.google.com/jsapi"></script>
        <script type="text/javascript">
          google.load('jquery', '1.3');
        </script>
        <script type="text/javascript">
        $(function(){
          $('#cod_estados').change(function(){
            if( $(this).val() ) {
              $('#cod_cidades').hide();
              $('.carregando').show();
              $.getJSON('servicos.ajax.php?search=',{cod_estados: $(this).val(), ajax: 'true'}, function(j){
                var options = '<option value=""></option>';  
                for (var i = 0; i < j.length; i++) {
                  options += '<option value="' + j[i].cod_cidades + '">' + j[i].nrGuia + ' - ' + j[i].nome + '</option>';
                }  
                $('#cod_cidades').html(options).show();
                $('.carregando').hide();
              });
            } else {
              $('#cod_cidades').html('<option value="">– Escolha um servico –</option>');
            }
          });
        });
        </script>
        <div class="msg_erro">
          <?php if(!empty($erros['servico'])): ?>
          <?php echo "<br />".$erros['servico'] ?>
          <?php endif; ?>
        </div>
      </li>      
      <li class="<?php if(!empty($erros['observacao'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
        <label class="desc" id="title1" for="Field1">
          Observa&ccedil;&atilde;o:<span id="req_1" class="req"></span>
        </label>
        <div>
          <input name="observacao" type="text" value="<?php echo $observacao; ?>" maxlength="100" size="50" />
        </div>
        <div class="msg_erro">
          <?php if(!empty($erros['observacao'])): ?>
          <?php echo "<br />".$erros['observacao'] ?>
          <?php endif; ?>
        </div>
      </li>
      <li class="buttons">
        <input id="saveForm" class="btTxt submit" type="submit" value="Salvar" />
      </li>
    </ul>
  </form>

<?php include('include/rodape.php'); ?>