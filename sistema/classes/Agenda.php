<?php
  /*
  Autor: Giselle Machado
  Data: 19/02/2012
  Descrição: Classe Agenda
  Versão: 1.0
  */
  //inclui o arquivo de função validação de vazio
  require_once("funcoes/valida_empty.php");
  //require_once("funcoes/valida_cpf.php");
  require_once("conexao/conexao.php");  
  //declaração da classe USUARIO
  include('funcoes/diasemana.php');

  class Agenda{
    private $id;//PK do Banco de dados
    private $dia;
    private $mes;
    private $ano;
    private $hora;
    private $situacao;
    private $observacao;
    private $funcionario_m;
    private $funcionario_e;
    private $nr_sessao;
    private $paciente;
    private $plano;
    private $servico;    
    private $cod_hora;
    private $usuario;
  
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
      $this->id           = (empty($params['id']))? 0 :$params['id'];
      $this->dia        = (empty($params['dia']))? "" :$params['dia'];
      $this->mes        = (empty($params['mes']))? "" :$params['mes'];
      $this->ano        = (empty($params['ano']))? "" :$params['ano'];
      $this->hora      = (empty($params['hora']))? "" :$params['hora'];
      $this->cod_hora     = (empty($params['cod_hora']))? "" :$params['cod_hora'];
      $this->situacao    = (empty($params['situacao']))? "" :$params['situacao'];
      $this->observacao   = (empty($params['observacao']))? "" :$params['observacao'];
      $this->servico     = (empty($params['servico']))? 0 :$params['servico'];
      $this->paciente    = (empty($params['paciente']))? 0 :$params['paciente'];
      $this->plano      = (empty($params['plano']))? 0 :$params['plano'];
      $this->nr_sessao   = (empty($params['nr_sessao']))? 0 :$params['nr_sessao'];
      $this->funcionario_m = (empty($params['funcionario_m']))? 0 :$params['funcionario_m'];
      $this->funcionario_e = (empty($params['funcionario_e']))? 0 :$params['funcionario_e'];
      $this->usuario      = $_SESSION['usuario_matricula'];
    }
    public function verifica_cadastro(){
      $requeridos = array('dia'=>$this->dia,
                'mes'=>$this->mes,
                'ano'=>$this->ano,
                'cod_hora'=>$this->cod_hora);

      $mensagem = validaEmpty($requeridos);  

      if (empty($mensagem)){
        $con = new PDO(DSN,USUARIO,SENHA);
        //validar os dados
        $sql = "SELECT idagenda FROM agenda 
             WHERE dia  = :dia
               AND mes  = :mes
               AND ano  = :ano
               AND hora = :cod_hora
               AND funcionarios_matricula = :funcionario";
        $smt = $con->prepare($sql);
        $smt->bindParam(':dia',$this->dia);
        $smt->bindParam(':mes',$this->mes);
        $smt->bindParam(':ano',$this->ano);
        $smt->bindParam(':cod_hora',$this->cod_hora);
        $smt->bindParam(':funcionario',$this->funcionario_m);
        $retorno = $smt->execute(); //executar a query de insert

        //retorna false caso não seja possível executar o comando
        if ($retorno === true){
          $dados = $smt->fetchAll();
          $linhas = count($dados);
          if($dados === false){
            $this->erros['agenda'] = 'Nenhum agendamento encontrado';
            return false;
          }
          if(isset($dados[0]['idagenda'])){
            return true;
          }else{
            return false;
          }
        }
        unset($con);//fecha conexão
      }else{//deu erro
        $this->erros = $mensagem;
        return false;
      }
    }  
    public static function verifica_sessao($dados){
      $servico = $dados['servico'];
      $paciente = $dados['paciente'];
      //conexao
      $con = new PDO(DSN,USUARIO,SENHA);
      //validar os dados
      $sql = "SELECT count(idagenda) as qtdeSessoes 
            FROM agenda 
          WHERE servicos_idservicos = ".$servico."
            AND pacientes_idpaciente = ".$paciente;
      $smt = $con->prepare($sql);
      $retorno = $smt->execute(); //executar a query de select

      //retorna false caso não seja possível executar o comando
      if ($retorno === true){
        $dados = $smt->fetch();
        if($dados === false){
          $this->erros['qtdeSessoes'] = 'Nenhum servico encontrado';
        }

        return $dados['qtdeSessoes'];  
      }
      unset($con);//fecha conexão
    }
    public static function qtdeAtendimentos($dados){
      $servico = $dados['servico'];
      $paciente = $dados['paciente'];
      //conexao
      $con = new PDO(DSN,USUARIO,SENHA);
      //validar os dados
      $sql = "SELECT MAX(nr_sessao) as total
              FROM agenda
           WHERE servicos_idservicos = ".$servico."
            AND pacientes_idpaciente = ".$paciente."
            AND situacao <> 'Paciente Desmarcou'
            AND situacao <> 'Profissional Desmarcou' ";
//echo $sql;
//exit();
      $smt = $con->prepare($sql);
      $retorno = $smt->execute(); //executar a query de select

      //retorna false caso não seja possível executar o comando
      if ($retorno === true){
        $dados = $smt->fetch();
        if($dados === false){
          $this->erros['qtdeAtendimentos'] = 'Nenhum servico encontrado';
        }

//print_r($dados['total']);
//exit();
        return $dados['total'];  
      }
      unset($con);//fecha conexão
    }
    public function cadastrar(){
      $requeridos = array('dia'=>$this->dia,
                'mes'=>$this->mes,
                'ano'=>$this->ano,
                'cod_hora'=>$this->cod_hora,
                'situacao'=>$this->situacao,
                'paciente'=>$this->paciente,
                'funcionario'=>$this->funcionario_m,
                'especialidade'=>$this->funcionario_e,
                'servico'=>$this->servico,
                'usuario'=>$this->usuario);

      $mensagem = validaEmpty($requeridos);  
      $dados = "";
      $nr_sessao = "";
      $dados['paciente'] = $this->paciente;
      $dados['servico'] = $this->servico;
      echo $this->servico."<br>";
      $nr_sessao = Agenda::qtdeAtendimentos($dados);
      $nr_sessao = $nr_sessao + 1;
      if (empty($mensagem)){
        $con = new PDO(DSN,USUARIO,SENHA);
        $plano = Paciente::seleciona_plano_paciente($this->paciente);
        //validar os dados
        $sql = "INSERT INTO agenda (dia,mes,ano,hora,situacao,observacao,servicos_idservicos,pacientes_idpaciente,pacientes_planos_idplanos,funcionarios_matricula,funcionarios_especialidades_idespecialidades, nr_sessao, usuario)
              VALUES (:dia,:mes,:ano,:hora,:situacao,:observacao,:servico,:paciente,:plano,:funcionario,:especialidade, :nr_sessao, :usuario)";
//$sql =   "INSERT INTO agenda (dia,mes,ano,hora,situacao,observacao,servicos_idservicos,pacientes_idpaciente,pacientes_planos_idplanos,funcionarios_matricula,funcionarios_especialidades_idespecialidades, nr_sessao, usuario)
//              VALUES (".$this->dia.",".$this->mes.",".$this->ano.",".$this->hora.",".$this->situacao.",".$this->observacao.",".$this->servico.",".$this->paciente.",".$this->plano.",".$this->funcionario_m.",".$this->funcionario_e.",".$nr_sessao.",".$this->usuario.")";
//echo $sql;
//exit();
          $smt = $con->prepare($sql);
          $smt->bindParam(':dia',$this->dia);
          $smt->bindParam(':mes',$this->mes);
          $smt->bindParam(':ano',$this->ano);
          $smt->bindParam(':hora',$this->cod_hora);
          $smt->bindParam(':situacao',$this->situacao);
          $smt->bindParam(':observacao',$this->observacao);
          $smt->bindParam(':servico',$this->servico);
          $smt->bindParam(':paciente',$this->paciente);
          $smt->bindParam(':plano',$plano);
          $smt->bindParam(':funcionario',$this->funcionario_m);
          $smt->bindParam(':especialidade',$this->funcionario_e);
          $smt->bindParam(':nr_sessao',$nr_sessao);
          $smt->bindParam(':usuario',$this->usuario);
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
//      }
    }  
    public static function alterar_situacao($d){
      $idA = $d['idagenda'];
      $sit = $d['situacao'];

      if(!empty($idA)){
        $con = new PDO(DSN,USUARIO,SENHA);
        //validar os dados
        $sql = "UPDATE agenda SET situacao = :situacao, usuario = :usuario
             WHERE idagenda = :id";
//echo $sql;
//exit();
        $smt = $con->prepare($sql);
        $smt->bindParam(':id',$idA);
        $smt->bindParam(':situacao',$sit);
        $smt->bindParam(':usuario',$_SESSION['usuario_matricula']);
        $retorno = $smt->execute(); //executar a query de insert

        unset($con);//fecha conexão
        return $retorno;
      }
    }  
    public function alterar_observacao($d){
      $idagenda = $d['idagenda'];
      $observacao = $d['observacao'];

      if(!empty($idagenda)){
        $con = new PDO(DSN,USUARIO,SENHA);
        //validar os dados
        $sql = "UPDATE agenda SET observacao = :observacao, usuario = :usuario
             WHERE idagenda = :idagenda";
//        $sql = "UPDATE agenda SET observacao = '".$observacao."', usuario = ".$_SESSION['usuario_matricula']."
//             WHERE idagenda = ".$idagenda."";
//echo $sql;
//exit();
        $smt = $con->prepare($sql);
        $smt->bindParam(':idagenda',$idagenda);
        $smt->bindParam(':observacao',$observacao);
        $smt->bindParam(':usuario',$_SESSION['usuario_matricula']);
        $retorno = $smt->execute(); //executar a query de insert

        unset($con);//fecha conexão
        return $retorno;
      }
    }
    public static function verificaDisponibilidade($dia,$mes,$ano,$hora,$func){
      //conexao
      $con = new PDO(DSN,USUARIO,SENHA);
      //validar os dados
      $sql = "select 1 as verifica from agenda where dia = $dia and mes = $mes and hora = '$hora' and funcionarios_matricula = $func";
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
          $horario[] = $dados[$i]['verifica'];
        }
        return $horario;  
      }
      unset($con);//fecha conexão
    }

     public static function verificaDisponibilidaDesmarcado($dia,$mes,$ano,$hora,$func){
      //conexao
      $con = new PDO(DSN,USUARIO,SENHA);
      //validar os dados
      $sql = "select count(hora) as verifica from agenda where dia = $dia and mes = $mes and hora = '$hora' and funcionarios_matricula = $func";
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
          $horario = $dados[$i]['verifica'];
        }
        return $horario;  
      }
      unset($con);//fecha conexão
    }
    
    public static function seleciona_total_sessoes_servico($id){
      //conexao
      $con = new PDO(DSN,USUARIO,SENHA);
      //validar os dados
      $sql = "SELECT qtdeSessoes, nrGuia FROM servicos WHERE idservicos = ".$id;
//echo $sql;
//exit();
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

    public static function consultar($dados){
      $func = $dados['funcionario_m'];
      $ano   = $dados['ano'];
      $mes  = $dados['mes'];

      if((!empty($ano)) and (!empty($mes)) and (!empty($func))){
        //nehum dado está em branco
        if ($mes   < 10 and substr($mes,0,1) <> 0) $mes   = '0'.$mes;
        $resultado = "";
        $total = "";

        $dadosFunc = Funcionario::consultaEspecialidade($func);
        $resultado  = "<table border='1' align='center'>";
        $resultado .= "<tr bgcolor='#EE82EE'>
                <td colspan='18'><b>".$mes."/".$ano." - ".trim($dadosFunc['nome'])." - ".trim($dadosFunc['especialidade'])."</b></td>
                 </tr>
                 <tr><td colspan='18'>&nbsp;</td></tr>";
        //for para contar os dias
        for($dia_a=1;$dia_a<=31;$dia_a++){
          $data_certa = checkdate($mes,$dia_a,$ano);
          $dataAtual = date('Ymd');
          if ($dia_a < 10) $dia_a = '0'.$dia_a;
          $dataMarcar = $ano.$mes.$dia_a;
          if($data_certa and ($dataMarcar >= $dataAtual)){
            $diaSemanaData = diasemana($mes,$dia_a,$ano);
            $diaSemanaFunc = Horario::consulta_diasemana($func,$diaSemanaData);
            if(isset($diaSemanaFunc) and $diaSemanaFunc === true){ 
              $horarioFunc = Horario::consulta_horario($func,$diaSemanaData);
              $idhorarioChave = 0;

              $diasemanaDiaSemana = date("w", mktime(0,0,0,$mes,$dia_a,$ano) );
              
              switch($diasemanaDiaSemana) {
                case"0": $diasemanaDiaSemana = "Domingo";       break;
                case"1": $diasemanaDiaSemana = "Segunda-Feira"; break;
                case"2": $diasemanaDiaSemana = "Terça-Feira";   break;
                case"3": $diasemanaDiaSemana = "Quarta-Feira";  break;
                case"4": $diasemanaDiaSemana = "Quinta-Feira";  break;
                case"5": $diasemanaDiaSemana = "Sexta-Feira";   break;
                case"6": $diasemanaDiaSemana = "Sábado";        break;
              }

              $resultado .= '<tr><td colspan="18"><b>DIA - '.$dia_a.' - '.$diasemanaDiaSemana.'</b></td></tr> ';
              
              //perfil do usuário == Profissional
              if($_SESSION['usuario_perfil'] == "Profissional"){
              	$resultado .= '<tr>
                      <td><b>Horario</b></td>
                      <td><b>CPF</b></td>
                      <td><b>Nome</b></td>
                      <td><b>Tel Residencial</b></td>
                      <td><b>Tel Celular</b></td>
                      <td><b>Tel Trabalho</b></td>
                      <td><b>Situacao</b></td>
                      <td><b>Plano</b></td>
                      <td><b>Nr Sess&atilde;o</b></td>
                      <td><b>Nr Guia</b></td>
                      <td><b>Especialidade</b></td>
                      <td colspan="6" align="center"><b>Observa&ccedil;&atilde;o</b></td>
                      <td align="center"><b>Desmarcar</b></td>
                       </tr>';
              
              }else{//perfil do usuário <> Profissional
              	$resultado .= '<tr>
                      <td><b>Horario</b></td>
                      <td><b>CPF</b></td>
                      <td><b>Nome</b></td>
                      <td><b>Tel Residencial</b></td>
                      <td><b>Tel Celular</b></td>
                      <td><b>Tel Trabalho</b></td>
                      <td><b>Situacao</b></td>
                      <td><b>Plano</b></td>
                      <td><b>Nr Sess&atilde;o</b></td>
                      <td><b>Nr Guia</b></td>
                      <td><b>Especialidade</b></td>
                      <td><b>Observa&ccedil;&atilde;o</b></td>
                      <td><b>Atendido</b></td>
                      <td><b>Confirmado</b></td>
                      <td><b>Faltou</b></td>
                      <td colspan="2" align="center"><b>Desmarcar</b></td>
                      <td><b>Incluir / Excluir / Encaixar </b></td>
                       </tr>';
              
              }
                          
              foreach($horarioFunc['descricao'] as $hFuncChave => $hFuncValor){
                $idhorario = $horarioFunc['idhorario'][$idhorarioChave];
                $descricaoHorario = $horarioFunc['descricao'][$idhorarioChave];
                $statusHorario = $horarioFunc['status'][$idhorarioChave];
                //verificar se o horário está disponível para marcação na agenda
                $horarioOcupado = Agenda::verificaDisponibilidade($dia_a,$mes,$ano,$idhorario,$func);
                $con = new PDO(DSN,USUARIO,SENHA);
                if($horarioOcupado){
                  //conexao
                  $sql = "SELECT a.idagenda as idagenda, a.dia,a.hora,
                           a.situacao as situacao,
                           a.nr_sessao as sessao,
                           a.observacao as observacao,
                           a.servicos_idservicos as servico,
                           b.descricao as plano,
                           c.nome as paciente, 
                           c.idpaciente as idpaciente,
                           c.cpf as cpf,
                           c.telefone_residencial as residencial, 
                           c.telefone_celular as celular, 
                           c.telefone_trabalho as trabalho,
                           e.descricao as especialidade,
                           e.idespecialidades as esp,
                           f.descricao as horario,
                           f.diasemana as diasemana,
                           f.idhorario as idh
                        FROM agenda a, planos b, pacientes c, funcionarios d, especialidades e, horario f
                        WHERE a.pacientes_idpaciente = c.idpaciente
                        AND a.pacientes_planos_idplanos = b.idplanos
                        AND a.funcionarios_matricula = d.matricula
                        AND a.funcionarios_especialidades_idespecialidades = e.idespecialidades
                        AND a.funcionarios_matricula = f.funcionarios_matricula
                        AND a.hora = f.idhorario
                        AND a.funcionarios_matricula = :funcionario
                        AND a.ano = :ano
                        AND a.mes = :mes
                        AND a.hora = :hora
                        ORDER BY a.dia, f.descricao";

//echo $sql;
//exit();
                  $smt = $con->prepare($sql);
                  $smt->bindParam(':mes',$mes);
                  $smt->bindParam(':ano',$ano);
                  $smt->bindParam(':funcionario',$func);
                  $smt->bindParam(':hora',$idhorario);
                  $retorno = $smt->execute(); //executar a query de select
                  if ($retorno === true){
                    $dados = $smt->fetchAll();
                    $linhas = count($dados);
                    if(!empty($dados[0]['idagenda'])){
                      for($i=0;$i<$linhas;$i++){
                        //horário ocupado
                        if($dia_a == $dados[$i]['dia']){
                          $idservico = $dados[$i]['servico'];

                          $qtdeSessoes_nrGuia = Agenda::seleciona_total_sessoes_servico($idservico);  
                          $qtdeSessoes = $qtdeSessoes_nrGuia['qtdeSessoes'];  
                          $nrGuia = $qtdeSessoes_nrGuia['nrGuia'];  
                          $esp = $dados[$i]['especialidade'];
//$qtdeSessoes = 10;                       
                          
                          $resultado .= '<tr><td align="center">'.trim($hFuncValor).'</td> ';
                          $resultado .= '<td align="center">'.trim($dados[$i]['cpf']).' </td>';
                          $resultado .= '<td align="center">'.trim($dados[$i]['paciente']).' </td>';
                          $resultado .= '<td align="center">'.trim($dados[$i]['residencial']).' </td>';
                          $resultado .= '<td align="center">'.trim($dados[$i]['celular']).' </td>';
                          $resultado .= '<td align="center">'.trim($dados[$i]['trabalho']).' </td>';
                          $resultado .= '<td align="center">'.trim($dados[$i]['situacao']).' </td>';
                          $resultado .= '<td align="center">'.trim($dados[$i]['plano']).' </td>';
                          $resultado .= '<td align="center">'.trim($dados[$i]['sessao']).' de '.$qtdeSessoes.'</td>';
                          $resultado .= '<td align="center">'.$nrGuia.' </td>';
                          $resultado .= '<td align="center">'.$esp.' </td>';


                          //perfil do usuário == Profissional
                          if($_SESSION['usuario_perfil'] == "Profissional"){
                          	$resultado .= '<td colspan="6" align="center"></td>';
                          	$resultado .= '<td><a href="agenda_marcar.php?idagenda='.$dados[$i]['idagenda'].'&situacao=Profissional Desmarcou&mes='.$mes.'&ano='.$ano.'&funcionario='.$func.'">Desmarcar</a></td>';
                          	
                         }else{//perfil do usuário <> profissional
                          	$resultado .= '<td>'.trim($dados[$i]['observacao']).' <a href="agenda_alterar.php?idagenda='.$dados[$i]['idagenda'].'&mes='.$mes.'&ano='.$ano.'&funcionario='.$func.'">Alterar</a></td>';
                            $resultado .= '<td><a href="agenda_marcar.php?idagenda='.$dados[$i]['idagenda'].'&situacao=Atendido&mes='.$mes.'&ano='.$ano.'&funcionario='.$func.'">Atendido</a></td>';
                          	$resultado .= '<td><a href="agenda_marcar.php?idagenda='.$dados[$i]['idagenda'].'&situacao=Confirmado&mes='.$mes.'&ano='.$ano.'&funcionario='.$func.'">Confirmado</a></td>';
                          	$resultado .= '<td><a href="agenda_marcar.php?idagenda='.$dados[$i]['idagenda'].'&situacao=Faltou&mes='.$mes.'&ano='.$ano.'&funcionario='.$func.'">Faltou</a></td>';
                          	$resultado .= '<td><a href="agenda_marcar.php?idagenda='.$dados[$i]['idagenda'].'&situacao=Paciente Desmarcou&mes='.$mes.'&ano='.$ano.'&funcionario='.$func.'">Paciente</a></td>';
                         	$resultado .= '<td><a href="agenda_marcar.php?idagenda='.$dados[$i]['idagenda'].'&situacao=Profissional Desmarcou&mes='.$mes.'&ano='.$ano.'&funcionario='.$func.'">Profissional</a></td>';
                          	$resultado .= '<td>
                                             <a href="agenda_excluir.php?idagenda='.$dados[$i]['idagenda'].'&mes='.$mes.'&ano='.$ano.'&funcionario='.$func.'">excluir</a>
                                             </br> <a href="agenda_incluir.php?nome_funcionario='.$dadosFunc['nome'].'&observacao=Encaixe&nome_especialidade='.$dadosFunc['especialidade'].'&cod_hora='.$idhorario.'&hora='.$descricaoHorario.'&dia='.$dia_a.'&mes='.$mes.'&ano='.$ano.'&funcionario='.$func.'&especialidade='.$dadosFunc['idespecialidade'].'">Encaixar</a> 
                                         </td>';                         	
                         }
                          $resultado .= '</tr>';
                          
                          //situação == desmarcado
                          $situacao = $dados[$i]['situacao'];
                          $verificaOcupadoMaisDeUm = Agenda::verificaDisponibilidaDesmarcado($dia_a,$mes,$ano,$idhorario,$func);
//$resultado .="Estou Aqui: ".$verificaOcupadoMaisDeUm;
                          if((($situacao == "Paciente Desmarcou") or ($situacao == "Profissional Desmarcou")) and
                             ($verificaOcupadoMaisDeUm <= 1)){
                            //horário disponível
                            
                            $resultado .= '<tr><td align="center">'.trim($hFuncValor).'</td> ';
                            $resultado .= '<td colspan="16" align="center"></td>';
                            
                            //perfil do usuário <> Profissional
                            if($_SESSION['usuario_perfil'] <> "Profissional"){
                               $resultado .= '<td><a href="agenda_incluir.php?nome_funcionario='.$dadosFunc['nome'].'&nome_especialidade='.$dadosFunc['especialidade'].'&cod_hora='.$idhorario.'&hora='.$descricaoHorario.'&dia='.$dia_a.'&mes='.$mes.'&ano='.$ano.'&funcionario='.$func.'&especialidade='.$dadosFunc['idespecialidade'].'">Incluir</a></td>';
                            }
                            $resultado .= '</tr>';
                          }
                          
                        }
                      }//end for($i=0;$i<$linhas;$i++)
                    }//end if(!empty($dados[0]['funcionario']))
                  }//end if($retorno === true)
                }else{
                  
                  if($statusHorario == "Ativo"){
                  
                  //horário disponível
                  $resultado .= '<tr><td align="center">'.trim($hFuncValor).'</td> ';
                  $resultado .= '<td colspan="16" align="center"></td>';
                  
                  //perfil do usuário <> Profissional
                  if($_SESSION['usuario_perfil'] <> "Profissional"){
                     $resultado .= '<td><a href="agenda_incluir.php?nome_funcionario='.$dadosFunc['nome'].'&nome_especialidade='.$dadosFunc['especialidade'].'&cod_hora='.$idhorario.'&hora='.$descricaoHorario.'&dia='.$dia_a.'&mes='.$mes.'&ano='.$ano.'&funcionario='.$func.'&especialidade='.$dadosFunc['idespecialidade'].'">Incluir</a></td>';
                  }else{
                     $resultado .= '<td></td>';
                  }
                  
                  $resultado .= '</tr>';
                  }//if($statusHorario == "Ativo")
                }//end if($horarioOcupado)
                unset($con);//fecha conexão
                $idhorarioChave ++;
              }//end foreach($horarioFunc as $hFuncChave => $hFuncValor)
              $resultado .= "<tr><td colspan='18'>&nbsp;</td></tr>";
            }//end if isset($diaSemanaFunc))
          }else{//end if($data_certa and ($dataMarcar >= $dataAtual))
            if($data_certa and ($dataMarcar < $dataAtual)){
              $diaSemanaData = diasemana($mes,$dia_a,$ano);
              $diaSemanaFunc = Horario::consulta_diasemana($func,$diaSemanaData);
              if(isset($diaSemanaFunc) and $diaSemanaFunc === true){ 
                $horarioFunc = Horario::consulta_horario($func,$diaSemanaData);
                $idhorarioChave = 0;
                
                $diasemanaDiaSemana = date("w", mktime(0,0,0,$mes,$dia_a,$ano) );
              
                switch($diasemanaDiaSemana) {
                  case"0": $diasemanaDiaSemana = "Domingo";       break;
                  case"1": $diasemanaDiaSemana = "Segunda-Feira"; break;
                  case"2": $diasemanaDiaSemana = "Terça-Feira";   break;
                  case"3": $diasemanaDiaSemana = "Quarta-Feira";  break;
                  case"4": $diasemanaDiaSemana = "Quinta-Feira";  break;
                  case"5": $diasemanaDiaSemana = "Sexta-Feira";   break;
                  case"6": $diasemanaDiaSemana = "Sábado";        break;
               }

                $resultado .= '<tr><td colspan="18"><b>DIA - '.$dia_a.' - '.$diasemanaDiaSemana.'</b></td></tr> ';
                $resultado .= '<tr>
                        <td><b>Horario</b></td>
                        <td><b>CPF</b></td>
                        <td><b>Nome</b></td>
                        <td><b>Tel Residencial</b></td>
                        <td><b>Tel Celular</b></td>
                        <td><b>Tel Trabalho</b></td>
                        <td><b>Situacao</b></td>
                        <td><b>Plano</b></td>
                        <td><b>Nr Sess&atilde;o</b></td>
                        <td><b>Nr Guia</b></td>
                        <td><b>Especialidade</b</td>
                        <td colspan="7"><b>Observa&ccedil;&atilde;o</b></td>
                        </tr>';
                foreach($horarioFunc['descricao'] as $hFuncChave => $hFuncValor){
                  $idhorario = $horarioFunc['idhorario'][$idhorarioChave];
                  $descricaoHorario = $horarioFunc['descricao'][$idhorarioChave];
                  //verificar se o horário está disponível para marcação na agenda
                  $horarioOcupado = Agenda::verificaDisponibilidade($dia_a,$mes,$ano,$idhorario,$func);
                  $con = new PDO(DSN,USUARIO,SENHA);
                  if($horarioOcupado){
                    //conexao
                    $sql = "SELECT a.idagenda as idagenda, a.dia as dia,a.hora,
                             a.situacao as situacao,
                             a.nr_sessao as sessao,
                             a.observacao as observacao,
                             a.servicos_idservicos as servico,
                             b.descricao as plano,
                             c.nome as paciente, 
                             c.idpaciente as idpaciente,
                             c.cpf as cpf,
                             c.telefone_residencial as residencial, 
                             c.telefone_celular as celular, 
                             c.telefone_trabalho as trabalho,
                             e.descricao as especialidade,
                             e.idespecialidades as esp,
                             f.descricao as horario,
                             f.diasemana as diasemana,
                             f.idhorario as idh,
                             f.status as status
                          FROM agenda a, planos b, pacientes c, funcionarios d, especialidades e, horario f
                          WHERE a.pacientes_idpaciente = c.idpaciente
                          AND a.pacientes_planos_idplanos = b.idplanos
                          AND a.funcionarios_matricula = d.matricula
                          AND a.funcionarios_especialidades_idespecialidades = e.idespecialidades
                          AND a.funcionarios_matricula = f.funcionarios_matricula
                          AND a.hora = f.idhorario  
                          AND a.funcionarios_matricula = $func
                          AND a.ano = $ano
                          AND a.mes = $mes
                          AND a.hora = $idhorario
                          ORDER BY a.dia, f.descricao";
          //echo $sql;
          //exit();
                    $smt = $con->prepare($sql);
                    $smt->bindParam(':mes',$mes);
                    $smt->bindParam(':ano',$ano);
                    $smt->bindParam(':func',$func);
                    $smt->bindParam(':idhorario',$idhorario);
                    $retorno = $smt->execute(); //executar a query de select
                    if ($retorno === true){
                      $dados = $smt->fetchAll();
                      $linhas = count($dados);
                      if(!empty($dados[0]['idagenda'])){
                        for($i=0;$i<$linhas;$i++){
                          //horário ocupado
                          if($dia_a == $dados[$i]['dia']){
                            $idservico = $dados[$i]['servico'];
                            $qtdeSessoes_nrGuia = Agenda::seleciona_total_sessoes_servico($idservico);  
                            $qtdeSessoes = $qtdeSessoes_nrGuia['qtdeSessoes'];  
                            $nrGuia = $qtdeSessoes_nrGuia['nrGuia']; 
                            $esp = $dados[$i]['especialidade'];
                            $resultado .= '<tr><td align="center">'.trim($hFuncValor).'</td> ';
                            $resultado .= '<td align="center">'.trim($dados[$i]['cpf']).' </td>';
                            $resultado .= '<td align="center">'.trim($dados[$i]['paciente']).' </td>';
                            $resultado .= '<td align="center">'.trim($dados[$i]['residencial']).' </td>';
                            $resultado .= '<td align="center">'.trim($dados[$i]['celular']).' </td>';
                            $resultado .= '<td align="center">'.trim($dados[$i]['trabalho']).' </td>';
                            $resultado .= '<td align="center">'.trim($dados[$i]['situacao']).' </td>';
                            $resultado .= '<td align="center">'.trim($dados[$i]['plano']).' </td>';
                            $resultado .= '<td align="center">'.trim($dados[$i]['sessao']).' de '.$qtdeSessoes.'</td>';
                            $resultado .= '<td align="center">'.$nrGuia.'</td>';
                            $resultado .= '<td align="center">'.$esp.'</td>';
                            $resultado .= '<td colspan="7">'.trim($dados[$i]['observacao']).' </td>';
                            $resultado .= '</tr>';
                          }
                        }//end for($i=0;$i<$linhas;$i++)
                      }//end if(!empty($dados[0]['funcionario']))
                    }//end if($retorno === true)
                  }//end if($horarioOcupado)
                  unset($con);//fecha conexão
                  $idhorarioChave ++;
                }//end foreach($horarioFunc as $hFuncChave => $hFuncValor)
                $resultado .= "<tr><td colspan='18'>&nbsp;</td></tr>";
              }//end if isset($diaSemanaFunc))
            }
          }//end if($data_centa and ($dataMarcar >= $dataAtual))
        }//end for($dia_a=1;$dia_a<=31;$dia_a++)
        $resultado .= '</table>';
//echo $resultado;
//exit();
        return $resultado;  
      }//end if((!empty($ano)) and (!empty($mes)) and (!empty($func)))       
    }//end método consultar
    
    public static function excluir($dado){
      $id = $dado['idagenda'];
      //conexao
      $con = new PDO(DSN,USUARIO,SENHA);
      //validar os dados
      $sql = "DELETE FROM agenda WHERE idagenda = :id";

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