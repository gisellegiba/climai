<?php
	/*
	Autor: Giselle Machado
	Data: 18/02/2012
	Descrição: Classe Funcionário
	Versão: 1.0
	*/
	//inclui o arquivo de função validação de vazio
	require_once("funcoes/valida_empty.php");
	//require_once("funcoes/valida_cpf.php");
	require_once("conexao/conexao.php");	
	//declaração da classe USUARIO
	class Funcionario{
		private $matricula;//PK do Banco de dados
		private $nome;
		private $nr_conselho;
		private $percentual;
		private $especialidade;
		private $status1; //status, porém é uma palavra reserva do PHP
	
		public $erros;
		public function __construct($params){
			$this->carregar($params);
		}
		//função que pega os atributos privates
		public function __get($prop){
			return $this->$prop;
		}
		//recebe o nome seguido do valor para enviar os dados para o script que chama o objeto desta classe
		public function __set($prop, $val){
	
		}
		public function carregar($params){
			$this->matricula     = (empty($params['matricula']))? 0 :$params['matricula'];
			$this->nome  	     = (empty($params['nome']))? "" :$params['nome'];
			$this->nr_conselho   = (empty($params['nr_conselho']))? 0 :$params['nr_conselho'];
			$this->percentual    = (empty($params['percentual']))? 0 :$params['percentual'];
			$this->especialidade = (empty($params['especialidade']))? 0 :$params['especialidade'];
			$this->status1 	     = (empty($params['status']))? "" :$params['status'];
			
		}
		public function cadastrar(){
			$requeridos = array('nome'=>$this->nome, 
								'nr_conselho'=>$this->nr_conselho, 
								'especialidade'=>$this->especialidade, 
								'percentual'=>$this->percentual,
								'status1'=>$this->status1);
	
			$mensagem = validaEmpty($requeridos);	
	
			if (empty($mensagem)){
				$con = new PDO(DSN,USUARIO,SENHA);
				//validar os dados
				$sql = "INSERT INTO funcionarios (nome, nr_conselho, especialidades_idespecialidades, percentual)
									VALUES (:nome, :nr_conselho, :especialidade, :percentual, :st)";
//									VALUES (".$this->nome.",".$this->nr_conselho.",".$this->especialidade.",".$this->percentual.")";
//echo $sql;
//exit();
				$smt = $con->prepare($sql);
				$smt->bindParam(':nome',$this->nome);
				$smt->bindParam(':nr_conselho',$this->nr_conselho);
				$smt->bindParam(':especialidade',$this->especialidade);
				$smt->bindParam(':percentual',$this->percentual);
				$smt->bindParam(':st',$this->status1);
				$retorno = $smt->execute(); //executar a query de insert
	
				//retorna false caso não seja possível executar o comando
				if ($retorno === false){
					//erros do banco
					$con->errorInfo();
					//mostra a mensagem de erro.
					$this->erros['banco'] = 'Erro ao executar o comando';
				}
				unset($con);//fecha conexão
				return $retorno;
			}else{//deu erro
				$this->erros = $mensagem;
				return false;
			}
		}	
		public function alterar(){
			$requeridos = array('nome'=>$this->nome, 
								'matricula'=>$this->matricula, 								
								'nr_conselho'=>$this->nr_conselho, 
								'especialidade'=>$this->especialidade, 
								'percentual'=>$this->percentual);

			$mensagem = validaEmpty($requeridos);	

			if (empty($mensagem)){
				//exit();
				$con = new PDO(DSN,USUARIO,SENHA);
				//validar os dados
				$sql = "UPDATE funcionarios SET nome = :nome, nr_conselho = :nr_conselho,especialidades_idespecialidades = :especialidade, percentual = :percentual	WHERE matricula  = :matricula";
/*				$sql = "UPDATE funcionarios SET 
						nome = ".$this->nome.", nr_conselho = ".$this->nr_conselho.",
						especialidades_idespecialidades = ".$this->especialidade.", 
						percentual = ".$this->percentual."
						WHERE matricula  = ".$this->matricula;
echo $sql;
exit();
*/				
				$smt = $con->prepare($sql);
				$smt->bindParam(':nome',$this->nome);
				$smt->bindParam(':nr_conselho',$this->nr_conselho);
				$smt->bindParam(':especialidade',$this->especialidade);
				$smt->bindParam(':percentual',$this->percentual);
				$smt->bindParam(':matricula',$this->matricula);
				$retorno = $smt->execute(); //executar a query de insert

				//retorna false caso não seja possível executar o comando
				if ($retorno === false){
					//erros do banco
					$con->errorInfo();
					//mostra a mensagem de erro.
					$this->erros['banco'] = 'Erro ao executar o comando';
				}
				unset($con);//fecha conexão
				return $retorno;
			}else{//deu erro
				$this->erros = $mensagem;
				return false;
			}
		}	
		public static function option_funcionario(){
			//conexao
			$con = new PDO(DSN,USUARIO,SENHA);
			//validar os dados
			$sql = "SELECT matricula as id, nome FROM funcionarios ORDER BY nome";
			$smt = $con->prepare($sql);
			$retorno = $smt->execute(); //executar a query de select
	
			//retorna false caso não seja possível executar o comando
			if ($retorno === true){
				$dados = $smt->fetchAll();
				$linhas = count($dados);
				if($dados === false){
					$this->erros['funcionario_id'] = 'Nenhum funcion&aacute;rio encontrado';
				}
				$option_funcionario = '';
				for ($i=0;$i<$linhas;$i++)
				{
					$option_funcionario .= '<option value="'.$dados[$i]['id'].'">'.trim($dados[$i]['nome']).'</option>';
				}
				return $option_funcionario;	
			}
			unset($con);//fecha conexão
		}
		public static function option_funcionario_especialidade(){
			//conexao
			$con = new PDO(DSN,USUARIO,SENHA);
			//validar os dados
			$sql = "SELECT a.matricula as matricula, a.nome as nome, b.descricao as especialidade
					  FROM funcionarios a, especialidades b
					 WHERE a.especialidades_idespecialidades = b.idespecialidades 
					   AND a.status = 'ativo'
					   AND b.idespecialidades not in (1, 4, 13)
					 ORDER BY a.nome";
			$smt = $con->prepare($sql);
			$retorno = $smt->execute(); //executar a query de select

			//retorna false caso não seja possível executar o comando
			if ($retorno === true){
				$dados = $smt->fetchAll();
				$linhas = count($dados);
				if($dados === false){
					$this->erros['funcionario_id'] = 'Nenhum funcion&aacute;rio encontrado';
				}
				$option_funcionario = '';
				for ($i=0;$i<$linhas;$i++)
				{
					$option_funcionario .= '<option value="'.$dados[$i]['matricula'].'">'.trim($dados[$i]['nome']).' - '.trim($dados[$i]['especialidade']).'</option>';
				}
				return $option_funcionario;	
			}
			unset($con);//fecha conexão
		}
		public static function funcionario_especialidade($matricula){
			$requeridos = array('matricula'=>$matricula);
			$mensagem = validaEmpty($requeridos);		
			if (empty($mensagem)){
				$con = new PDO(DSN,USUARIO,SENHA);
				//validar os dados
				$sql = "SELECT especialidades_idespecialidades as esp FROM funcionarios WHERE matricula = :matricula";
				$smt = $con->prepare($sql);
				$smt->bindParam(':matricula',$matricula);
				$retorno = $smt->execute(); //executar a query de select
	
				//retorna false caso não seja possível executar o comando
				if ($retorno === true){
					$especialidade = $smt->fetch();
					return $especialidade['esp'];			
				}
				unset($con);//fecha conexão
			}else{//deu erro
				return false;
			}			
		}
		public static function funcionario_percentual($matricula){
			$requeridos = array('matricula'=>$matricula);
			$mensagem = validaEmpty($requeridos);		
			if (empty($mensagem)){
				$con = new PDO(DSN,USUARIO,SENHA);
				//validar os dados
				$sql = "SELECT percentual, nome FROM funcionarios WHERE matricula = :matricula";
				$smt = $con->prepare($sql);
				$smt->bindParam(':matricula',$matricula);
				$retorno = $smt->execute(); //executar a query de select
	
				//retorna false caso não seja possível executar o comando
				if ($retorno === true){
					$especialidade = $smt->fetch();
					return $especialidade;			
				}
				unset($con);//fecha conexão
			}else{//deu erro
				return false;
			}			
		}

		public static function consultaEspecialidade($matricula){
			$requeridos = array('matricula'=>$matricula);
			$mensagem = validaEmpty($requeridos);		
			if (empty($mensagem)){
				$con = new PDO(DSN,USUARIO,SENHA);
				//validar os dados
				$sql = "SELECT b.nome as funcionario, c.descricao as especialidade, c.idespecialidades as esp
						  FROM funcionarios b, especialidades c
						 WHERE b.matricula = $matricula
						   AND b.especialidades_idespecialidades = c.idespecialidades";
				//echo $sql;
				//exit();
				$smt = $con->prepare($sql);
				$retorno = $smt->execute(); //executar a query de select

				if ($retorno === true){
					$dados = $smt->fetchAll();
					$linhas = count($dados);
					for ($i=0;$i<$linhas;$i++){
						if(isset($dados[$i]['esp'])){
							$dadosFunc['idespecialidade'] = $dados[$i]['esp'];
							$dadosFunc['especialidade'] = $dados[$i]['especialidade'];
							$dadosFunc['nome'] = $dados[$i]['funcionario'];
						}//end if(isset($dados[$i]['esp']))
					}//end for($i=0;$i<$linhas;$i++)
					return $dadosFunc;			
				}
				unset($con);//fecha conexão
			}else{//deu erro
				return false;
			}			
		}
		public static function consultar($dados2){
			$login  = $dados2['login'];
			//conexao
			$con = new PDO(DSN,USUARIO,SENHA);
			//validar os dados
			if (!$login){
				$sql = "SELECT a.matricula as m, a.nome as n, a.nr_conselho as nr, a.percentual as p, b.descricao as esp, b.idespecialidades as n_esp FROM funcionarios a, especialidades b where a.especialidades_idespecialidades = b.idespecialidades order by a.nome";
				$smt = $con->prepare($sql);
			}else{
				$sql = "SELECT a.matricula as m, a.nome as n, a.nr_conselho as nr, a.percentual as p, b.descricao as esp, b.idespecialidades as n_esp FROM funcionarios a, especialidades b where a.especialidades_idespecialidades = b.idespecialidades and matricula = :login order by nome";
				$smt = $con->prepare($sql);
				$smt->bindParam(":login",$login);
			}
			$retorno = $smt->execute(); //executar a query de select

			if ($retorno === true){
				$dados = $smt->fetchAll();
				$linhas = count($dados);
				if($dados === false){
					$this->erros['funcionario'] = 'Nenhum funcionario encontrado';
				}
				$total = '';
				$resultado  = "<table border='1' align='center'>";
				$resultado .= "<tr>
								<td>Matricula</td>
								<td>Nome</td>
								<td>percentual</td>
								<td>Conselho</td>
								<td>Especialidade</td>
								<td colspan='2' align='center'><a href='funcionarios_incluir.php'>incluir</a></td>
							   </tr>
							   <tr><td colspan='7'>&nbsp;</td></tr>";
				for ($i=0;$i<$linhas;$i++)
				{
					$resultado .= '<tr><td> '.trim($dados[$i]['m']).' </td> ';
					$resultado .= '<td> '.trim($dados[$i]['n']).' </td> ';
					$resultado .= '<td> '.trim($dados[$i]['p']).' </td>';
					$resultado .= '<td> '.trim($dados[$i]['nr']).' </td>';
					$resultado .= '<td> '.trim($dados[$i]['esp']).' </td>';
					$resultado .= '<td> <a href="funcionarios_alterar.php?matricula='.$dados[$i]['m'].'&nome='.$dados[$i]['n'].'&conselho='.$dados[$i]['nr'].'&percentual='.$dados[$i]['p'].'&especialidade='.$dados[$i]['n_esp'].'&nome_especialidade='.$dados[$i]['esp'].'"> alterar</a> </td>';
					$resultado .= '<td> <a href="funcionarios_excluir.php?matricula='.$dados[$i]['m'].'">excluir</a></td></tr>';
				}
				$resultado .= '</table>';
				return $resultado;	
			}
			unset($con);//fecha conexão
		}

		public static function excluir($dado){
			$id = $dado['matricula'];
			//conexao
			$con = new PDO(DSN,USUARIO,SENHA);
			//validar os dados
			$sql = "DELETE FROM funcionarios WHERE matricula = :id";

			$smt = $con->prepare($sql);
			$smt->bindParam(":id",$id);
			$retorno = $smt->execute(); //executar a query de select

			//retorna false caso não seja possível executar o comando
			if ($retorno === false){
				return false;
			}else{
				return true;
			}
			unset($con);//fecha conexão
		}	
	}
?>