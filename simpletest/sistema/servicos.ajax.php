<?php
  header( 'Cache-Control: no-cache' );
  header( 'Content-type: application/xml; charset="utf-8"', true );

//importa a definição da classe Afiliado
require("include/autoload.php");

  $con = mysql_connect( 'mysql01.climai.hospedagemdesites.ws', 'climai', 'gbgack82' ) ;
  mysql_select_db( 'climai', $con );

  $paciente = mysql_real_escape_string( $_REQUEST['cod_estados'] );
//$paciente = 22;
  $cidades = array();

  $sql = "SELECT idservicos, descricao, nrGuia, qtdeSessoes
      FROM servicos
      WHERE pacientes_idpaciente=$paciente
      ORDER BY idservicos";


  $res = mysql_query( $sql );
  while ( $row = mysql_fetch_assoc( $res ) ) {
    $qtdeAtendimentos['servico'] = $row['idservicos'];
    $qtdeAtendimentos['paciente'] = $paciente;
    $qtde = Agenda::qtdeAtendimentos($qtdeAtendimentos);
    if ($row['qtdeSessoes'] > $qtde){
      $cidades[] = array(
        'cod_cidades'  => $row['idservicos'],
        'nrGuia'    => (utf8_encode($row['nrGuia'])),
        'nome'      => (utf8_encode($row['descricao'])),
      );
    }
  }
//print_r($cidades);
//exit();
  echo( json_encode( $cidades ) );