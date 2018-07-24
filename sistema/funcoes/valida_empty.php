<?php
function validaEmpty($campos){
	$mensagens = array();
//	$nao = iconv("UTF-8","ISO-8859-1","&atilde");
	foreach($campos as $indice=>$campo){
		if (empty($campo)){
			$mensagens[$indice] = "O campo $indice n&atilde;o foi informado!";
		}
	}
	return $mensagens;
}
?>