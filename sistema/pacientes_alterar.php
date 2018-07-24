<?php
/*
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Formulário de cadastro de pacientes
Versão: 1.0
*/

require('include/verificar_usuario.php');
$menu='pacientes';
include('include/topo.php'); 

//importa a definição da classe Afiliado
require("include/autoload.php");
//error_reporting("E_ALL ~E_NOTICE");

if (empty($_SESSION['form'])){
  $paciente = new Paciente(array());
}else{
  $paciente = new Paciente($_SESSION['form']);
}
//recupera as mensagens de erros
$erros = (empty($_SESSION['erros']))?array():$_SESSION['erros'];
$msg = (empty($_SESSION['msg']))?"":$_SESSION['msg'];

if(isset($_GET['dn'])){
  $dia=substr($_GET['dn'],8,2);
  $mes=substr($_GET['dn'],5,2);
  $ano=substr($_GET['dn'],0,4);
}else{
  $dia = '';
  $mes = '';
  $ano = '';
}
if(isset($_GET['dtValidadePlano'])){
  $diaP=substr($_GET['dtValidadePlano'],8,2);
  $mesP=substr($_GET['dtValidadePlano'],5,2);
  $anoP=substr($_GET['dtValidadePlano'],0,4);
}else{
  $diaP = '';
  $mesP = '';
  $anoP = '';
}
unset($_SESSION['erros']);
unset($_SESSION['msg']);
unset($_SESSION['form']);
?>

<head>
  <title>Alterar Paciente</title>
