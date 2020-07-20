<?php
/*
Classe: Formulário HTML
Autor: Jonatas Vieira
		jonnyleg@gmail.com
Criada em 27/10/2006
Última modificação: 19/12/2006
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
class form extends aplicativo {
	protected 
			$nome,
			$metodo,
			$acao,
			$form,
			$componentes,
			$compTemp,
			$compTempDef,
			$compDefinido,
			$comp,
			$listaComponentesTemp1,
			$listaComponentesTemp2,
			$listaComponentesTemp3,
			$listaComponentes,
			$botao,
			$lnkVoltar,
			$textoNomeBotao,
			$lnkBack,
			$_arquivos = 0;
			
		
		/*
		Método construtor, já recebe alguns parâmetros iniciais
		Ex:
		form1 = new form('formulario1','post','trata.php','Enviar Dados:enviar');
		
		*/
		public function form($name, $method, $action, $txtbotao, $linkback){
				//Recebe o nome do formulário
				$this->nome = $name;
				//Recebe o método do formulário
				$this->metodo = $method;
				//Recebe a ação do formulário
				$this->acao = $action;
				//Recebe o texto do botão
				$this->textoNomeBotao = explode(':',$txtbotao);
				//Define o botão para enviar os dados
				$this->botao = new botaoForm();
				//Recebe o texto do botão
				$this->textoNomeBotao = explode(':',$txtbotao);
				//Link para o botão de voltar
				$this->lnkBack = $linkback;
				/*
				Variável, que se preenchida, fará o formulário apto para postagem
				de arquivos
				*/
				$this->_arquivos = $arq;
		}
		
		//Define que o formulário estará preparado para trabalhar com arquivos
		public function defArq() {
			$this->_arquivos = 1;
		}
		
		//Método utilizado para retornar o componente definido em uma string no método setForm
		protected function defineComponente($compon) {
				//Separa o tipo do componente e seus atributos
				$this->compTempDef = explode(',,',$compon);
				//Define qual componente será montado e monta de acordo com o nome passado
				switch($this->compTempDef[0]) {
						
						case 'label' :
								$this->compDefinido = '<font face="Arial, Helvetica, sans-serif" size="-1">'.$this->compTempDef[1].'</font>';
								break;
						
						case 'campoTexto' :
								$this->comp = new campoTexto();
								$this->compDefinido = $this->comp->setCampo($this->compTempDef[1], $this->compTempDef[2],$this->compTempDef[3]);
								break;
								
						case 'campoTextoLongo' :
								$this->comp = new campoTextoLongo();
								$this->compDefinido = $this->comp->setCampo($this->compTempDef[1], $this->compTempDef[2],$this->compTempDef[3],$this->compTempDef[4]);
								break;
						
						case 'campoSenha' :
								$this->comp = new campoSenha();
								$this->compDefinido = $this->comp->setCampo($this->compTempDef[1], $this->compTempDef[2],$this->compTempDef[3]);
								break;
								
						case 'campoData' :
								$this->comp = new campoData();
								$this->compDefinido = $this->comp->setCampo($this->compTempDef[1], $this->compTempDef[2],$this->compTempDef[3]);
								break;
								
																			
						case 'campoDataHoje' :
								$this->comp = new campoDataHoje();
								$this->compDefinido = $this->comp->setCampo($this->compTempDef[1], $this->compTempDef[2]);
								break;
						
						case 'campoOculto' :
								$this->comp = new campoOculto();
								$this->compDefinido = $this->comp->setCampo($this->compTempDef[1], $this->compTempDef[2]);
								break;
								
						case 'campoArq' :
								$this->comp = new campoArq();
								$this->compDefinido = $this->comp->setCampo($this->compTempDef[1]);
								break;
						
						case 'select' :
								$this->comp = new select();
								$this->compDefinido = $this->comp->setCampo($this->compTempDef[1], $this->compTempDef[2], $this->compTempDef[3], $this->compTempDef[4]);
								break;						
						
						
						case 'selectBd' :
								$this->comp = new selectBd();
								$this->compDefinido = $this->comp->setCampo($this->compTempDef[1], $this->compTempDef[2], $this->compTempDef[3], $this->compTempDef[4], $this->compTempDef[5], $this->compTempDef[6], $this->compTempDef[7]);
								break;

						case 'selectBdVal' :
								$this->comp = new selectBdVal();
								$this->compDefinido = $this->comp->setCampo($this->compTempDef[1], $this->compTempDef[2], $this->compTempDef[3], $this->compTempDef[4], $this->compTempDef[5],$this->compTempDef[6], $this->compTempDef[7], $this->compTempDef[8]);
								break;
						
						default:
								$this->compDefinido = 'Campo indefinido';
								break;
				}
				return $this->compDefinido;
		}
		
		
		//Método que guarda os nomes dos componentes do formulário em um vetor
		protected function guardaNomeComponentes($comps) {
				$this->listaComponentes = $comps;
				$this->listaComponentesTemp1 = $this->listaComponentes;
				
				for ($j = 0; $j < sizeof($this->listaComponentesTemp1); $j ++) {
					$this->listaComponentesTemp2 = explode('::',$this->listaComponentesTemp1[$j]);
					$this->listaComponentesTemp3 = explode(',,',$this->listaComponentesTemp2[1]);
					$this->listaComponentes[$j] = $this->listaComponentesTemp3[1];
				}
		}
		
		//Método que lista os nomes dos componentes do formulário
		public function mostraNomeComponentes() {
				for ($j = 0; $j < sizeof($this->listaComponentes); $j ++) {
					echo $this->listaComponentes[$j].'<br>';
				}
		}
		
		//Método que retorna o campo especificado
		public function nomeComponente($num) {
				return $this->listaComponentes[$num];
				
		}
					
					
				
		/*
		Método SetForm		
		Ele deve seguir a seguinte sintaxe:
		Por exemplo, queremos definir um formulário com nome e endereco:
		form1->setForm('Nome:campoTexto,nome,30;Endereco:campoTexto,endereco,30');
							
		*/
		public function setForm($comp) {
			
				//Recebe a lista de componentes e as separa
				$this->componentes = explode(';;',$comp);
				
				//Guarda os nomes dos campos do formulário em um vetor
				$this->guardaNomeComponentes($this->componentes);
				
				//Começa a montar o formulário
				$this->form = '<form id="'.$this->nome.'" name="'.$this->nome.'" method="'.$this->metodo.'" action="'.$this->acao.'"';
				//Verifica se o formulário vai trabalhar com arquivos
				if ($this->_arquivos == 1) {
					$this->form .= ' enctype="multipart/form-data" >';
				} else $this->form .= '>';
				//Comaça a montar a tabela dos componentes e respectivas labels
				$this->form .= '<table width="200" border="0" align="'.$this->alin_forms.'" id="estiloform">';
				
				//Inicia a montagem dos componentes um a um
				for ($i = 0; $i < sizeof($this->componentes); $i ++) {
						//Separa a label do componente da vez com seu respectivo componente
						$this->compTemp = explode('::',$this->componentes[$i]);
						$this->form .= '<tr>';
						//Monta a label do componente
						$this->form .= '<td class="label">'.$this->compTemp[0].'</td>';
						$this->form .= '<td>';
						//Define e monta o componente chamando a função defineComponente
						$this->form .= $this->defineComponente($this->compTemp[1]);
						$this->form .= '</td>';
						$this->form .= '</tr>';
				}
				//Monta o botão para enviar os dados
				$this->form .='<tr>';
				$this->form .='<td>&nbsp;</td>';
				$this->form .= '<td>';
				$this->form .= $this->botao->setBotao('submit',$this->textoNomeBotao[1],$this->textoNomeBotao[0]);
				$this->form .= '</td>';
				$this->form .= '</tr>';
				$this->form .='<tr>';
				$this->form .= '<td>';
				$this->form .= '<br>';
				if	($this->lnkBack != '') 
					$this->form .= $this->setLnkVoltar($this->lnkBack,$this->img_voltar);
				$this->form .= '</td>';
				$this->form .= '</tr>';
				$this->form .= '</table>';
				$this->form .= '</form>';
				
				//Exibe o formulário montado	
				echo $this->form;
		}
		
		protected function SetLnkVoltar($lnk, $btn) {
			$this->lnkVoltar = '<p align="'.$this->alin_btn_voltar.'"><a href="'.$lnk.'"><img src="'.$btn.'" width="24" height="24" border="0" align="'.$this->alin_btn_voltar.'" /></a></p>';
			return $this->lnkVoltar;
		}
}
		
					
					
					
			
			
