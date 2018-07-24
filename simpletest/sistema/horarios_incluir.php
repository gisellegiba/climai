<?php
/*
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Formulário de cadastro de horários
Versão: 1.0
*/

require('include/verificar_usuario.php');
$menu='horarios';
include('include/topo.php'); 

//importa a definição da classe Afiliado
require("include/autoload.php");
//error_reporting("E_ALL ~E_NOTICE");

if (empty($_SESSION['form'])){
  $horario = new Horario(array());
}else{
  $horario = new Horario($_SESSION['form']);
}
//recupera as mensagens de erros
$erros = (empty($_SESSION['erros']))?array():$_SESSION['erros'];
$msg = (empty($_SESSION['msg']))?"":$_SESSION['msg'];

unset($_SESSION['erros']);
unset($_SESSION['msg']);
unset($_SESSION['form']);
?>

<head>
  <title>Cadastro de Hor&aacute;rios</title>
</head>
<body id="public">
  <form class="wufoo rightLabel" method="post" action="horarios_salvar.php">
    <div class="info">
      <h2>Cadastro de Horarios</h2>
      <div>Campos marcados com * são requeridos</div>
    </div>
    <ul>
      <li class="<?php if(!empty($erros['funcionario'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
        <label class="desc" id="title1" for="Field1">
          Funcion&aacute;rio:<span id="req_1" class="req">*</span>
        </label>
        <div>
          <select name="funcionario" onChange="">
            <option value="<?php echo $_GET['id']; ?>" selected="selected"><?php echo $_GET['nome']; ?></option>
            <?php echo Funcionario::option_funcionario_especialidade(); ?>
          </select>
        </div>
      </li>      
      <li class="<?php if(!empty($erros['descricao'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
        <label class="desc" id="title1" for="Field1">
          Descri&ccedil;&atilde;o:<span id="req_1" class="req">* </span>
        </label>
        <div>
          <input name="descricao" type="text" value="<?php echo $horario->descricao; ?>" maxlength="5" size="5" />
        (Exemplo: 11:00)
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
      <li class="<?php if(!empty($erros['diasemana'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
        <label class="desc" id="title1" for="Field1">
          Dia da semana:<span id="req_1" class="req">*</span>
        </label>
        <div>
          <select name="diasemana">
            <option value="1segunda"> Segunda-feira </option>
            <option value="2terca"> Terça-feira </option>
            <option value="3quarta"> Quarta-feira </option>
            <option value="4quinta"> Quinta-feira </option>
            <option value="5sexta"> Sexta-feira </option>
            <option value="6sabado"> Sábado </option>
          </select>
        </div>
        <div class="msg_erro">
          <?php if(!empty($erros['diasemana'])): ?>
          <?php echo "<br />".$erros['diasemana'] ?>
          <?php endif; ?>
          <?php if(!empty($msg)): ?>
          <?php echo "<br />".$msg ?>
          <?php endif; ?>
        </div>
      </li>
      <li class="<?php if(!empty($erros['status'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
        <label class="desc" id="title1" for="Field1">
          Status:<span id="req_1" class="req">*</span>
        </label>
        <div>
          <select name="status">
            <option value="Ativo"> Ativo </option>
            <option value="Inativo"> Inativo </option>
          </select>
        </div>
        <div class="msg_erro">
          <?php if(!empty($erros['status'])): ?>
          <?php echo "<br />".$erros['status'] ?>
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