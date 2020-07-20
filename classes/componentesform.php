<?php
/*
Conjunto de classes para componentes em formulários HTML
Autor: Jonatas Vieira
		jonnyleg@gmail.com
Data da última modificação: 22/12/2006
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

/*
Classe para componentes
Os demais componentes herdarão seus atributos e métodos
Data criação: 31/10/2006
*/
class componente {
	protected
		$nome,
		$tamanho,
		$valorPadrao,
		$campo;

	public function getNome() {
		return $this->nome;
	}
	public function getTamanho() {
		return $this->tamanho;
	}
	public function getValorPadrao() {
		return $this->valorPadrao;
	}
	public function setCampo() {
	}
}
/*
Classe para campo texto
Data Criação: 27/10/2006
*/
class campoTexto extends componente {

		//Método que monta o campo HTML texto com nome e tamanho definidos
		public function setCampo($name, $size, $value) {
			$this->nome = $name;
			$this->tamanho = $size;
			$this->valorPadrao = $value;
			$this->campo = '<input name="'.$this->nome.'" type="text" value="'.$this->valorPadrao.'" size="'.$this->tamanho.'" />';
			return $this->campo;
		}
}

//Campo texto longo
class campoTextoLongo extends componente {
		protected
			$linhas,
			$colunas;

		public function setCampo($name, $col, $lin, $value) {
			$this->nome = $name;
			$this->linhas = $lin;
			$this->colunas = $col;
			$this->valorPadrao = $value;
			$this->campo = '<textarea name="'.$this->nome.'" cols="'.$this->colunas.'" rows="'.$this->linhas.'">'.$this->valorPadrao.'</textarea>';
			return $this->campo;
		}
}

/*
Classe Campo Oculto (herda atributos de componente)
Data Criação: 27/10/2006
*/
class campoOculto extends componente {

		//Método que monta o campo HTML texto com nome e valor padrão definidos
		public function setCampo($name, $value) {
			$this->nome = $name;
			$this->valorPadrao = $value;
			$this->campo = '<input name="'.$this->nome.'" type="hidden" value="'.$this->valorPadrao.'"/>';
			return $this->campo;
		}
}

/*
Classe Campo Senha (herda atributos de componente)
Data Criação: 28/10/2006
*/
class campoSenha extends componente {


		public function setCampo($name, $size, $value) {
			$this->nome = $name;
			$this->tamanho = $size;
			$this->valorPadrao = $value;
			$this->campo = '<input name="'.$this->nome.'" type="password" value="'.$this->valorPadrao.'" size="'.$this->tamanho.'" />';
			return $this->campo;
		}
}


/*
Classe para campo data (herda atributos de campoTexto)
Data Criação: 27/10/2006
*/
class campoData extends componente {
		protected
			$js_formata;

		//Método que gera o JavaScript que será usado para a máscara da data
		public function scriptMascara() {
			$this->js_formata = "<SCRIPT>
			function formata(val)
								{
									var pass = val.value;
									var expr = /[0123456789]/;

									for(i=0; i<pass.length; i++){
										var lchar = val.value.charAt(i);
										var nchar = val.value.charAt(i+1);

										if(i==0){
										      if ((lchar.search(expr) != 0) || (lchar>3)){
											  val.value = '';
										   }

										}else if(i==1){

											   if(lchar.search(expr) != 0){
												  var tst1 = val.value.substring(0,(i));
												  val.value = tst1;
												  continue;
											   }

											   if ((nchar != '/') && (nchar != '')){
													var tst1 = val.value.substring(0, (i)+1);

													if(nchar.search(expr) != 0)
														var tst2 = val.value.substring(i+2, pass.length);
													else
														var tst2 = val.value.substring(i+1, pass.length);

													val.value = tst1 + '/' + tst2;
											   }

										 }else if(i==4){

												if(lchar.search(expr) != 0){
													var tst1 = val.value.substring(0, (i));
													val.value = tst1;
													continue;
												}

												if	((nchar != '/') && (nchar != '')){
													var tst1 = val.value.substring(0, (i)+1);

													if(nchar.search(expr) != 0)
														var tst2 = val.value.substring(i+2, pass.length);
													else
														var tst2 = val.value.substring(i+1, pass.length);

													val.value = tst1 + '/' + tst2;
												}
										  }

										  if(i>=6){
											  if(lchar.search(expr) != 0) {
													var tst1 = val.value.substring(0, (i));
													val.value = tst1;
											  }
										  }
									 }

									 if(pass.length>10)
										val.value = val.value.substring(0, 10);
										return true;
								}
								</SCRIPT>";
			return $this->js_formata;
		}

		//Método que monta o campo HTML data com nome e tamanho definidos
		public function setCampo($name, $size, $value) {
			$this->nome = $name;
			$this->tamanho = $size;
			//Recebe o valor padrao
			$this->valorPadrao = $value;
			//Monta o JavaScript para a máscara da data
			$this->campo = $this->scriptMascara();
			//Montando o campo com a máscara
			$this->campo .= '<input name="'.$this->nome.'" type="text" onkeyup=formata(this); value="'.$this->valorPadrao.'" size="'.$this->tamanho.'" />';
			return $this->campo;
		}
}


/*
Classe para campo data com a data de hoje como texto padrão(herda atributos e métodos de campoData)
Data Criação: 27/10/2006
*/
class campoDataHoje extends campoData {

		//Método que monta o campo HTML data com nome e tamanho definidos, mostrando a data atual
		public function setCampo($name, $size) {
			$this->nome = $name;
			$this->tamanho = $size;
			//Se o valor padrao digtado for a string hoje, ele exibe a data atual do relogio
			$this->valorPadrao = date("d/m/Y");
			//Monta o JavaScript para a máscara da data
			$this->campo = $this->scriptMascara();
			//Montando o campo com a máscara
			$this->campo .= '<input name="'.$this->nome.'" type="text" onkeyup=formata(this); value="'.$this->valorPadrao.'" size="'.$this->tamanho.'" />';
			return $this->campo;
		}
}

