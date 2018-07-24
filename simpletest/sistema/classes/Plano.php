<?php
	/*
	Autor: Giselle Machado
	Data: 19/02/2012
	Descrição: Classe Plano
	Versão: 1.0
	*/
	//inclui o arquivo de função validação de vazio
	require_once("funcoes/valida_empty.php");
	//require_once("funcoes/valida_cpf.php");
	require_once("conexao/conexao.php");	
	//declaração da classe USUARIO
	class Plano{
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
				$sql = "INSERT INTO planos (descricao)
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
		public static function nome_plano($id){

			//conexao
			$con = new PDO(DSN,USUARIO,SENHA);
			//validar os dados
			$sql = "SELECT descricao
					  FROM planos 
					 WHERE idplanos = $id";
			$smt = $con->prepare($sql);
			$retorno = $smt->execute(); //executar a query de select

			//retorna false caso não seja possível executar o comando
			if ($retorno === true){
				$dados = $smt->fetch();
				if($dados === false){
					$this->erros['qtdeSessoes'] = 'Nenhum servico encontrado';
				}
				return $dados['descricao'];	
			}
			unset($con);//fecha conexão
		}
		public static function option_plano(){
			//conexao
			$con = new PDO(DSN,USUARIO,SENHA);
			//validar os dados
			$sql = "SELECT idplanos as id, descricao as nome FROM planos ORDER BY descricao";
			$smt = $con->prepare($sql);
			$retorno = $smt->execute(); //executar a query de select
	
			//retorna false caso não seja possível executar o comando
			if ($retorno === true){
				$dados = $smt->fetchAll();
				$linhas = count($dados);
				if($dados === false){
					$this->erros['plano_id'] = 'Nenhum plano encontrado';
				}
				$option_plano = '';
				for ($i=0;$i<$linhas;$i++)
				{
					$option_plano .= '<option value="'.$dados[$i]['id'].'">'.trim($dados[$i]['nome']).'</option>';
				}
				return $option_plano;	
			}
			unset($con);//fecha conexão
		}
		public static function consultar($dados2){
			$id  = $dados2['id'];
			//conexao
			$con = new PDO(DSN,USUARIO,SENHA);
			//validar os dados
			if (!$id){
				$sql = "SELECT * from planos order by descricao";
				$smt = $con->prepare($sql);
			}else{
				$sql = "SELECT * from planos where idplanos=:id order by descricao";
				$smt = $con->prepare($sql);
				$smt->bindParam(":id",$id);
			}
			$retorno = $smt->execute(); //executar a query de select

			if ($retorno === true){
				$dados = $smt->fetchAll();
				$linhas = count($dados);
				if($dados === false){
					$this->erros['planos'] = 'Nenhum plano encontrado';
				}
				$total = '';
				$resultado  = "<table border='1' align='center'>";
				$resultado .= "<tr>
								<td>Codigo</td>
								<td>Descricao</td>
								<td><a href='planos_incluir.php'>incluir</a></td>
							   </tr>
							   <tr><td colspan='5'>&nbsp;</td></tr>";
				for ($i=0;$i<$linhas;$i++)
				{
					$resultado .= '<tr><td> '.trim($dados[$i]['idplanos']).' </td> ';
					$resultado .= '<td> '.trim($dados[$i]['descricao']).' </td>';
					$resultado .= '<td> <a href="planos_excluir.php?idPlano='.$dados[$i]['idplanos'].'">excluir</a></td></tr>';
				}
				$resultado .= '</table>';
				return $resultado;	
			}
			unset($con);//fecha conexão
		}

		public static function excluir($dado){
			$id = $dado['idPlano'];
			//conexao
			$con = new PDO(DSN,USUARIO,SENHA);
			//validar os dados
			$sql = "DELETE FROM planos WHERE idplanos = :id";

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