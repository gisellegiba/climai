<?php
/*
Autor: Giselle Machado
Data: 19/02/2012
Descrição: Formulário de cadastro de usuário
Versão: 1.0
*/

require('include/verificar_usuario.php');
$menu='usuario';
include('include/topo.php'); 

//importa a definição da classe Afiliado
require("include/autoload.php");
//error_reporting("E_ALL ~E_NOTICE");

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
  <title>Alterar Usu&aacute;rios</title>
</head>
<body id="public">
  <form class="wufoo rightLabel" method="post" action="usuario_alterar_salvar.php">
    <div class="info">
      <h2>Cadastro de Usuários</h2>
      <div>Campos marcados com * são requeridos</div>
    </div>
    <ul>
      <li class="<?php if(!empty($erros['nome'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
        <input type="hidden" name="id" value="<?php echo $_GET['idUsuario']; ?>" />
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
      <li class="<?php if(!empty($erros['funcionario'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
        <label class="desc" id="title1" for="Field1">
          Funcionário:<span id="req_1" class="req">*</span>
        </label>
        <div>
          <select name="funcionario" onChange="">
            <option value="<?php echo $_GET['funcionario']; ?>" selected="selected"><?php echo $_GET['nome_funcionario']; ?></option>
            <?php echo Funcionario::option_funcionario(); ?>
          </select>
        </div>
      </li>      
      <li class="<?php if(!empty($erros['perfil'])): ?>error<?php endif; ?>"> <!-- esse class é utilizado para marcar a linha que está com erro: error (do CSS)-->
        <label class="desc" id="title1" for="Field1">
          Perfil:<span id="req_1" class="req">*</span>
        </label>
        <div>
          <select name="perfil" onChange="">
            <?php
              $perfil = $_GET['perfil'];
              $selected_g = '';
              $selected_p = '';
              $selected_r = '';
              switch($perfil){
                case 'Gerente':
                  $selected_g = "selected";
                break; 
                case 'Profissional':
                  $selected_p = "selected";
                break; 
                case 'Recepcao':
                  $selected_r = "selected";
                break; 
              }
              echo '<option value="Profissional" '.$selected_p.'> Profissional</option>'; 
              echo '<option value="Recepcao" '.$selected_r.'> Recepção</option>'; 
              if ($_SESSION['usuario_perfil'] == "Gerente"){
                echo '<option value="Gerente" '.$selected_g.'> Gerente</option>'; 
              }
            ?>

          </select>
        </div>
      </li>      
      <li class="<?php if(!empty($erros['email'])): ?>error<?php endif; ?>">
        <label class="desc" id="title3" for="Field3">
          E-Mail:<span id="req_3" class="req">*</span>
        </label>
        <div>
          <input id="Field3" name="email" type="text" class="field text small" value="<?php if(isset($_GET['email'])) echo $_GET['email']; ?>"   maxlength="255" tabindex="2" /> 
        </div>
        <div class="msg_erro">
          <?php if(!empty($erros['email'])): ?>
          <?php echo "<br />".$erros['email'] ?>
          <?php endif; ?>
        </div>
      </li>
      <li class="<?php if(!empty($erros['login'])): ?>error<?php endif; ?>">
        <label class="desc" id="title4" for="Field4">
          Login:<span id="req_4" class="req">*</span>
        </label>
        <div>
          <input id="Field4"  name="login" type="text" class="field text small" value="<?php if(isset($_GET['login'])) echo $_GET['login']; ?>" maxlength="255" tabindex="3" />
          <div class="msg_erro"><?php if(!empty($erros['login'])): ?>
          <?php echo "<br />".$erros['login'] ?>
          <?php endif; ?>
          </div>
        </div>
      </li>
      <li id="foli5"   class="    ">
        <label class="desc" id="title5" for="Field5">
          Senha:<span id="req_5" class="req">*</span>
        </label>
        <div>
          <input id="Field5"   name="senha" type="password" class="field text small"   value="<?php if(isset($_GET['senha'])) echo $_GET['senha']; ?>" maxlength="255" tabindex="4" />
          <div class="msg_erro"><?php if(!empty($erros['senha'])): ?>
          <?php echo "<br />".$erros['senha'] ?>
          <?php endif; ?>
          <?php if(!empty($erros['banco'])): ?>
          <?php echo "<br />".$erros['banco'] ?>
          <?php endif; ?>
          <?php if(!empty($msg)): ?>
          <?php echo "<br />".$msg ?>
          <?php endif; ?>
          </div>
        </div>
      </li>
      <li class="buttons">
        <input id="saveForm" class="btTxt submit" type="submit" value="Alterar" />
      </li>
    </ul>
  </form>
  
<?php include('include/rodape.php'); ?>