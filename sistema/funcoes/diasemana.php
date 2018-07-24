<?php
function diasemana($mes,$dia,$ano)
{  // Traz o dia da semana para qualquer data informada
//$dia =  substr($data,0,2);
//$mes =  substr($data,3,2);
//$ano =  substr($data,6,9);
$diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano) );
switch($diasemana){  
	case"0": $diasemana = "7domingo";	   break;  
	case"1": $diasemana = "1segunda"; break;  
	case"2": $diasemana = "2terca";   break;  
	case"3": $diasemana = "3quarta";  break;  
	case"4": $diasemana = "4quinta";  break;  
	case"5": $diasemana = "5sexta";   break;  
	case"6": $diasemana = "6sabado";		break;  
			 }
return $diasemana;
}
?>