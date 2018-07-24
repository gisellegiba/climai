// Função que recupera os dados da pesquisafunction catchDados(valor) {
function Dados2(valor) {

   //verifica se o browser tem suporte a ajax
	  try {
        //ajax = new ActiveXObject("Microsoft.XMLHTTP");
		ajax = new XMLHttpRequest();
      } 
      catch(e) {
         try {
            ajax = new ActiveXObject("Msxml2.XMLHTTP");
         }
	     catch(ex) {
            try {
               //ajax = new XMLHttpRequest();
			   ajax = new ActiveXObject("Microsoft.XMLHTTP");
            }
	        catch(exc) {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax = null;
            }
         }
      }	

	  // Recupera o combo-box ESTADOS
	  //estados = document.getElementById("estados");
	
	  // Recupera o combo-box CIDADES
	  Idcidades2 = document.getElementById("despesa");
     
	  if (ajax) {
		  
		// Limpa o combo-box CIDADES
		Idcidades2.options.length = 1;
		idOpcoes2 = document.getElementById("opcoes2");
		
		// Faz a requisição
		ajax.open("POST", "ajax_confirma.php", true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
		// Vamos processar os estados da requisição
		ajax.onreadystatechange = function() {
		  // Carregando...
		  if (ajax.readyState == 1) {
			idOpcoes2.innerHTML = "Carregando DESPESAS...";   
		  }
		  // Ao receber a resposta
		  if (ajax.readyState == 4 ) {
			if (ajax.responseXML) {
			    montaCombo(ajax.responseXML);
			} else {
			  idOpcoes2.innerHTML = "Primeiro selecione o tipo de despesa";
			}
		  }
		}
		// Envia os parâmetros
		var params = "tipo="+valor;
		ajax.send(params);
	}

function montaCombo(obj){
	
  // Array com os dados das cidades
  var dataArray = obj.getElementsByTagName("cidade2");

  // Recupera o combo-box CIDADES
  despesa = document.getElementById("despesa");

  // Verifica se a consulta retornou alguma coisa
//alert(dataArray.length);	
  if (dataArray.length > 0) {
    // Lemos todo o arquivo XML
	
    for(var i = 0 ; i < dataArray.length ; i++) {
      var item = dataArray[i];
	 
      var codigo2 = item.getElementsByTagName("codigo2")[0].firstChild.nodeValue;
      var descricao2 = item.getElementsByTagName("descricao2")[0].firstChild.nodeValue;
	
      idOpcoes2.innerHTML = "Selecione";
      // Aqui e DOM, assunto para um outro artigo
      // Cria os dados dentro do combo
      var opt = document.createElement("option");
	  opt.setAttribute("id", "opcoes2");
      opt.value = codigo2;
      opt.text  = descricao2;
      //cidades.options.add(opt);
	 // alert(opt);
	  //document.forms[0].getElementById("ListOCS").options.add(opt);
	   despesa.options.add(opt);
    }
  } else {
    // caso o XML retorne em branco
    idOpcoes2.innerHTML = "Nenhuma Despesa encontradda para esse tipo";
  }
}
}