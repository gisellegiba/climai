<?php
  /*
  Autor: Giselle Machado
  Data: 19/02/2012
  Descrição: Classe Paciente
  Versão: 1.0
  */
  //inclui o arquivo de função validação de vazio
  require_once("funcoes/valida_empty.php");
  //require_once("funcoes/valida_cpf.php");
  require_once("conexao/conexao.php");  
  //declaração da classe USUARIO
  class Paciente{
    public $cpf;//PK do Banco de dados
    public $nome;
    public $rg;
    public $endereco;
    public $telefone_residencial;
    public $telefone_celular;
    public $telefone_trabalho;
    public $email;
    public $profissao;
    public $dia;
    public $mes;
    public $ano;
    public $filiacao;
    public $nr_plano;
    public $diaP;
    public $mesP;
    public $anoP;
    public $planos_idplanos;
    public $id;
    
    public $erros;
    
    public function __construct($params){
      $this->carregar($params);
    }
    public function carregar($params){
      $this->id               = (empty($params['id']))? 0 :(int)$params['id'];;
      $this->cpf               = (empty($params['cpf']))? 0 :$params['cpf'];
      $this->nome             = (empty($params['nome']))? "" :$params['nome'];
      $this->rg                = (empty($params['rg']))? 0 :$params['rg'];
      $this->endereco           = (empty($params['endereco']))? "" :$params['endereco'];
      $this->telefone_residencial  = (empty($params['telefone_residencial']))? 0 :$params['telefone_residencial'];
      $this->telefone_celular    = (empty($params['telefone_celular']))? 0 :$params['telefone_celular'];
      $this->telefone_trabalho  = (empty($params['telefone_trabalho']))? 0 :$params['telefone_trabalho'];
      $this->email           = (empty($params['email']))? "" :$params['email'];
      $this->profissao         = (empty($params['profissao']))? "" :$params['profissao'];
      $this->dia                = (empty($params['dia']))? "" :$params['dia'];
      $this->mes                = (empty($params['mes']))? "" :$params['mes'];
      $this->ano                = (empty($params['ano']))? "" :$params['ano'];
      $this->filiacao         = (empty($params['filiacao']))? "" :$params['filiacao'];
      $this->nr_plano         = (empty($params['nr_plano']))? 0 :$params['nr_plano'];
      $this->diaP                = (empty($params['diaP']))? "" :$params['diaP'];
      $this->mesP                = (empty($params['mesP']))? "" :$params['mesP'];
      $this->anoP                = (empty($params['anoP']))? "" :$params['anoP'];
      $this->planos_idplanos     = (empty($params['planos_idplanos']))? 0 :$params['planos_idplanos'];
    }
    public function cadastrar(){
      if(checkdate($this->mes,$this->dia,$this->ano)){
        $data_nascimento = $this->ano."-".$this->mes."-".$this->dia;
      }else{
        $data_nascimento = "0000-00-00";
      }
      if(checkdate($this->mesP,$this->diaP,$this->anoP)){
        $dtValidadePlano = $this->anoP."-".$this->mesP."-".$this->diaP;
      }else{
        $dtValidadePlano = "0000-00-00";
      }
      $requeridos = array('nome'=>$this->nome, 
                'telefone celular'=>$this->telefone_celular, 
                'plano'=>$this->planos_idplanos);
      $mensagem = validaEmpty($requeridos);
      if (empty($mensagem)){
        $con = new PDO(DSN,USUARIO,SENHA);
        //validar os dados
        $sql = "INSERT INTO pacientes (cpf, nome, rg, endereco, telefone_residencial, telefone_celular, telefone_trabalho, email, profissao, data_nascimento, filiacao, nr_plano, dtValidadePlano, planos_idplanos)
                  VALUES (:cpf, :nome, :rg, :endereco, :telefone_residencial, :telefone_celular, :telefone_trabalho, :email, :profissao, :data_nascimento, :filiacao, :nr_plano, :dtValidadePlano, :planos_idplanos)";
//                  VALUES (".$this->nome.",".$this->nr_conselho.",".$this->especialidade.",".$this->percentual.")";
//echo $sql;
//exit();
        $smt = $con->prepare($sql);
        $smt->bindParam(':cpf',$this->cpf);
        $smt->bindParam(':nome',$this->nome);
        $smt->bindParam(':rg',$this->rg);
        $smt->bindParam(':endereco',$this->endereco);
        $smt->bindParam(':telefone_residencial',$this->telefone_residencial);
        $smt->bindParam(':telefone_celular',$this->telefone_celular);
        $smt->bindParam(':telefone_trabalho',$this->telefone_trabalho);
        $smt->bindParam(':email',$this->email);
        $smt->bindParam(':profissao',$this->profissao);
        $smt->bindParam(':data_nascimento',$data_nascimento);
        $smt->bindParam(':filiacao',$this->filiacao);
        $smt->bindParam(':nr_plano',$this->nr_plano);
        $smt->bindParam(':dtValidadePlano',$dtValidadePlano);
        $smt->bindParam(':planos_idplanos',$this->planos_idplanos);
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
      if(checkdate($this->mes,$this->dia,$this->ano)){
        $data_nascimento = $this->ano."-".$this->mes."-".$this->dia;
      }else{
        $data_nascimento = "0000-00-00";
      }
      if(checkdate($this->mesP,$this->diaP,$this->anoP)){
        $dtValidadePlano = $this->anoP."-".$this->mesP."-".$this->diaP;
      }else{
        $dtValidadePlano = "0000-00-00";
      }
      $requeridos = array('nome'=>$this->nome, 
                'telefone celular'=>$this->telefone_celular, 
                'plano'=>$this->planos_idplanos);

      $mensagem = validaEmpty($requeridos);  

      if (empty($mensagem)){
        $con = new PDO(DSN,USUARIO,SENHA);
        //validar os dados
        $sql = "UPDATE pacientes SET cpf = :cpf, nome = :nome, rg = :rg,endereco = :endereco, telefone_residencial = :telefone_residencial, telefone_celular = :telefone_celular, telefone_trabalho=:telefone_trabalho, email=:email, profissao=:profissao, data_nascimento=:data_nascimento, filiacao=:filiacao, nr_plano=:nr_plano, dtValidadePlano=:dtValidadePlano, planos_idplanos=:planos_idplanos WHERE idpaciente = :id";        
//        $sql = "UPDATE pacientes SET cpf =".$this->cpf.", nome = ".$this->nome.", rg = ".$this->rg.",endereco = ".$this->endereco.", telefone_residencial = ".$this->telefone_residencial.", telefone_celular = ".$this->telefone_celular.", telefone_trabalho=".$this->telefone_trabalho.", email=".$this->email.", profissao=".$this->profissao.", data_nascimento=".$data_nascimento.", filiacao=".$this->filiacao.", nr_plano=".$this->nr_plano.", dtValidadePlano=".$dtValidadePlano.", planos_idplanos=".$this->planos_idplanos." WHERE idpaciente = ".$this->id;        
//echo $sql;
//exit();
        $smt = $con->prepare($sql);
        $smt->bindParam(':cpf',$this->cpf);
        $smt->bindParam(':nome',$this->nome);
        $smt->bindParam(':rg',$this->rg);
        $smt->bindParam(':endereco',$this->endereco);
        $smt->bindParam(':telefone_residencial',$this->telefone_residencial);
        $smt->bindParam(':telefone_celular',$this->telefone_celular);
        $smt->bindParam(':telefone_trabalho',$this->telefone_trabalho);
        $smt->bindParam(':email',$this->email);
        $smt->bindParam(':profissao',$this->profissao);
        $smt->bindParam(':data_nascimento',$data_nascimento);
        $smt->bindParam(':filiacao',$this->filiacao);
        $smt->bindParam(':nr_plano',$this->nr_plano);
        $smt->bindParam(':dtValidadePlano',$dtValidadePlano);
        $smt->bindParam(':planos_idplanos',$this->planos_idplanos);
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
    public static function seleciona_plano_paciente($id){
      //conexao
      $con = new PDO(DSN,USUARIO,SENHA);
      //validar os dados
      $sql = "SELECT planos_idplanos as id FROM pacientes WHERE idpaciente = ".$id." ORDER BY nome";

      $smt = $con->prepare($sql);
      $retorno = $smt->execute(); //executar a query de select

      //retorna false caso não seja possível executar o comando
      if ($retorno === true){
        $dados = $smt->fetch();
        if($dados === false){
          $this->erros['paciente_id'] = 'Nenhum paciente encontrado';
        }
        return $dados['id'][0];  
      }
      unset($con);//fecha conexão
    }
    public static function seleciona_nome_paciente($id){
            $paciente = $id;
      //conexao
      $con = new PDO(DSN,USUARIO,SENHA);
      //validar os dados
      $sql = "SELECT nome, data_nascimento FROM pacientes WHERE idpaciente = ".$paciente." ORDER BY nome";

      $smt = $con->prepare($sql);
      $retorno = $smt->execute(); //executar a query de select

      //retorna false caso não seja possível executar o comando
      if ($retorno === true){
        $dados = $smt->fetch();
        if($dados === false){
          $this->erros['paciente_id'] = 'Nenhum paciente encontrado';
        }
//        echo $dados['nome'];
//        exit();
        $diaNasc = substr(trim($dados['data_nascimento']),8,2);
        $mesNasc = substr(trim($dados['data_nascimento']),5,2);
        $anoNasc = substr(trim($dados['data_nascimento']),0,4);
        $dataNasc = $diaNasc.'/'.$mesNasc.'/'.$anoNasc;

        $resultado = $dataNasc." - ".$dados['nome'];
        return $resultado;  
      }
      unset($con);//fecha conexão
    }
    public static function option_paciente(){
      //conexao
      $con = new PDO(DSN,USUARIO,SENHA);
      //validar os dados
      $sql = "SELECT idpaciente as id, nome, data_nascimento FROM pacientes ORDER BY nome, data_nascimento";
//echo $sql;
//exit();
      $smt = $con->prepare($sql);
      $retorno = $smt->execute(); //executar a query de select
  
      //retorna false caso não seja possível executar o comando
      if ($retorno === true){
        $dados = $smt->fetchAll();
        $linhas = count($dados);
        if($dados === false){
          $this->erros['paciente_id'] = 'Nenhum paciente encontrado';
        }
        $option_paciente = '';
        for ($i=0;$i<$linhas;$i++)
        {
//          $diaNasc = substr(trim($dados[$i]['data_nascimento']),8,2);
//          $mesNasc = substr(trim($dados[$i]['data_nascimento']),5,2);
//          $anoNasc = substr(trim($dados[$i]['data_nascimento']),0,4);
//          $dataNasc = $diaNasc.'/'.$mesNasc.'/'.$anoNasc;
          $option_paciente .= '<option value="'.$dados[$i]['id'].'">'.trim($dados[$i]['nome']).'</option>';
        }
        return $option_paciente;  
      }
      unset($con);//fecha conexão
    }
    public static function consultar($dados2){
      $id  = $dados2['login'];
      //conexao
      $con = new PDO(DSN,USUARIO,SENHA);
      //validar os dados
      if (!$id){
        $sql = "SELECT a.idpaciente as id, a.cpf, a.nome, a.rg, a.endereco, a.telefone_residencial, 
                       a.telefone_celular, a.telefone_trabalho, a.email, 
                 a.profissao, a.data_nascimento, a.filiacao, 
                 a.nr_plano, b.descricao as plano, b.idplanos, a.dtValidadePlano
              FROM pacientes a, planos b 
             WHERE a.planos_idplanos = b.idplanos 
             ORDER BY a.nome";
        $smt = $con->prepare($sql);
      }else{
        $sql = "SELECT a.idpaciente as id, a.cpf, a.nome, a.rg, a.endereco, a.telefone_residencial, 
                 a.telefone_celular, a.telefone_trabalho, a.email, 
                 a.profissao, a.data_nascimento, a.filiacao, 
                 a.nr_plano, b.descricao as plano, b.idplanos, a.dtValidadePlano
              FROM pacientes a, planos b 
             WHERE a.planos_idplanos = b.idplanos
               AND a.idpacientes = :idpacientes 
             ORDER BY a.nome";
        $smt = $con->prepare($sql);
        $smt->bindParam(":id",$id);
      }
      $retorno = $smt->execute(); //executar a query de select

      if ($retorno === true){
        $dados = $smt->fetchAll();
        $linhas = count($dados);
        if($dados === false){
          $this->erros['paciente'] = 'Nenhum paciente encontrado';
        }
        $total = '';
        $resultado  = "<table border='1' align='center'>";
        $resultado .= "<tr>
                <td>CPF</td>
                <td>Nome</td>
                <td>RG</td>
                <td>Endere&ccedil;o</td>
                <td>Telefone <br> Residencial</td>
                <td>Telefone <br> Celular</td>
                <td>Telefone <br> Trabalho</td>
                <td>e-mail</td>
                <td>Profiss&atilde;o</td>
                <td>Data de <br> nascimento</td>
                <td>Filia&ccedil;&atilde;o</td>
                <td>Nr Plano</td>
                <td>Validade Plano</td>
                <td>Plano</td>
                <td colspan='1' align='center'><a href='pacientes_incluir.php'>incluir</a></td>
                 </tr>
                 <tr><td colspan='15'>&nbsp;</td></tr>";
        for ($i=0;$i<$linhas;$i++)
        {
          $diaNasc = substr(trim($dados[$i]['data_nascimento']),8,2);
          $mesNasc = substr(trim($dados[$i]['data_nascimento']),5,2);
          $anoNasc = substr(trim($dados[$i]['data_nascimento']),0,4);
          $dataNasc = $diaNasc.'/'.$mesNasc.'/'.$anoNasc;
          //echo $dataNasc;
          $diaP = substr(trim($dados[$i]['dtValidadePlano']),8,2);
          $mesP = substr(trim($dados[$i]['dtValidadePlano']),5,2);
          $anoP = substr(trim($dados[$i]['dtValidadePlano']),0,4);
          $dtValidadePlano = $diaP.'/'.$mesP.'/'.$anoP;
          $resultado .= '<tr><td> '.trim($dados[$i]['cpf']).' </td> ';
          $resultado .= '<td> '.trim($dados[$i]['nome']).' </td> ';
          $resultado .= '<td> '.trim($dados[$i]['rg']).' </td>';
          $resultado .= '<td> '.trim($dados[$i]['endereco']).' </td>';
          $resultado .= '<td> '.trim($dados[$i]['telefone_residencial']).' </td>';
          $resultado .= '<td> '.trim($dados[$i]['telefone_celular']).' </td>';
          $resultado .= '<td> '.trim($dados[$i]['telefone_trabalho']).' </td>';
          $resultado .= '<td> '.trim($dados[$i]['email']).' </td>';
          $resultado .= '<td> '.trim($dados[$i]['profissao']).' </td>';
          $resultado .= '<td> '.$dataNasc.' </td>';
          $resultado .= '<td> '.trim($dados[$i]['filiacao']).' </td>';
          $resultado .= '<td> '.trim($dados[$i]['nr_plano']).' </td>';
          $resultado .= '<td> '.$dtValidadePlano.' </td>';
          $resultado .= '<td> '.trim($dados[$i]['plano']).' </td>';
          $resultado .= '<td> <a href="pacientes_alterar.php?id='.$dados[$i]['id'].'&idplano='.$dados[$i]['idplanos'].'&plano='.$dados[$i]['plano'].'&nr_plano='.$dados[$i]['nr_plano'].'&dtValidadePlano='.$dados[$i]['dtValidadePlano'].'&filiacao='.$dados[$i]['filiacao'].'&dn='.$dados[$i]['data_nascimento'].'&profissao='.$dados[$i]['profissao'].'&tt='.$dados[$i]['telefone_trabalho'].'&tc='.$dados[$i]['telefone_celular'].'&tr='.$dados[$i]['telefone_residencial'].'&endereco='.$dados[$i]['endereco'].'&cpf='.$dados[$i]['cpf'].'&nome='.$dados[$i]['nome'].'&email='.$dados[$i]['email'].'&rg='.$dados[$i]['rg'].'">alterar</a></td>';
        //  $resultado .= '<td> <a href="pacientes_excluir.php?id='.$dados[$i]['id'].'">excluir</a></td></tr>';
        }
        $resultado .= '</table>';
        return $resultado;  
      }
      unset($con);//fecha conexão
    }

    public static function excluir($dado){
      $id = $dado['id'];
      //conexao
      $con = new PDO(DSN,USUARIO,SENHA);
      //validar os dados
      $sql = "DELETE FROM pacientes WHERE idpaciente = :id";

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