<?php
/*
Classe para recebimento de arquivos
Autor: Jonatas Vieira
		jonnyleg@gmail.com
Criada em 14/09/2006
Última modificação: 08/01/2007
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
	class RecebeArq {
		protected
				$tamanho_maximo,
				$arquivo,
				$arq_gravado,
				$pasta,
				$destino,
				$nome,
				$destTemp,
				$nomeTemp,
				$nomeTime = 0,
				$timeAtual,
				$erro,
				$conteudo,
				$conteudoe,
				$cont;

		function __construct($maxi, $pas) {
				$this->DefineMaxTam($maxi);
				$this->DefinePastaDestino($pas);
			}

		public function DefineMaxTam($max) { //em bytes
				$this->tamanho_maximo = $max;
			}

		public function DefinePastaDestino($ps) {
				$this->pasta = $ps;
			}

		public function getNomeArq() {
				return $this->nome;
		}

		public function exibeErro() {
				echo $this->erro;
		}

		/*
                 Método que define que o nome do arquivo conterá um identificador único de timestamp
		*/
         public function setTime() {
                 $this->nomeTime = 1;
 		}


		/*
		Método que recebe o arquivo
		Vai receber uma variável tipo $_FILES[] e retornar 1 se conseguir gravar no destino
		corretamente.

		Se o progrmador quiser renomear o arquivo no destino concatenando um outro nome ao nome do
		arquivo, é só informar o novo nome no parâmetro	$nom, caso queira manter o nome original,
		coloque '' no parâmetro.

		*/
		public function recebeArquivo($arq) {
				$this->arquivo = $arq;

				if($this->arquivo['error'] != 0) {
						$this->erro = '<p class="menserro">Erro no Upload do arquivo</p>';
						switch($arquivo['erro']) {
						case  UPLOAD_ERR_INI_SIZE:
								$this->erro .= '<p class="menserro">O Arquivo excede o tamanho máximo permitido</p>';
								break;
						case UPLOAD_ERR_FORM_SIZE:
								$this->erro .= '<p class="menserro">O Arquivo enviado é muito grande</p>';
								break;
						case  UPLOAD_ERR_PARTIAL:
								$this->erro .= '<p class="menserro">O upload não foi completo</p>';
								break;
						case UPLOAD_ERR_NO_FILE:
								$this->erro .= '<p class="menserro">Nenhum arquivo foi informado para upload</p>';
								break;
						}
						return 0;
				}

				if($this->arquivo['size'] == 0 || $this->arquivo['tmp_name'] == NULL) {
						$this->erro = '<p class="menserro">Nenhum arquivo enviado</p>';
						return 0;
				}

				if($this->arquivo['size'] > $this->tamanho_maximo) {
						$this->erro =  '<p class="menserro">O Arquivo enviado é muito grande (Tamanho Máximo = '.$this->tamanho_maximo.' bytes)</p>';
						return 0;
				}

				if ($this->nomeTime == 1) {
				   			//Recebe o timestamp atual
                   			$this->timeAtual = time();
                   			//Quebra o nome da extensão e joga o timestamp entre eles
                   			$this->nomeTemp = explode(".",$this->arquivo['name']);
                   			$this->nome = $this->nomeTemp[0].$this->timeAtual.".".$this->nomeTemp[1];
				   			$this->destino = $this->pasta.$this->nome;

				} else {
                            $this->nome = $this->arquivo['name'];
				   			$this->destino = $this->pasta.$this->arquivo['name'];
				}

				if(move_uploaded_file($this->arquivo['tmp_name'],$this->destino)) {
							return 1;
				} else {
						$this->erro = '<p class="menserro">Ocorreu um erro durante o upload</p>';
							return 0;
				}
			}
		//Mostra o conteúdo do arquivo recebido
		public function mostraConteudo() {
				$this->arq_gravado = fopen($this->destino,'r');
				while(!feof($this->arq_gravado))
					$this->conteudo[] = fgets($this->arq_gravado);
				fclose($this->arq_gravado);
				$this->conteudoe = "<table border='0'>";
				for($this->cont = 0; $this->cont < sizeof($this->conteudo); $this->cont ++){
						$this->conteudoe .= "<tr>";
						$this->conteudoe .= "<td><p class='texto'>".$this->conteudo[$this->cont]."</p></td>";
						$this->conteudoe .= "</tr>";
				}
				$this->conteudoe .= "</table>";
				echo $this->conteudoe;
		}
		//Mostra o conteúde de qualquer outro arquivo na mesma pasta, bastando informar o nome
		public function MostraConteudoGeral($nomea) {
				$this->arq_gravado = fopen($this->pasta.$nomea,'r');
				while(!feof($this->arq_gravado))
					$this->conteudo[] = fgets($this->arq_gravado);
				fclose($this->arq_gravado);
				$this->conteudoe = "<table border='0'>";
				for($this->cont = 0; $this->cont < sizeof($this->conteudo); $this->cont ++){
						$this->conteudoe .= "<tr>";
						$this->conteudoe .= "<td><p class='texto'>".$this->conteudo[$this->cont]."</p></td>";
						$this->conteudoe .= "</tr>";
				}
				$this->conteudoe .= "</table>";
				echo $this->conteudoe;
		}

		public function DeletaArquivo() {
				chdir($this->pasta);
				exec("rm ".$this->arquivo['name']);
		}

	}
?>