/*
Classe para botão em formulário HTML
Data Criação: 27/10/2006
*/
class botaoForm {
		protected
			$tipo,
			$nome,
			$texto,
			$botao;

		//Método que monta o botão
		public function setBotao($type, $name, $value) {
			$this->tipo = $type;
			$this->nome = $name;
			$this->texto = $value;
			$this->botao = '<input type="'.$this->tipo.'" name="'.$this->nome.'" value="'.$this->texto.'" />';
			return $this->botao;
		}
}


/*
Classe para campo de postagem de arquivos
Data Criação: 13/12/2006

*/

class campoArq extends componente {
		
		public function setCampo($name) {
			$this->nome = $name;
			$this->campo = '<input name="'.$this->nome.'" type="file" id="'.$this->nome.'" />';
			return $this->campo;
		}
}
		

/*
Classe para combo com opções estáticas
Data Criação: 07/12/2006

*/
class select extends componente {
		protected
			$opcoes,
			$optemp,
			$valPad,
			$tIni,
			$i;
		
		public function setCampo($name, $ops, $vp, $txt) {
			$this->nome = $name;
			$this->opcoes = explode("#",$ops);
			$this->tIni = $txt;
			$this->valPad = $vp;
			$this->campo = '<select name="'.$this->nome.'" id="'.$this->nome.'">';
			if ($this->tIni != '')
				$this->campo .= '<option value="semcod">'.$this->tIni.'</option>';
			for ($this->i = 0; $this->i < sizeof($this->opcoes); $this->i ++) {
				 $this->optemp = explode("/",$this->opcoes[$this->i]);
				 if (!(strcmp($this->valPad,$this->optemp[0]))) {
				 		$this->campo .= '<option value="'.$this->optemp[0].'"SELECTED>'.$this->optemp[1].'</option>';
				} else {
						$this->campo .= '<option value="'.$this->optemp[0].'">'.$this->optemp[1].'</option>';
				}
			}
			$this->campo .= '</select>';
			return $this->campo;
		}
}





/*
Classe para combo com valores retirados de outras tabelas no banco

Para uso em bancos de dados normalizados, onde para obter um elemento de outra tabela, precisamos
gravar seu código, mas queremos visualisar seu nome.
*/
class selectBd extends componente {
		protected
				$tabela,
				$comandoSql,
				$txtPadrao,
				$colValor,
				$ordem,
				$colLabel;


                //OBS - o parâmetro data é opcional, caso a coluna da label seja data, coloque um valor qualquer em $data que a função convData será chamada
                public function setCampo($name, $tab, $colval, $collab, $txt, $ord, $data) {
				$this->nome = $name;
				$this->tabela = $tab;
				$this->colValor = $colval;
				$this->colLabel = $collab;
				$this->txtPadrao = $txt;
				$this->ordem = $ord;
				$this->campo = '<select name="'.$this->nome.'" id="'.$this->nome.'">';
				if ($this->txtPadrao != '')
                                   $this->campo .= '<option value="semcod">'.$this->txtPadrao.'</option>';

                                $this->comandoSql = new sqlMy();
				$this->comandoSql->executaConsulta('select '.$this->colValor.', '.$this->colLabel.' from '.$this->tabela.' order by '.$this->colLabel.' '.$this->ordem);
				$this->comandoSql->resetaLinha();
				do {
					$this->campo .= '<option value="'.$this->comandoSql->mostraItem($this->colValor). '">'.(($data != '') ? $this->comandoSql->convData($this->comandoSql->mostraItem($this->colLabel),1) : $this->comandoSql->mostraItem($this->colLabel)).'</option>';
             	} while ($this->comandoSql->avancaLinha());
				$this->campo .= '</select>';
				return $this->campo;
		}
}

/*
Classe para combo em bd com um valor inicial pré-definido
Data Criação: 06/12/2006
*/
class selectBdVal extends selectBd {
		protected
				$valorPadrao;

		public function setCampo($name, $tab, $colval, $collab, $valpad, $ord, $data) {
				$this->nome = $name;
				$this->tabela = $tab;
				$this->colValor = $colval;
				$this->colLabel = $collab;
				$this->valorPadrao = $valpad;
				$this->ordem = $ord;
				$this->campo = '<select name="'.$this->nome.'" id="'.$this->nome.'">';
				$this->comandoSql = new sqlMy();
				$this->comandoSql->executaConsulta('select '.$this->colValor.', '.$this->colLabel.' from '.$this->tabela.' order by '.$this->colLabel.' '.$this->ordem);
				$this->comandoSql->resetaLinha();
				do {
					if (!(strcmp($this->comandoSql->mostraItem($this->colValor), $this->valorPadrao))) {
							$this->campo .= '<option value="'.$this->comandoSql->mostraItem($this->colValor).'"SELECTED>'.(($data != '') ? $this->comandoSql->convData($this->comandoSql->mostraItem($this->colLabel),1) : $this->comandoSql->mostraItem($this->colLabel)).'</option>';
					} else {
							$this->campo .= '<option value="'.$this->comandoSql->mostraItem($this->colValor). '">'.(($data != '') ? $this->comandoSql->convData($this->comandoSql->mostraItem($this->colLabel),1) : $this->comandoSql->mostraItem($this->colLabel)).'</option>';
					}
             	} while ($this->comandoSql->avancaLinha());
				$this->campo .= '</select>';
				return $this->campo;
		}
}
