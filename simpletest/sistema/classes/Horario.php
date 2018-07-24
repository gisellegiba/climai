<?php
  /*
  Autor: Giselle Machado
  Data: 18/02/2012
  Descrição: Classe Horario
  Versão: 1.0
  */
  //inclui o arquivo de função validação de vazio
  require_once("funcoes/valida_empty.php");
  //require_once("funcoes/valida_cpf.php");
  require_once("conexao/conexao.php");  
  //declaração da classe USUARIO
  class Horario{
    private $id;//PK do Banco de dados
    private $descricao;
    private $funcionario;
    private $especialidade;
    private $diasemana;
    private $status;
  
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
      $this->id            = (empty($params['id']))? "" :$params['id'];
      $this->descricao   = (empty($params['descricao']))? "" :$params['descricao'];
      $this->funcionario   = (empty($params['funcionario']))? "" :$params['funcionario'];
      $this->especialidade = (empty($params['especialidade']))? "" :$params['especialidade'];
      $this->diasemana    = (empty($params['diasemana']))? "" :$params['diasemana'];
      $this->status    = (empty($params['status']))? "" :$params['status'];
    }
    public function verifica_cadastro(){
      $con = new PDO(DSN,USUARIO,SENHA);
      $sql = "SELECT descricao, idhorario, diasemana, status from horario where funcionarios_matricula = :funcionario AND descricao= :descricao AND diasemana = :diasemana order by descricao";
      $smt = $con->prepare($sql);
      $smt->bindParam(':funcionario',$this->funcionario);
      $smt->bindParam(':descricao',$this->descricao);
      $smt->bindParam(':diasemana',$this->diasemana);
      $smt->bindParam(':status',$this->status);
      $retorno = $smt->execute(); //executar a query de select

      if ($retorno === true){
        $dados = $smt->fetch();
        if($dados === false){
          return false;
        }else{
          return true;
        }
      }
    }
    public function cadastrar(){
      if(empty($this->especialidade)){
        $funci = $this->funcionario;
        $this->especialidade = Funcionario::funcionario_especialidade($funci);
      }
      $requeridos = array('descricao'=>$this->descricao,
                'funcionario'=>$this->funcionario,
                'especialidade'=>$this->especialidade,
                'diasemana'=>$this->diasemana);
      $mensagem = validaEmpty($requeridos);  

      if (empty($mensagem)){
//        $verifica_cadastro = $this->verifica_cadastro();
//        if($verifica_cadastro === true){
          $con = new PDO(DSN,USUARIO,SENHA);
          //validar os dados
          $sql = "INSERT INTO horario (descricao,status,funcionarios_matricula,funcionarios_especialidades_idespecialidades, diasemana)
                    VALUES (:descricao,:status,:funcionario,:especialidade,:diasemana)";
          $smt = $con->prepare($sql);
          $smt->bindParam(':descricao',$this->descricao);
          $smt->bindParam(':status',$this->status);
          $smt->bindParam(':funcionario',$this->funcionario);
          $smt->bindParam(':especialidade',$this->especialidade);
          $smt->bindParam(':diasemana',$this->diasemana);
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
/*        }else{
          $mensagem['descricao'] = "Hor&aacute;rio j&aacute; cadastrado!";
          $this->erros=$mensagem;
          return false;
        }
*/      }else{//deu erro
        $this->erros = $mensagem;
        return false;
      }
    }  
    public static function alterar_horario_especialidade($matricula,$especialidade){
      echo $matricula;
    }
    public static function alterar_situacao($d){
      $idA = $d['idhorario'];
      $sit = $d['status'];

      if(!empty($idA)){
        $con = new PDO(DSN,USUARIO,SENHA);
        //validar os dados
        $sql = "UPDATE horario SET status = :status
             WHERE idhorario = :id";

//$sql = "UPDATE horario SET status = '$sit' WHERE idhorario = $idA";
//echo $sql;
//exit();
        $smt = $con->prepare($sql);
        $smt->bindParam(':id',$idA);
        $smt->bindParam(':status',$sit);
        $retorno = $smt->execute(); //executar a query de insert

        unset($con);//fecha conexão
        return $retorno;
      }
    }
    public static function option_horario(){
      //conexao
      $con = new PDO(DSN,USUARIO,SENHA);
      //validar os dados
      $sql = "SELECT idhorario as id, descricao as nome, diasemana, status FROM horario ORDER BY descricao";
      $smt = $con->prepare($sql);
      $retorno = $smt->execute(); //executar a query de select

      //retorna false caso não seja possível executar o comando
      if ($retorno === true){
        $dados = $smt->fetchAll();
        $linhas = count($dados);
        if($dados === false){
          $this->erros['horario_id'] = 'Nenhum horario encontrado';
        }
        $option_horario = '';
        for ($i=0;$i<$linhas;$i++)
        {
          $option_horario .= '<option value="'.$dados[$i]['id'].'">'.trim($dados[$i]['nome']).' - '.trim($dados[$i]['diasemana']).' - '.trim($dados[$i]['status']).'</option>';
        }
        return $option_horario;  
      }
      unset($con);//fecha conexão
    }
    public static function consulta_horario($funcionario,$diasemana){

      //conexao
      $con = new PDO(DSN,USUARIO,SENHA);
      //validar os dados
      $sql = "SELECT descricao, idhorario, status FROM horario WHERE funcionarios_matricula = $funcionario AND diasemana = '$diasemana' ORDER BY descricao";
      //echo $sql;
      //exit();
      $smt = $con->prepare($sql);
      $retorno = $smt->execute(); //executar a query de select

      //retorna false caso não seja possível executar o comando
      if ($retorno === true){
        $dados = $smt->fetchAll();
        $linhas = count($dados);
        if($dados === false){
          $this->erros['horario_id'] = 'Nenhum horario encontrado';
        }
        $horario = '';
        for ($i=0;$i<$linhas;$i++)
        {
          $horario['descricao'][] = $dados[$i]['descricao'];
          $horario['idhorario'][] = $dados[$i]['idhorario'];
          $horario['status'][]    = $dados[$i]['status'];
        }
        return $horario;  
      }
      unset($con);//fecha conexão
    }
    public static function consulta_diasemana($funcionario,$diasemana){

      //conexao
      $con = new PDO(DSN,USUARIO,SENHA);
      //validar os dados
      $sql = "select distinct(diasemana) from horario where funcionarios_matricula = $funcionario and diasemana = '$diasemana' group by diasemana";
      //echo $sql;
      //exit();
      $smt = $con->prepare($sql);
      $retorno = $smt->execute(); //executar a query de select

      //retorna false caso não seja possível executar o comando
      if ($retorno === true){
        $dados = $smt->fetch();
        $linhas = count($dados);
        if($dados === false){
          $resultado = false;
        }else{
          $resultado = true;
        }
        return $resultado;  
      }
      unset($con);//fecha conexão
    }
    public static function consultar($dados2){
      $funcionario  = $dados2['funcionario'];
      //conexao
      $con = new PDO(DSN,USUARIO,SENHA);
      
      $sql = "SELECT a.descricao, a.idhorario, a.diasemana, b.nome as nome, a.status as status 
            FROM horario a, funcionarios b 
           WHERE a.funcionarios_matricula=b.matricula 
             AND a.funcionarios_matricula = :funcionario 
           ORDER BY diasemana, descricao";
//             AND a.funcionarios_matricula = ".$funcionario." 

//echo $sql;
//exit();
      $smt = $con->prepare($sql);
      $smt->bindParam(':funcionario',$funcionario);
      $retorno = $smt->execute(); //executar a query de select

      if ($retorno === true){
        $dados = $smt->fetchAll();
        $linhas = count($dados);
        if($dados === false){
          $this->erros['horario'] = 'Nenhum horario encontrado';
        }
        $total = '';
        $resultado  = "<table border='1' align='center'>";
        $resultado .= "<tr><td colspan='5'>".$dados[0]['nome']."</td></tr>
                 <tr><td colspan='5'>&nbsp;</td></tr>
                 <tr>
                <td>Codigo</td>
                <td>Descricao</td>
                <td>Dia da Semana</td>
                <td>Status</td>
                <td colspan='1' align='center'><a href='horarios_incluir.php?id=".$funcionario."&nome=".$dados[0]['nome']."&diasemana=".$dados[0]['diasemana']."'>incluir</a></td>
                 </tr>
                 <tr><td colspan='5'>&nbsp;</td></tr>";
        for ($i=0;$i<$linhas;$i++)
        {
          $diasemana = $dados[$i]['diasemana'];
          $status = $dados[$i]['status'];
          switch($diasemana){
            case '1segunda': $diasemana = 'Segunda-Feira'; break;
            case '2terca': $diasemana = 'Terça-Feira'; break;
            case '3quarta': $diasemana = 'Quarta-Feira'; break;
            case '4quinta': $diasemana = 'Quinta-Feira'; break;
            case '5sexta': $diasemana = 'Sexta-Feira'; break;
            case '6sabado': $diasemana = 'Sábado'; break;
          }
          $resultado .= '<tr><td> '.trim($dados[$i]['idhorario']).' </td> ';
          $resultado .= '<td> '.trim($dados[$i]['descricao']).' </td>';
          $resultado .= '<td> '.trim($diasemana).' </td>';
          $resultado .= '<td> '.trim($status).' </td>';
         
          if($status == "Inativo"){
            $resultado .= '<td><a href="horario_alterarStatus.php?idhorario='.$dados[$i]['idhorario'].'&status=Ativo&id='.$funcionario.'">Ativar</a></td>';                
          }else{
            $resultado .= '<td><a href="horario_alterarStatus.php?idhorario='.$dados[$i]['idhorario'].'&status=Inativo&id='.$funcionario.'">Desabilitar</a></td>';
          }
          //$resultado .= '<td> <a href="horarios_excluir.php?idhorario='.$dados[$i]['idhorario'].'&id='.$funcionario.'">excluir</a></td></tr>';
        }
        $resultado .= '</table>';
        return $resultado;  
      }
      unset($con);//fecha conexão
    }

    public static function excluir($dado){
      $id = $dado['idhorario'];
      //conexao
      $con = new PDO(DSN,USUARIO,SENHA);
      //validar os dados
      $sql = "DELETE FROM horario WHERE idhorario = :id";
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