</head>
<body id="public">
  <form class="wufoo rightLabel" method="post" action="pacientes_alterar_salvar.php">
    <div class="info">
      <h2>Cadastro de Pacientes</h2>
      <div>Campos marcados com * são requeridos</div>
    </div>
    <ul>
      <li class="<?php if(!empty($erros['nome'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
        <label class="desc" id="title1" for="Field1">
          Nome:<span id="req_1" class="req">*</span>
        </label>
        <div>
          <input name="nome" type="text" class="field text small" value="<?php if(isset($_GET['nome'])) echo $_GET['nome']; ?>" maxlength="100" tabindex="1" />
        </div>
        <div class="msg_erro">
          <?php if(!empty($erros['nome'])): ?>
          <?php echo "<br />".$erros['nome'] ?>
          <?php endif; ?>
        </div>
      </li>
      <li class="<?php if(!empty($erros['paciente'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
        <label class="desc" id="title1" for="Field1">
          Plano:<span id="req_1" class="req">*</span>
        </label>
        <div>
          <select name="planos_idplanos" onChange="">
            <option value="<?php echo $_GET['idplano']; ?>" selected="selected"><?php echo $_GET['plano']; ?></option>
            <?php echo Plano::option_plano(); ?>
          </select>
          <?php if(!empty($msg)): ?>
          <?php echo "<br />".$msg ?>
          <?php endif; ?>
        </div>
      </li>      
      <li class="<?php if(!empty($erros['telefone_celular'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
        <label class="desc" id="title1" for="Field1">
          Telefone Celular:<span id="req_1" class="req">*</span>
        </label>
        <div>
          <input name="telefone_celular" type="text" class="field text small" value="<?php if(isset($_GET['tc'])) echo $_GET['tc']; ?>" maxlength="9" tabindex="1" />
        </div>
        <div class="msg_erro">
          <?php if(!empty($erros['telefone_celular'])): ?>
          <?php echo "<br />".$erros['telefone_celular'] ?>
          <?php endif; ?>
        </div>
      </li>
      <li class="<?php if(!empty($erros['telefone_residencial'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
        <label class="desc" id="title1" for="Field1">
          Telefone Residencial:
        </label>
        <div>
          <input name="telefone_residencial" type="text" class="field text small" value="<?php if(isset($_GET['tr'])) echo $_GET['tr']; ?>" maxlength="9" tabindex="1" />
        </div>
        <div class="msg_erro">
          <?php if(!empty($erros['telefone_residencial'])): ?>
          <?php echo "<br />".$erros['telefone_residencial'] ?>
          <?php endif; ?>
        </div>
      </li>
      <li class="<?php if(!empty($erros['telefone_trabalho'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
        <label class="desc" id="title1" for="Field1">
          Telefone Trabalho:
        </label>
        <div>
          <input name="telefone_trabalho" type="text" class="field text small" value="<?php if(isset($_GET['tt'])) echo $_GET['tt']; ?>" maxlength="9" tabindex="1" />
        </div>
        <div class="msg_erro">
          <?php if(!empty($erros['telefone_trabalho'])): ?>
          <?php echo "<br />".$erros['telefone_trabalho'] ?>
          <?php endif; ?>
        </div>
      </li>
      <li class="<?php if(!empty($erros['nr_plano'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
        <label class="desc" id="title1" for="Field1">
          N&uacute;mero do plano:
        </label>
        <div>
          <input name="nr_plano" type="text" class="field text small" value="<?php if(isset($_GET['nr_plano'])) echo $_GET['nr_plano']; ?>" maxlength="20" tabindex="1" />
        </div>
        <div class="msg_erro">
          <?php if(!empty($erros['nr_plano'])): ?>
          <?php echo "<br />".$erros['nr_plano'] ?>
          <?php endif; ?>
        </div>
      </li>
      <li class="<?php if(!empty($erros['nascimento'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
        <label class="desc" id="title1" for="Field1">
          Data de Nascimento:
        </label>
        <div>
          <input name="dia" type="text" value="<?php echo $dia; ?>" maxlength="2" size="2"/> / 
          <input name="mes" type="text" value="<?php echo $mes; ?>" maxlength="2" size="2"/> / 
          <input name="ano" type="text" value="<?php echo $ano; ?>" maxlength="4" size="4"/>  
        </div>
        <div class="msg_erro">
          <?php if(!empty($erros['nascimento'])): ?>
          <?php echo "<br />".$erros['nascimento'] ?>
          <?php endif; ?>
        </div>
      </li>      <li class="<?php if(!empty($erros['nascimento'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
        <label class="desc" id="title1" for="Field1">
          Validade Plano:
        </label>
        <div>
          <input name="diaP" type="text" value="<?php echo $diaP; ?>" maxlength="2" size="2"/> / 
          <input name="mesP" type="text" value="<?php echo $mesP; ?>" maxlength="2" size="2"/> / 
          <input name="anoP" type="text" value="<?php echo $anoP; ?>" maxlength="4" size="4"/>  
        </div>
        <div class="msg_erro">
          <?php if(!empty($erros['dtValidadePlano'])): ?>
          <?php echo "<br />".$erros['dtValidadePlano'] ?>
          <?php endif; ?>
        </div>
      </li>
      <li class="<?php if(!empty($erros['cpf'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
        <label class="desc" id="title1" for="Field1">
          CPF:
        </label>
        <div>
          <input name="cpf" type="text" class="field text small" value="<?php if(isset($_GET['cpf'])) echo $_GET['cpf']; ?>" maxlength="11" tabindex="1" />
        </div>
        <div class="msg_erro">
          <?php if(!empty($erros['cpf'])): ?>
          <?php echo "<br />".$erros['cpf'] ?>
          <?php endif; ?>
        </div>
      </li>
      <li class="<?php if(!empty($erros['rg'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
        <label class="desc" id="title1" for="Field1">
          RG:
        </label>
        <div>
          <input name="rg" type="text" class="field text small" value="<?php if(isset($_GET['rg'])) echo $_GET['rg']; ?>" maxlength="14" tabindex="1" />
        </div>
        <div class="msg_erro">
          <?php if(!empty($erros['rg'])): ?>
          <?php echo "<br />".$erros['rg'] ?>
          <?php endif; ?>
        </div>
      </li>
      <li class="<?php if(!empty($erros['endereco'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
        <label class="desc" id="title1" for="Field1">
          Endere&ccedil;o:
        </label>
        <div>
          <input name="endereco" type="text" class="field text small" value="<?php if(isset($_GET['endereco'])) echo $_GET['endereco']; ?>" maxlength="100" tabindex="1" />
        </div>
        <div class="msg_erro">
          <?php if(!empty($erros['endereco'])): ?>
          <?php echo "<br />".$erros['endereco'] ?>
          <?php endif; ?>
        </div>
      </li>
      <li class="<?php if(!empty($erros['email'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
        <label class="desc" id="title1" for="Field1">
          E-mail:
        </label>
        <div>
          <input name="email" type="text" class="field text small" value="<?php if(isset($_GET['email'])) echo $_GET['email']; ?>" maxlength="50" tabindex="1" />
        </div>
        <div class="msg_erro">
          <?php if(!empty($erros['email'])): ?>
          <?php echo "<br />".$erros['email'] ?>
          <?php endif; ?>
        </div>
      </li>
      <li class="<?php if(!empty($erros['profissao'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
        <label class="desc" id="title1" for="Field1">
          Profiss&atilde;o:
        </label>
        <div>
          <input name="profissao" type="text" class="field text small" value="<?php if(isset($_GET['profissao'])) echo $_GET['profissao']; ?>" maxlength="30" tabindex="1" />
        </div>
        <div class="msg_erro">
          <?php if(!empty($erros['profissao'])): ?>
          <?php echo "<br />".$erros['profissao'] ?>
          <?php endif; ?>
        </div>
      </li>
      <li class="<?php if(!empty($erros['filiacao'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
        <label class="desc" id="title1" for="Field1">
          Filia&ccedil;&atilde;o:
        </label>
        <div>
          <input name="filiacao" type="text" class="field text small" value="<?php if(isset($_GET['filiacao'])) echo $_GET['filiacao']; ?>" maxlength="150" tabindex="1" />
        </div>
        <div class="msg_erro">
          <?php if(!empty($erros['filiacao'])): ?>
          <?php echo "<br />".$erros['filiacao'] ?>
          <?php endif; ?>
        </div>
      </li>
      <li class="buttons">
        <input id="saveForm" class="btTxt submit" type="submit" value="Alterar" />
      </li>
    </ul>
  </form>

<?php include('include/rodape.php'); ?>