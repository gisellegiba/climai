<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Gest&atilde;o Climai..............</title>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <!-- Meta Tags -->
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
  <link rel="stylesheet" href="css/structure.css" type="text/css" />
  <link rel="stylesheet" href="css/form.css" type="text/css" />
  <!-- JavaScript -->
  <script type="text/javascript" src="scripts/wufoo.js"></script>  
  <script src="ajax.js" type="text/javascript"></script>
</head>
<body>
  <!-- Header -->
  <div id="header">
    <div class="shell">
      <?php if (empty($_SESSION['usuario_logado'])): $menu=''; ?>

      <?php else: ?>
      <div id="head">
        <div class="right">
          <p>
            Bem-vindo | 
            <a href="sair.php">Sair</a>
          </p>
        </div>
      </div>
      <?php
        if($_SESSION['usuario_perfil'] == 'Gerente'){
      ?>
      <!-- Navigation -->
      <div id="navigation">
        <ul>
          <li><a href="especialidades.php" <?php if($menu=='especialidades') echo 'class="active"'; ?> ><span>Especialidades</span></a></li>
          <li><a href="planos.php" <?php if($menu=='planos') echo 'class="active"'; ?> ><span>Planos</span></a></li>
          <li><a href="funcionarios.php" <?php if($menu=='funcionarios') echo 'class="active"'; ?> ><span>Funcion&aacute;rios</span></a></li>
          <li><a href="pacientes.php" <?php if($menu=='pacientes') echo 'class="active"'; ?> ><span>Pacientes</span></a></li>
          <li><a href="horarios.php" <?php if($menu=='horarios') echo 'class="active"'; ?> ><span>Hor&aacute;rios</span></a></li>
          <li><a href="usuario.php" <?php if($menu=='usuario') echo 'class="active"'; ?> ><span>Usu&aacute;rio</span></a></li>
          <li><a href="servicos.php" <?php if($menu=='servicos') echo 'class="active"'; ?> ><span>Servi&ccedil;os</span></a></li>
          <li><a href="agenda.php" <?php if($menu=='agenda') echo 'class="active"'; ?> ><span>Agenda</span></a></li>
          <li><a href="consultas_gerenciais.php" <?php if($menu=='consultas_gerenciais') echo 'class="active"'; ?> ><span>Consultas Gerenciais</span></a></li>
        </ul>
      </div>
      <?php 
        }elseif($_SESSION['usuario_perfil'] == 'Profissional'){
      ?>
            <!-- Navigation -->
<!--      <div id="navigation">
        <ul>
          <li><a href="agenda_prof.php" <?php if($menu=='agenda') echo 'class="active"'; ?> ><span>Agenda</span></a></li>
        </ul>
      </div>
  -->    <?php
        }elseif($_SESSION['usuario_perfil'] == 'Recepcao'){
      ?>
      <!-- Navigation -->
      <div id="navigation">
        <ul>
          <li><a href="horarios.php" <?php if($menu=='horarios') echo 'class="active"'; ?> ><span>Hor&aacute;rios</span></a></li>
          <li><a href="pacientes.php" <?php if($menu=='pacientes') echo 'class="active"'; ?> ><span>Pacientes</span></a></li>
          <li><a href="servicos.php" <?php if($menu=='servicos') echo 'class="active"'; ?> ><span>Servi&ccedil;os</span></a></li>
          <li><a href="agenda.php" <?php if($menu=='agenda') echo 'class="active"'; ?> ><span>Agenda</span></a></li>
        </ul>
      </div>
      <?php
        }
      ?>
      <!-- End Navigation -->
      <?php endif; ?>
      
    </div>
  </div>
  <!-- End Header -->