<?php
	/*
	Autor: Giselle Machado
	Data: 18/02/2012
	Descrição: Classe Especialidade
	Versão: 1.0
	*/
	//inclui o arquivo de função validação de vazio
	require_once("funcoes/valida_empty.php");
	//require_once("funcoes/valida_cpf.php");
	require_once("conexao/conexao.php");	
	//declaração da classe USUARIO
	class Especialidade{
		private $id;//PK do Banco de dados
		private $descricao;
	
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
			$this->id        = (empty($params['id']))? "" :$params['id'];
			$this->descricao = (empty($params['descricao']))? "" :$params['descricao'];
		}
		public function cadastrar(){
			$requeridos = array('descricao'=>$this->descricao);
	
			$mensagem = validaEmpty($requeridos);	
	
			if (empty($mensagem)){
				$con = new PDO(DSN,USUARIO,SENHA);
				//validar os dados
				$sql = "INSERT INTO especialidades (descricao)
									VALUES (:descricao)";
				$smt = $con->prepare($sql);
				$smt->bindParam(':descricao',$this->descricao);
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
		public static function option_especialidade(){
			//conexao
			$con = new PDO(DSN,USUARIO,SENHA);
			//validar os dados
			$sql = "SELECT idespecialidades as id, descricao as nome FROM especialidades ORDER BY descricao";
			$smt = $con->prepare($sql);
			$retorno = $smt->execute(); //executar a query de select
	
			//retorna false caso não seja possível executar o comando
			if ($retorno === true){
				$dados = $smt->fetchAll();
				$linhas = count($dados);
				if($dados === false){
					$this->erros['especialidade_id'] = 'Nenhuma especialidade encontrada';
				}
				$option_especialidade = '';
				for ($i=0;$i<$linhas;$i++)
				{
					$option_especialidade .= '<option value="'.$dados[$i]['id'].'">'.trim($dados[$i]['nome']).'</option>';
				}
				return $option_especialidade;	
			}
			unset($con);//fecha conexão
		}
		public static function consultar($dados2){
			$id  = $dados2['id'];
			//conexao
			$con = new PDO(DSN,USUARIO,SENHA);
			//validar os dados
			if (!$id){
				$sql = "SELECT * from especialidades order by descricao";
				$smt = $con->prepare($sql);
			}else{
				$sql = "SELECT * from especialidades where idespecialidades=:id order by descricao";
				$smt = $con->prepare($sql);
				$smt->bindParam(":id",$id);
			}
			$retorno = $smt->execute(); //executar a query de select

			if ($retorno === true){
				$dados = $smt->fetchAll();
				$linhas = count($dados);
				if($dados === false){
					$this->erros['especialidades'] = 'Nenhuma especialidade encontrada';
				}
				$total = '';
				$resultado  = "<table border='1' align='center'>";
				$resultado .= "<tr>
								<td>Codigo</td>
								<td>Descricao</td>
								<td><a href='especialidades_incluir.php'>incluir</a></td>
							   </tr>
							   <tr><td colspan='5'>&nbsp;</td></tr>";
				for ($i=0;$i<$linhas;$i++)
				{
					$resultado .= '<tr><td> '.trim($dados[$i]['idespecialidades']).' </td> ';
					$resultado .= '<td> '.trim($dados[$i]['descricao']).' </td>';
					$resultado .= '<td> <a href="especialidades_excluir.php?idEspecialidade='.$dados[$i]['idespecialidades'].'">excluir</a></td></tr>';
				}
				$resultado .= '</table>';
				return $resultado;	
			}
			unset($con);//fecha conexão
		}

		public static function excluir($dado){
			$id = $dado['idEspecialidade'];
			//conexao
			$con = new PDO(DSN,USUARIO,SENHA);
			//validar os dados
			$sql = "DELETE FROM especialidades WHERE idespecialidades = :id";

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