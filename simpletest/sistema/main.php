<?php 
/*
Autor: Giselle Machado
Data: 18/02/2012
Descrição: Página inicial após o login
Versão: 1.0
*/

require('include/verificar_usuario.php');
$menu = '';
include('include/topo.php'); 

if($_SESSION['usuario_perfil'] == 'Profissional'){
  require("include/autoload.php");
  $func = $_SESSION['usuario_matricula'];
  
  $dadosFunc = Funcionario::consultaEspecialidade($func);
   
  $resultado  = "<center><table border='0' align='center'>";
        $resultado .= "<tr bgcolor='#EE82EE'><td colspan='17'><b>".trim($dadosFunc['nome'])."</b></td>
                 </tr>
                 <tr><td colspan='17'>&nbsp;</td></tr>";
        $resultado .= "</table></center>";
    echo $resultado;
 include("agenda_prof.php");

}else{
  echo	'<!-- Content -->
	<br/>
	<div id="content" class="shell">	
		<br/> <center><img src="images/LogoClimai.png" alt="LogoClimai" /></center>
	</div>
	<!-- End Content -->';

}	
 
  include("include/rodape.php"); 	
?>