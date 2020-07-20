<?php
/*
Classe conexão e consultas em MySQL
Autor: Jonatas Vieira
		jonnyleg@gmail.com
Criada em 16/08/2006
Última atualização: 18/12/2006
*/
/*******************************************************************************
 Copyright 2006, 2007 Jonatas Vieira Coutinho
 
 Este arquivo é parte da biblioteca J PHP


    J PHP é um software livre; você pode redistribui-lo e/ou 

    modifica-lo dentro dos termos da Licença Pública Geral Menor GNU (LGPL) como 

    publicada pela Fundação do Software Livre (FSF).


    Este programa é distribuido na esperança que possa ser  util, 

    mas SEM NENHUMA GARANTIA; sem uma garantia implicita de ADEQUAÇÂO a qualquer

    MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a

    Licença Pública Geral Menor GNU (LGPL) para maiores detalhes.
    
*******************************************************************************/
	class sqlMy extends aplicativo {
		protected
			$bd,
			$conex,
			$_exequery,
			$_row,
			$_rownum,
			$_totalfields,
			$_campos,
			$_res,
			$campoChave,
			$varUrl,
			$pagEdit,
			$pagExc,
			$imgEdit,
			$imgExc,
			$camposTabDin,
			$rotulosTabDin,
			$idChave,
			$mensConsVazia,
			$tabela,
			$camposTab,
			$chaveTab,
			$txtEditExc,
			$contador,
			$_tipos,
			$convTipo,
			$indConv = array(0,0),
			$itemTemp,
			$itemTemp2,
			$itemConv,
			$posicao,
			$imgRedefEd = 0,
			$imgRedefExc = 0;
		
		/*
		Método construtor, recebe o banco de dados, host, login e senha e conecta ao MySQL
		Os parâmetros são recebidos da classe aplicativo
		*/
		function __construct() {
			$this->bd = $this->database;
			$this->conex = mysql_pconnect($this->hostname, $this->userDb, $this->passwordDb) or die(mysql_error());
		}
		
		//Para conexão com outro usuário/senha
        public function reconecta($usr, $pass) {
                $this->bd = $this->database;
		        $this->conex = mysql_pconnect($this->hostname, $usr, $pass) or die(mysql_error());
		}
		
		public function executaConsulta($_consulta) { //Executa a consulta e faz algumas atribuições padrão para ela
			mysql_select_db($this->bd, $this->conex);
			$this->_exequery = mysql_query($_consulta, $this->conex) or die(mysql_error());
			$this->_row = mysql_fetch_assoc($this->_exequery);
			$this->_rownum = mysql_fetch_row($this->_exequery);
						
		}
		
		public function executaComandoSQL($_comando) { //Executa o comando SQL definido
			mysql_select_db($this->bd, $this->conex);
			$this->_exequery = mysql_query($_comando, $this->conex) or die(mysql_error());
									
		}
		
						
		public function mostraResultadoLinha($linha, $campo) {
			return mysql_result($this->_exequery,$linha,$campo);
		}
		
		public function resetaLinha() { //Reseta a linha dos resultados, voltando à posição 0 (para índices com nome dos campos)
			mysql_data_seek($this->_exequery, 0);
			return $this->_row = mysql_fetch_assoc($this->_exequery);
		}
		
		public function resetaLinhaN() { //Reseta a linha dos resultados, voltando à posição 0 (para índices numéricos)
			mysql_data_seek($this->_exequery, 0);
			return $this->_rownum = mysql_fetch_row($this->_exequery);
		}
		
		public function mostraItem($_item) { //Mostra o item relativo ao campo especificado na linha do resultado (índice com nome do campo)
			return $this->_row[$_item];
		}
		
		public function mostraItemN($_item) { //Mostra o item relativo ao campo especificado na linha do resultado (índice numérico)
			return $this->_rownum[$_item];
		}
		
		public function avancaLinha() { //Usada para avançar a linha para exibição de resultado (usando índice com nomes dos campos)
			return $this->_row = mysql_fetch_assoc($this->_exequery);
		}
		
		public function avancaLinhaN() { //Usada para avançar a linha para exibição de resultado (usando índice numérico)
			return $this->_rownum = mysql_fetch_row($this->_exequery);
		}
		
		public function totalLinhas() { //Mostra o total de linhas da consulta
			return mysql_num_rows($this->_exequery);
		}
		
		public function vaiParaLinha($_linha) { //Vai para a linha especificada da consulta
			mysql_data_seek($this->_exequery, $_linha);
			return $this->_row = mysql_fetch_assoc($this->_exequery);
		}
		
		public function totalCampos() { //Retorna o número de campos do resultado
			return mysql_num_fields($this->_exequery);
		}
				
		public function mostraNomeCampo($_indice) { //Ao informarmos um índice, a função retorna o nome do campo
			return mysql_field_name($this->_exequery, $_indice);
		}
		
		public function mostraNomesCampos() { //Exibe os nomes dos campos
			$this->_campos = "";
			for ($_i = 0; $_i < $this->totalCampos(); $_i ++) {
				$this->_campos.= $this->mostraNomeCampo($_i);
				if ($_i != ($this->totalCampos() - 1)) {
					$this->_campos.= " - ";
				} 
			}
			return $this->_campos;
		}
		
		//Função que retorna o nome da chave primária de uma tabela informada
		public function getChaveTabela($tab) {
			$this->tabela = $tab;
			$this->executaConsulta($this->bd, $this->conex,'SHOW INDEX FROM '.$this->tabela);
			$this->resetaLinha();
			do {
					if ($this->mostraItem('Key_name') == 'PRIMARY') {
						$this->chaveTab = $this->mostraItem('Column_name');
					}
			} while ($this->avancaLinha());
			$this->limpaConsulta;
			return $this->chaveTab;
		}
		
		//Função que retorna os nomes dos campos de uma tabela informada e seus respectivos tipos
		public function getCamposTabela($tab) {
			$this->tabela = $tab;
			$this->executaConsulta($this->bd, $this->conex,'SHOW FULL FIELDS FROM '.$this->tabela);
			$this->resetaLinha();
			$i = 0;
			do {
					$this->camposTab[$i] = $this->mostraItem('Field');
					$this->camposTab[$i] .=','.$this->mostraItem('Type');
					$i ++;
			} while ($this->avancaLinha());
			$this->limpaConsulta;
			return $this->camposTab;
		}
		
		public function exibeResultado() { //Mostra o resultado da consulta em uma tabela HTML com os títulos dos campos
			$this->_res = '<table border="0" align="center" bordercolor="#000000">';
			$this->_res.="<tr>";
			for ($_i = 0; $_i < $this->totalCampos(); $_i ++) //Exibe o título dos campos
				$this->_res.= "<td><div align='center' class='texto'><strong>".$this->mostraNomeCampo($_i)."</strong></div></td>";
			$this->_res.="</tr>";
			$this->resetaLinhaN();
			do { 				//Exibe os campos
				$this->_res.="<tr>";
				for ($_i = 0; $_i < $this->totalCampos(); $_i ++) {
					$this->_res.= "<td><div align='left' class='texto'>".$this->mostraItemN($_i)."</div></td>";
				}
				$this->_res.= "</tr>";
			} while ($this->avancaLinhaN());
			$this->_res.="</table>";
			echo $this->_res;
		}
		
		
		/*
		Método que define o índice do atributo no resultado da consulta que será convertido (no caso de data ou datahora) 
		*/
		public function setConvIndice($ind, $_tipo) {
			$this->indConv = explode(",",$ind);
			$this->convTipo = explode(",",$_tipo);
		}	
		
		
		/*
		Método que trata o tipo (no caso de data) para o dado a ser convertido para
		a exibição dos resultados no método TabDin, respeitando as regras do método
		anterior
		*/
		public function trataItem($item, $posic) {
			//Define qual valor de indConv corresponde à posição informada
			for ($_cont = 0; $_cont < sizeof($this->indConv); $_cont ++) {
				if ($this->indConv[$_cont] == $posic) {
					$this->posicao = $_cont;
				}
			}
			
			switch ($this->convTipo[$this->posicao]) {
				
				//caso for um campo data, ele converte a data
				case "data": 
					return $this->convData($item,1);
					break;
				//Conversão para campo data/hora (converte apenas a data)
				case "datahora":
					//Separa a data da hora
					$this->itemTemp = explode(' ',$item);
					//Separa a hora
					$this->itemTemp2 = explode(':',$this->itemTemp[1]);
					//Monta o item com a data convertida e a hora sem os segundos
					$this->itemConv = $this->convData($this->itemTemp[0],1).' '.$this->itemTemp2[0].':'.$this->itemTemp2[1];
					return $this->itemConv;
					break;
				//Padrão, retorna o próprio item
				default:
					return $item;
					break;
			}
		}
				 
		//Redefine a imagem do link de edição, que pode ser usado para outro fim
		public function redefineImg1($im) {
			$this->imgRedefEd = 1;
			$this->imgEdit = $im;
		}
		
		
		//Redefine a imagem do link de edição, que pode ser usado para outro fim
		public function redefineImg2($im) {
			$this->imgRedefExc = 1;
			$this->imgExc = $im;
		}
		
		
		public function tabDin($campos, $rotulos, $txtedexc, $paged, $pagex, $idch, $vurl, $menscvazia) {
			//Recebe a mensagem que será exibida caso a consulta não retorne linhas
			$this->mensConsVazia = $menscvazia;
			//Só monta tabela se houverem linhas no resultado da consulta
			if ($this->totalLinhas() != 0) {
					//Recebe o índice dos campos a exibir
					$this->camposTabDin = Explode(",", $campos);
					//Recebe os rótulos (cabaçalho da tabela) para estes campos
					$this->rotulosTabDin = Explode(",", $rotulos);
					//Recebe o texto para os campos de redirecionamento da tabela
					if($txtedexc != '') {
						$this->txtEditExc = explode(",",$txtedexc);
					} else {
						$this->txtEditExc = array("Editar","Excluir");
					}
					//Recebe o caminho/nome da página de edição
					$this->pagEdit = $paged;
					//Se a imagem não foi redefinida, seleciona a padrão
					if ($this->imgRedefEd == 0) {
						//Recebe o caminho/nome da imagem para o link de edição
						$this->imgEdit = $this->img_editar;
					}
					//Recebe o caminho/nome da página de exclusão
					$this->pagExc = $pagex;
					//Se a imagem não foi redefinida, seleciona a padrão
					if ($this->imgRedefExc == 0) {
						//Recebe o caminho/nome da imagem para o link de exclusão
						$this->imgExc = $this->img_excluir;
					}
					//Recebe o índice da coluna onde está a chave que será passada via url nos links
					$this->idChave = $idch;
					//Recebe o nome da variável que será passada via url nos links de editar e excluir
					$this->varUrl = $vurl;
								
					$this->_res = '<table border="0" align="'.$this->alin_tabelas.'" cellpadding="5px" cellspacing="0" id="estilotodo">';
					$this->_res.='<tr class="titulo">';
					for ($_i = 0; $_i < sizeof($this->rotulosTabDin); $_i ++) {//Monta o título dos campos  
							$this->_res.= '<td><div class="labeltab" align="left">'.$this->rotulosTabDin[$_i].'</div></td>';
					}
					//Se a pagina de edicao foi informada em branco, não é criado a coluna para link de edição
					if ($this->pagEdit != '')
						$this->_res.= '<td><div align="center" class="labeltab">'.$this->txtEditExc[0].'</div></td>';
					//Se a pagina de exclusão foi informada em branco, não é criado a coluna para link de exclusão
					if ($this->pagExc != '')
						$this->_res.= '<td><div align="center" class="labeltab">'.$this->txtEditExc[1].'</div></td>';
					
					$this->_res.="</tr>";
					$this->resetaLinhaN();
					//Contador para alternar as cores das linhas
					$this->contador = 1;
					do { 				//Monta os campos
						//Controle das cores das linhas
						if (($this->contador % 2) == 0) { 
							$this->_res.='<tr class="estilounico">';
						} else 	$this->_res.='<tr>';
						
						for ($_i = 0; $_i < $this->totalCampos(); $_i ++) {
							if ($_i == $this->idChave) {
									//O valor do campo chave recebe o item da coluna especificada na var campoChave.
									$this->campoChave = $this->mostraItemN($_i);							
							}
							//A consulta só mostra os campos especificados por parâmetro em camposTabDin
							if (in_array($_i, $this->camposTabDin)) { 
								$this->_res.= '<td><div align="left" class="textotab">';
								//conv tipos data
								if (in_array($_i, $this->indConv)) {
									//conv	
									$this->_res .= $this->trataItem($this->mostraItemN($_i),$_i);
									//sem conv
								} else {
									$this->_res .= $this->mostraItemN($_i);
								}
									
									$this->_res .= '</div></td>';
							}
						}
						if ($this->pagEdit != '')
						$this->_res.= '<td><div align="center"><a href="'.$this->pagEdit.'?'.$this->varUrl.'='.$this->campoChave.'"><img src="'.$this->imgEdit.'" width="16" height="16" border="0"></a></div></td>';
						if ($this->pagExc != '')
						$this->_res.= '<td><div align="center"><a href="'.$this->pagExc.'?'.$this->varUrl.'='.$this->campoChave.'"><img src="'.$this->imgExc.'" width="16" height="16" border="0"></a></div></td>';
						$this->_res.= "</tr>";
						//Incrementa o contador
						$this->contador ++;
					} while ($this->avancaLinhaN());
					$this->_res.="</table>";
					
			//Caso a consulta não tenha retornado linhas, é montada uma mensagem informando o fato					
			} else $this->_res = '<div align="'.$this->alin_tabelas.'" class="labeltab">'.$this->mensConsVazia.'</div>';
			
			//Mostra a tabela dinâmica montada ou a mensagem de tabela sem itens
			echo $this->_res;
		}
		
		public function limpaConsulta() { //Limpa o resultado
			return mysql_free_result($this->_exequery);
		}
		
		
}
?>