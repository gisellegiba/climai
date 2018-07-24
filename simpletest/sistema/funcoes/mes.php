<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="calendario.css">
<?php 
class calendario{ 
	//Array com os meses do ano 
	var $mes=array('1'=>'JANEIRO', '2'=>'FEVEREIRO','3'=>'MARÇO',
				   '4'=>'ABRIL',   '5'=>'MAIO',     '6'=>'JUNHO',
				   '7'=>'JULHO',   '8'=>'AGOSTO',   '9'=>'SETEMBRO',
				   '10'=>'OUTUBRO','11'=>'NOVEMBRO','12'=>'DEZEMBRO');
	/* 
		$dia inteiro de 1 a 31 
		$mes inteiro de 1 a 12 
		$ano inteiro de 1901 a 2038 
	*/ 
	function cria($dia,$mes,$ano){ 
		//Corrige qualquer data invalida
		$verf=date ("d/n/Y", mktime (0,0,0,$mes,$dia,$ano)); 
		$pieces=explode("/",$verf); 
		$dia=$pieces[0]; 
		$mes=$pieces[1]; 
		$ano=$pieces[2]; 
		//Inteiro do ultimo dia do mês
		$last=date("d", mktime (0,0,0,$mes+1,0,$ano));
		//Numero de dias na primeira semana do mês 
		$diasem=date("w", mktime (0,0,0,$mes,1,$ano));
		//Total de linhas na tabela
		$numt=$last+$diasem;
		$numt=($numt%7 != 0)?($numt+7-$numt%7):$numt;
		
		for($i=0;$i < $numt;$i++){ 
			$data=$i-$diasem+1;
			if($i >= $diasem and $i < ($diasem+$last)){ 
				$d = $data;
				if($data==date('d') && $mes==date('m')){
					$data="<font class='calendario_hoje'>$data</font>";
				}
				if($i%7 == 0){ 
					$data="<font class='calendario_domingos'>$data</font>";
				}
				//aqui select para ver se contato tem algo no dia
				$aux[$i]="\n<td class='calendario_dias'><a href='#?dia=".$d."&mes=$mes&ano=$ano' class='calendario_links'>$data</a></td>";
			}else{ 
				$aux[$i]="\n<td > </td>"; 
			}
			if($i%7 == 0){
				$aux[$i]="<tr align=\"center\">".$aux[$i]; 
			}
			if($i%7 == 6){
				$aux[$i].="</tr>\n"; 
			}
		}
		echo "<table cellspacing='0' cellpadding='0' class='calendario_tabela'> 
				<tr>
					<td > 
						<table> 
							<tr class='calendario_mes_ano'> 
								<td colspan=\"7\">".$this->mes[$mes]." $ano</td> 
							</tr> 
							<tr class='calendario_semana'> 
								<td>D</td> 
								<td>S</td> 
								<td>T</td> 
								<td>Q</td> 
								<td>Q</td> 
								<td>S</td> 
								<td>S</td>
							</tr>"; 
		echo implode(" ",$aux);
		if(count($aux)==35){
			echo '<tr><td colspan="7"></td></tr>';
		};
		echo "</table></td></tr></table>"; 
	} 
} 
//Exemplos
$teste=new calendario;

echo '<table>';
for($i=1;$i<=12;$i++){
		echo '<tr>';
		echo '<td>';
		$teste->cria(date("d"),$i,date("Y"));
		echo '</td>';


}
echo '</table>';