<?php
  /*
  Autor: Giselle Machado
  Data: 07/04/2015
  Descrição: Classe Servico
  Versão: 1.0
  */
  //inclui o arquivo de função validação de vazio
  require_once("funcoes/valida_empty.php");
  //require_once("funcoes/valida_cpf.php");
  require_once("conexao/conexao.php");  
  //declaração da classe USUARIO
  class Servico{
    private $id;
    private $descricao;
    private $valor;
    private $nrGuia;
    private $qtdeSessoes;
    private $dataCadastro;
    private $paciente;
    private $plano;
    private $especialidade;
  
    public $erros;
    public function __construct($params){
      $this->carregar($params);
    }
    public function carregar($params){
      $this->id           = (empty($params['id']))? 0 :$params['id'];
      $this->descricao   = (empty($params['descricao']))? "" :$params['descricao'];
      $this->valor      = (empty($params['valor']))? 0 :$params['valor'];
      $this->nrGuia     = (empty($params['nrGuia']))? 0 :$params['nrGuia'];
      $this->qtdeSessoes   = (empty($params['qtdeSessoes']))? 0 :$params['qtdeSessoes'];
      $this->dataCadastro   = (empty($params['dataCadastro']))? "" :$params['dataCadastro'];
      $this->paciente     = (empty($params['paciente']))? 0 :$params['paciente'];
      $this->plano      = (empty($params['plano']))? 0 :$params['plano'];
      $this->especialidade = (empty($params['especialidade']))? 0 :$params['especialidade'];
    }
    public function cadastrar(){
      $requeridos = array('valor'=>$this->valor,
                'qtdeSessoes'=>$this->qtdeSessoes,
                'paciente'=>$this->paciente,
                'especialidade'=>$this->especialidade,
                'plano'=>$this->plano);
      $mensagem = validaEmpty($requeridos);  

      if (empty($mensagem)){
        $con = new PDO(DSN,USUARIO,SENHA);
        //validar os dados
        $sql = "INSERT INTO servicos (descricao,valor,nrGuia,qtdeSessoes,pacientes_idpaciente,pacientes_planos_idplanos,especialidades_idespecialidades)
                  VALUES (:descricao,:valor,:nrGuia,:qtdeSessoes,:paciente,:plano,:especialidade)";
//        $sql = "INSERT INTO servicos (descricao,valor,nrGuia,qtdeSessoes,pacientes_idpaciente,pacientes_planos_idplanos,especialidades_idespecialidades)
//                  VALUES ('".$this->descricao."',".$this->valor.",".$this->nrGuia.",".$this->qtdeSessoes.",'".$this->paciente."',".$this->plano.",".$this->especialidade.")";
//echo $sql;
//exit();
        $smt = $con->prepare($sql);
        $smt->bindParam(':descricao',$this->descricao);
        $smt->bindParam(':valor',$this->valor);
        $smt->bindParam(':nrGuia',$this->nrGuia);
        $smt->bindParam(':qtdeSessoes',$this->qtdeSessoes);
        $smt->bindParam(':paciente',$this->paciente);
        $smt->bindParam(':plano',$this->plano);
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

    public static function seleciona_servico_paciente($id){
      //conexao
      $con = new PDO(DSN,USUARIO,SENHA);
      //validar os dados
      $sql = "SELECT idservicos as id FROM servicos WHERE pacientes_idpaciente = ".$id." ORDER BY dataCadastro";
      $smt = $con->prepare($sql);
      $retorno = $smt->execute(); //executar a query de select

      //retorna false caso não seja possível executar o comando
      if ($retorno === true){
        $dados = $smt->fetch();
        if($dados === false){
          $this->erros['idservico'] = 'Nenhum servico encontrado';
        }
        return $dados['id'][0];  
      }
      unset($con);//fecha conexão
    }
    public static function consultar($dados){
      $paciente = $dados['paciente'];

//print_r($dados);
//exit();
      $con = new PDO(DSN,USUARIO,SENHA);

      $nomePaciente = Paciente::seleciona_nome_paciente($paciente);
      $resultado = "";
      $resultado  = "<table border='1' align='center'>";
      $resultado .= "<tr><td colspan='9'>".$nomePaciente."</td></tr>
               <tr>
                 <td>C&oacute;digo</td>
              <td>Descri&ccedil;&atilde;o</td>
              <td>Nr Guia</td>
              <td>Qtde Sess&otilde;es</td>
              <td>Atendimentos Realizados</td>
              <td>Especialidade</td>
              <td>Valor</td>
              <td colspan='2'><a href='servico_incluir.php?paciente=".$paciente."&nomepaciente=".$nomePaciente."'>incluir</a></td>
               </tr>
               <tr><td colspan='9'>&nbsp;</td></tr>";

      if(!empty($paciente)){
        $sql = "SELECT a.valor, a.idservicos, a.nrGuia, a.qtdeSessoes, a.dataCadastro, 
                 a.descricao as servico, c.descricao as especialidade, c.idespecialidades
              FROM servicos a, especialidades c
             WHERE a.especialidades_idespecialidades = c.idespecialidades
               AND a.pacientes_idpaciente = :paciente
            GROUP BY a.idservicos";
//echo $sql;
//exit();
        $smt = $con->prepare($sql);
        $smt->bindParam(":paciente",$paciente);
        $retorno = $smt->execute(); //executar a query de select

        if ($retorno === true){
          $dados = $smt->fetchAll();
          $linhas = count($dados);
          if($dados === false){
            $this->erros['servicos'] = 'Nenhum servi&ccdeil;o encontrado';
          }
          $total = '';
          for ($i=0;$i<$linhas;$i++)
          {  
            $qtdeAtendimentos['servico'] = $dados[$i]['idservicos'];
            $qtdeAtendimentos['paciente'] = $paciente;
            $res = Agenda::qtdeAtendimentos($qtdeAtendimentos);
            
            $diaC = substr(trim($dados[$i]['dataCadastro']),8,2);
            $mesC = substr(trim($dados[$i]['dataCadastro']),5,2);
            $anoC = substr(trim($dados[$i]['dataCadastro']),0,4);

            $resultado .= '<tr><td align="center"> '.trim($dados[$i]['idservicos']).' </td> ';
            $resultado .= '<td align="center"> '.trim($dados[$i]['servico']).' </td>';
            $resultado .= '<td align="center"> '.trim($dados[$i]['nrGuia']).' </td>';
            $resultado .= '<td align="center"> '.trim($dados[$i]['qtdeSessoes']).' </td>';
            $resultado .= '<td align="center"> '.$res.' </td>';
            $resultado .= '<td align="center"> '.trim($dados[$i]['especialidade']).' </td>';
            $resultado .= '<td align="center"> '.trim($dados[$i]['valor']).' </td>';
            $resultado .= '<td> <a href="servico_alterar.php?idservico='.$dados[$i]['idservicos'].'&paciente='.$paciente.'&nomepaciente='.$nomePaciente.'&idespecialidade='.$dados[$i]['idespecialidades'].'&nrGuia='.$dados[$i]['nrGuia'].'&nome_especialidade='.$dados[$i]['especialidade'].'&descricao='.$dados[$i]['servico'].'&valor='.$dados[$i]['valor'].'&qtdeSessoes='.$dados[$i]['qtdeSessoes'].'">alterar</a></td>';
            $resultado .= '<td> <a href="servico_excluir.php?idservico='.$dados[$i]['idservicos'].'&paciente='.$paciente.'">excluir</a></td></tr>';
          }
        }
      }
//      print_r();
//      exit();
        $resultado .= '</table>';
      return $resultado;
      unset($con);//fecha conexão
    }
    public static function excluir($dado){
      $id = $dado['idservico'];
      //conexao
      $con = new PDO(DSN,USUARIO,SENHA);
      //validar os dados
      $sql = "DELETE FROM servicos WHERE idservicos = $id";
//echo $sql;
//exit();
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
    public static function total_sessoes_valor_servico($paciente,$servico){

      //conexao
      $con = new PDO(DSN,USUARIO,SENHA);
      //validar os dados
      $sql = "SELECT qtdeSessoes, valor
            FROM servicos 
           WHERE idservicos = $servico 
             AND pacientes_idpaciente = $paciente";
      $smt = $con->prepare($sql);
      $retorno = $smt->execute(); //executar a query de select

      //retorna false caso não seja possível executar o comando
      if ($retorno === true){
        $dados = $smt->fetch();
        if($dados === false){
          $this->erros['qtdeSessoes'] = 'Nenhum servico encontrado';
        }
        return $dados;  
      }
      unset($con);//fecha conexão
    }

    public static function consulta_mensal($dados){
      $mes = $dados['mes'];
      $ano = $dados['ano'];
      $funcionario = $dados['funcionario'];
      $funcResultado = Funcionario::funcionario_percentual($funcionario);
      $percentual = $funcResultado['percentual'];
      $nomeFuncionario = $funcResultado['nome'];
      
      //conexao
      $con = new PDO(DSN,USUARIO,SENHA);
      //validar os dados
      $sql = "SELECT idagenda, servicos_idservicos, pacientes_idpaciente, pacientes_planos_idplanos
            FROM agenda 
           WHERE funcionarios_matricula = $funcionario
             AND mes = '$mes'
             AND ano = '$ano'             
            AND situacao = 'Atendido' 
           ORDER BY pacientes_planos_idplanos";
/*echo $sql;
echo "<br>";
echo "nome Funcionario: ".$nomeFuncionario;
echo "<br>";
echo "mes: ".$mes;
echo "<br>";
echo "ano: ".$ano;
echo "<br>";
echo "percentual: ".$percentual;
echo "<br>";
*/
      $smt = $con->prepare($sql);
      $retorno = $smt->execute(); //executar a query de select

      //retorna false caso não seja possível executar o comando
      if ($retorno === true){
        $dados = $smt->fetchAll();
        $linhas = count($dados);
        if($dados === false){
          $this->erros['servico_id'] = 'Nenhum servico encontrado';
        }
        $soma = 0;
        $valorSessao = 0;
        $planoVerifica = 0;
        $qtdeAtendimentos = 0;
        $qtdeAtendimentosTotal = 0;
        $somaTotal = 0;
        $planoVerifica = $dados[0]['pacientes_planos_idplanos'];

        $resultado  = "<table border='1' align='center'>";
        $resultado .= "<tr><td colspan='3'>".$nomeFuncionario."(".$percentual."%) - ".$mes."/".$ano."</td></tr>
                 <tr><td colspan='3'>&nbsp;</td></tr>
                 <tr>
                <td align='center'>PLANO</td>
                <td align='center'>QTDE ATENDIMENTOS</td>
                <td align='center'>VALOR A RECEBER</td>
                 </tr>";
        for ($i=0;$i<$linhas;$i++)
        {
          $servico = $dados[$i]['servicos_idservicos'];
          $paciente = $dados[$i]['pacientes_idpaciente'];
          $totalSessoesValor = Servico::total_sessoes_valor_servico($paciente,$servico);
          $qtdeSessoes = $totalSessoesValor['qtdeSessoes'];
          $valor = $totalSessoesValor['valor'];
          $valorSessao = ($valor / $qtdeSessoes) * ($percentual / 100);
/*echo $nomePlano."<br>";
echo $qtdeSessoes."<br>";
echo $valor."<br>";
echo $valorSessao."<br>";
exit();          
*/          if($planoVerifica == $dados[$i]['pacientes_planos_idplanos']){
            $qtdeAtendimentos = $qtdeAtendimentos + 1;
            $soma += $valorSessao;
            $plano = $dados[$i]['pacientes_planos_idplanos'];
            $nomePlano = Plano::nome_plano($plano);
          }else{            
            $resultado .= '<tr><td align="center">&nbsp;'.$nomePlano.'&nbsp;</td> ';
            $resultado .= '<td align="center">&nbsp;'.$qtdeAtendimentos.'&nbsp;</td>';
            $resultado .= '<td align="center">&nbsp;'.number_format($soma,2,',','.').'&nbsp;</td>';
            $qtdeAtendimentos = 1;
            $soma = $valorSessao;
          }
          $planoVerifica = $dados[$i]['pacientes_planos_idplanos'];
          $qtdeAtendimentosTotal = $qtdeAtendimentosTotal + 1;
          $somaTotal += $valorSessao;
        }
        $nomePlano = Plano::nome_plano($planoVerifica);
        $resultado .= '<tr><td align="center">&nbsp;'.$nomePlano.'&nbsp;</td> ';
        $resultado .= '<td align="center">&nbsp;'.$qtdeAtendimentos.'&nbsp;</td>';
        $resultado .= '<td align="center">&nbsp;'.number_format($soma,2,',','.').'&nbsp;</td>';
        $resultado .= '<tr><td colspan="3">&nbsp;</td></tr>';
        $resultado .= '<tr><td align="center"> TOTAIS </td>';
        $resultado .= '<td align="center">'.$qtdeAtendimentosTotal.'</td>';
        $resultado .= '<td align="center"> R$ '.number_format($somaTotal,2,',','.').'</td></tr>';
        $resultado .= '</table>';
        return $resultado;  
      }
      unset($con);//fecha conexão
    }
    public function alterar(){
      $requeridos = array('valor'=>$this->valor,
                'qtdeSessoes'=>$this->qtdeSessoes,
                'paciente'=>$this->paciente,
                'especialidade'=>$this->especialidade,
                'idservicos'=>$this->id);

      $mensagem = validaEmpty($requeridos);  

      if (empty($mensagem)){
        //exit();
        $con = new PDO(DSN,USUARIO,SENHA);
        //validar os dados
        $sql = "UPDATE servicos 
               SET descricao     = :descricao, 
                 valor       = :valor,
                 nrGuia        = :nrGuia,
                 qtdeSessoes   = :qtdeSessoes,
                 especialidades_idespecialidades = :especialidade
             WHERE idservicos   = :idservicos
               AND pacientes_idpaciente = :paciente";

/*        $sql = "UPDATE servicos 
               SET descricao     = $this->descricao, 
                 valor       = $this->valor,
                 nrGuia        = $this->nrGuia,
                 qtdeSessoes   = $this->qtdeSessoes,
                 especialidades_idespecialidades = $this->especialidade
             WHERE idservicos   = $this->id
               AND pacientes_idpaciente = $this->paciente";
echo $sql;
exit();
*/        
        $smt = $con->prepare($sql);
        $smt->bindParam(':descricao',$this->descricao);
        $smt->bindParam(':valor',$this->valor);
        $smt->bindParam(':nrGuia',$this->nrGuia);
        $smt->bindParam(':qtdeSessoes',$this->qtdeSessoes);
        $smt->bindParam(':paciente',$this->paciente);
        $smt->bindParam(':idservicos',$this->id);
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

/*    public static function consulta_servicos(){
      //conexao
      $con = new PDO(DSN,USUARIO,SENHA);
      //validar os dados
      $sql = "SELECT b.nome as funcionario, b.matricula as func, b.percentual, c.descricao as plano, a.descricao, a.mes, a.ano
            FROM servicos a, funcionarios b, planos c
           WHERE a.funcionarios_matricula = b.matricula
             AND a.planos_idplanos = c.idplanos
           ORDER BY b.nome, a.mes desc, a.ano desc";
      $smt = $con->prepare($sql);
      $retorno = $smt->execute(); //executar a query de select

      //retorna false caso não seja possível executar o comando
      if ($retorno === true){
        $dados = $smt->fetchAll();
        $linhas = count($dados);
        if($dados === false){
          $this->erros['servico_id'] = 'Nenhum servico encontrado';
        }
        $soma = 0;
        $func = $dados[0]['func'];
        $mes_p = $dados[0]['mes'];
        $resultado  = "<table border='1' align='center'>";
        $resultado .= "<tr><td colspan='5'>".$dados[0]['funcionario']."(".$dados[0]['percentual']."%) - ".$dados[0]['mes']."/".$dados[0]['ano']."</td></tr>
                 <tr><td colspan='5'>&nbsp;</td></tr>
                 <tr>
                <td>Matricula</td>
                <td>Funcionario</td>
                <td>Valor</td>
                <td>Servi&ccedil;o</td>
                <td>Plano</td>
                 </tr>
                 <tr><td colspan='5'>&nbsp;</td></tr>";
        for ($i=0;$i<$linhas;$i++)
        {
          $func2 = $dados[$i]['func'];
          if(($func == $func2) and ($mes_p == $dados[$i]['mes'])){
            $resultado .= '<tr><td>&nbsp;'.trim($dados[$i]['func']).'&nbsp;</td> ';
            $resultado .= '<td align="right">&nbsp;'.trim($dados[$i]['funcionario']).'&nbsp;</td>';
            $resultado .= '<td align="right">&nbsp;'.number_format($dados[$i]['valor'],2,',','.').'&nbsp;</td>';
            $resultado .= '<td>&nbsp;'.trim($dados[$i]['descricao']).'&nbsp;</td>';
            $resultado .= '<td>&nbsp;'.trim($dados[$i]['plano']).'&nbsp;</td></tr>';
          }elseif($mes_p == $dados[$i]['mes']){
            $func = $func2;
            $resultado .= '</table>';
            $resultado .= "<br/><table border='1' align='center'>";
            $resultado .= "<tr><td colspan='5'>".$dados[$i]['funcionario']."(".$dados[$i]['percentual']."%) - ".$dados[$i]['mes']."/".$dados[$i]['ano']."</td></tr>
                     <tr><td colspan='5'>&nbsp;</td></tr>
                     <tr>
                    <td>Matricula</td>
                    <td>Funcionario</td>
                    <td>Valor</td>
                    <td>Servi&ccedil;o</td>
                    <td>Plano</td>
                     </tr>
                     <tr><td colspan='5'>&nbsp;</td></tr>";
            $resultado .= '<tr><td>&nbsp;'.trim($dados[$i]['func']).'&nbsp;</td> ';
            $resultado .= '<td align="right">&nbsp;'.trim($dados[$i]['funcionario']).'&nbsp;</td>';
            $resultado .= '<td align="right">&nbsp;'.number_format($dados[$i]['valor'],2,',','.').'&nbsp;</td>';
            $resultado .= '<td>&nbsp;'.trim($dados[$i]['descricao']).'&nbsp;</td>';
            $resultado .= '<td>&nbsp;'.trim($dados[$i]['plano']).'&nbsp;</td></tr>';
          }
        }
        $resultado .= '</table>';
        return $resultado;  
      }
      unset($con);//fecha conexão
    }
*/
  }
?>