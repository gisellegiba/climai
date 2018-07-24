<?php
	$v_TIPO = $_POST['tipo']; 
//	$v_TIPO = 'Comer';
	include('conexao/conexao.php'); 
	//conexao
	$con = new PDO(DSN,USUARIO,SENHA);
/*echo "<script language='javascript'>alert($v_TIPO);</script>"; 	*/	    	    

   $xml  = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
   $xml .= "<cidades2>\n";               

	$sql = "SELECT distinct descricao, iddescricao_despesas 
			  from descricao_despesas  
			 where tipo = '".$v_TIPO."'
			 order by descricao";
	$smt = $con->prepare($sql);
	$retorno = $smt->execute();
	if ($retorno){
		$dados = $smt->fetchAll();
				$linhas = count($dados);
				for ($i=0;$i<$linhas;$i++)
				{
					$xml .= "<cidade2>\n";
					$xml .= "<codigo2>".$dados[$i]['iddescricao_despesas']."</codigo2>\n";                  
					$xml .= "<descricao2>".$dados[$i]['descricao']."</descricao2>\n";
					$xml .= "</cidade2>\n";    
				}
   }
   $xml.= "</cidades2>\n";
   //CABEÇALHO
   Header("Content-type: application/xml; charset=iso-8859-1"); 
//PRINTA O RESULTADO  
echo $xml;
//echo "estou aqui";            
?>
