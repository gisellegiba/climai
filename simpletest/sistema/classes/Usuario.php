<?php
	/*
	Autor: Giselle Machado
	Data: 18/02/2012
	Descrição: Classe Usuario
	Versão: 1.0
	*/
	//inclui o arquivo de função validação de vazio
	require_once("funcoes/valida_empty.php");
	//require_once("funcoes/valida_cpf.php");
	require_once("conexao/conexao.php");	
	//declaração da classe USUARIO
	class Usuario{
		private $id;//PK do Banco de dados
		private $nome;
		private $login;
		private $senha;
		private $email;
		private $perfil;
		private $usuario_id;
		private $funcionario;
		private $especialidade;
	
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
			$this->id    	     = (empty($params['id']))? 0 :(int)$params['id'];;
			$this->nome  	     = (empty($params['nome']))? "" :$params['nome'];
			$this->email 	     = (empty($params['email']))? "" :$params['email'];
			$this->login 	     = (empty($params['login']))? "" :$params['login'];
			$this->perfil 	     = (empty($params['perfil']))? "" :$params['perfil'];
			$this->senha 	     = (empty($params['senha']))? "" :$params['senha'];
			$this->usuario_id    = (empty($params['usuario_id']))? "" :$params['usuario_id'];
			$this->funcionario   = (empty($params['funcionario']))? "" :$params['funcionario'];
			$this->especialidade = (empty($params['especialidade']))? "" :$params['especialidade'];
		}
		public function logar(){
			//valida login e senha
			$requeridos = array('login'=>$this->login, 
								'senha'=>$this->senha);
			$mensagem = validaEmpty($requeridos);		
			if (empty($mensagem)){
				$con = new PDO(DSN,USUARIO,SENHA);
				//validar os dados
				$sql = "SELECT idUsuario as id, login, senha, perfil, funcionarios_matricula as matricula FROM usuarios WHERE login = :login AND senha = :senha";
				$smt = $con->prepare($sql);
				$smt->bindParam(':login',$this->login);
				$smt->bindParam(':senha',$this->senha);
				$retorno = $smt->execute(); //executar a query de select
	
				//retorna false caso não seja possível executar o comando
				if ($retorno === false){
					//erros do banco
					$tmp = $con->errorInfo();
					//mostra a mensagem de erro.
					$this->erros['banco'] = 'Erro ao executar o comando';
					return false;
				}else{
					$dados = $smt->fetch();
					if($dados === false){
						$this->erros['login'] = 'Usuário não encontrado';
					}
					return $dados;			
				}
				unset($con);//fecha conexão
			}else{//deu erro
				$this->erros = $mensagem;
				return false;
			}			
		}
		public function cadastrar(){
			$requeridos = array('nome'=>$this->nome, 
								'email'=>$this->email, 
								'funcionario'=>$this->funcionario, 
								'especialidade'=>$this->especialidade, 
								'perfil'=>$this->perfil, 
								'login'=>$this->login, 
								'senha'=>$this->senha);
	
			$mensagem = validaEmpty($requeridos);	
	
			if (empty($mensagem)){
				$con = new PDO(DSN,USUARIO,SENHA);
				//validar os dados
				$sql = "INSERT INTO usuarios (nome, email, login, senha, perfil, funcionarios_matricula, funcionarios_especialidades_idespecialidades)
									VALUES (:nome, :email, :login, :senha, :perfil, :funcionario, :especialidade)";
//									VALUES (".$this->nome.",".$this->email.",".$this->login.",".$this->senha.",".$this->perfil.",".$this->funcionario.",".$this->especialidade.")";

				$smt = $con->prepare($sql);
				$smt->bindParam(':nome',$this->nome);
				$smt->bindParam(':email',$this->email);
				$smt->bindParam(':login',$this->login);
				$smt->bindParam(':senha',$this->senha);
				$smt->bindParam(':perfil',$this->perfil);
				$smt->bindParam(':funcionario',$this->funcionario);
				$smt->bindParam(':especialidade',$this->especialidade);
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
								'id'=>$this->id, 
								'email'=>$this->email, 
								'funcionario'=>$this->funcionario,  
								'perfil'=>$this->perfil, 
								'login'=>$this->login, 
								'senha'=>$this->senha);
			$mensagem = validaEmpty($requeridos);	

			if (empty($mensagem)){
				$con = new PDO(DSN,USUARIO,SENHA);
				//validar os dados
				$sql = "UPDATE usuarios SET nome = :nome, email = :email, login = :login, senha = :senha, perfil =:perfil, funcionarios_matricula = :funcionario WHERE idUsuario  = :id";
/*			$sql = "UPDATE usuarios SET nome = ".$this->nome.", email = ".$this->email.", login = ".$this->login.", senha = ".$this->senha.", perfil = ".$this->perfil.", funcionarios_matricula = ".$this->funcionario." WHERE idUsuario  = ".$this->id;
echo $sql;
exit();
*/
				$smt = $con->prepare($sql);
				$smt->bindParam(':nome',$this->nome);
				$smt->bindParam(':email',$this->email);
				$smt->bindParam(':login',$this->login);
				$smt->bindParam(':senha',$this->senha);
				$smt->bindParam(':perfil',$this->perfil);
				$smt->bindParam(':funcionario',$this->funcionario);
				$smt->bindParam(':id',$this->id);
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
		public static function option_usuario(){
			//conexao
			$con = new PDO(DSN,USUARIO,SENHA);
			//validar os dados
			$sql = "SELECT idUsuario as id, nome FROM usuarios ORDER BY nome";
			$smt = $con->prepare($sql);
			$retorno = $smt->execute(); //executar a query de select
	
			//retorna false caso não seja possível executar o comando
			if ($retorno === true){
				$dados = $smt->fetchAll();
				$linhas = count($dados);
				if($dados === false){
					$this->erros['usuario_id'] = 'Nenhum usuário encontrado';
				}
				$option_usuario = '';
				for ($i=0;$i<$linhas;$i++)
				{
					$option_usuario .= '<option value="'.$dados[$i]['id'].'">'.trim($dados[$i]['nome']).'</option>';
				}
				return $option_usuario;	
			}
			unset($con);//fecha conexão
		}
		public static function usuario_nome($usuario_id){
			$mensagem = validaEmpty($usuario_id);		
			if (empty($mensagem)){
				$con = new PDO(DSN,USUARIO,SENHA);
				//validar os dados
				$sql = "SELECT nome FROM usuarios WHERE idUsuario = :usuario_id";
				$smt = $con->prepare($sql);
				$smt->bindParam(':usuario_id',$usuario_id['usuario_id']);
				$retorno = $smt->execute(); //executar a query de select
	
				//retorna false caso não seja possível executar o comando
				if ($retorno === true){
					$usuario_nome = $smt->fetch();
					return $usuario_nome['nome'];			
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
				$sql = "SELECT a.nome, a.perfil, a.login, a.email, a.senha, a.idUsuario, b.matricula as funcionario, b.nome as nome_funcionario FROM usuarios a, funcionarios b where a.funcionarios_matricula=b.matricula order by nome";
				$smt = $con->prepare($sql);
			}else{
				$sql = "SELECT a.nome, a.perfil, a.login, a.email, a.senha, a.idUsuario, b.matricula as funcionario, b.nome as nome_funcionario FROM usuarios a, funcionarios b where login = :login	AND a.funcionarios_matricula=b.matricula order by nome";
				$smt = $con->prepare($sql);
				$smt->bindParam(":login",$login);
			}
			$retorno = $smt->execute(); //executar a query de select

			if ($retorno === true){
				$dados = $smt->fetchAll();
				$linhas = count($dados);
				if($dados === false){
					$this->erros['receita'] = 'Nenhum usuario encontrado';
				}
				$total = '';
				$resultado  = "<table border='1' align='center'>";
				$resultado .= "<tr>
								<td>Nome</td>
								<td>Perfil</td>
								<td>Login</td>
								<td>Senha</td>
								<td>E-mail</td>
								<td colspan='2' align='center'><a href='usuario_incluir.php'>incluir</a></td>
							   </tr>
							   <tr><td colspan='8'>&nbsp;</td></tr>";
				for ($i=0;$i<$linhas;$i++)
				{
					$resultado .= '<tr><td> '.trim($dados[$i]['nome']).' </td> ';
					$resultado .= '<td> '.trim($dados[$i]['perfil']).' </td>';
					$resultado .= '<td> '.trim($dados[$i]['login']).' </td>';
					$resultado .= '<td> '.trim($dados[$i]['senha']).' </td>';
					$resultado .= '<td> '.trim($dados[$i]['email']).' </td>';
					$resultado .= '<td> <a href="usuario_alterar.php?idUsuario='.$dados[$i]['idUsuario'].'&nome='.$dados[$i]['nome'].'&funcionario='.$dados[$i]['funcionario'].'&nome_funcionario='.$dados[$i]['nome_funcionario'].'&perfil='.$dados[$i]['perfil'].'&email='.$dados[$i]['email'].'&login='.$dados[$i]['login'].'&senha='.$dados[$i]['senha'].'">alterar</a></td>';
					$resultado .= '<td> <a href="usuario_excluir.php?idUsuario='.$dados[$i]['idUsuario'].'">excluir</a></td></tr>';
				}
				$resultado .= '</table>';
				return $resultado;	
			}
			unset($con);//fecha conexão
		}
		public static function excluir($dado){
			$id = $dado['idUsuario'];
			//conexao
			$con = new PDO(DSN,USUARIO,SENHA);
			//validar os dados
			$sql = "DELETE FROM usuarios WHERE idUsuario = :id";

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