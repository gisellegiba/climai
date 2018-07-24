<?php
	function valida_data($mes,$dia,$ano){
		if(checkdate($mes,$dia,$ano)){
			$dataatual = date('Ymd');
			$datacad   = $ano.$mes.$dia;
			if ($datacad > $dataatual){
				echo "<br/>A data de nascimento deve ser anterior a data atual!";
			}else{
				return true;
			}
		}else{
			echo "<br/> A data &eacute; inv&aacute;lida!";
		}
	}
?>