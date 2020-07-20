<?php
/*
Classe para localizador
Autor: Jonatas Vieira
		jonnyleg@gmail.com
Data criação: 10/11/2006
Última Modificação: 08/01/2007
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
    class localiza extends aplicativo {
		protected
			$consulta,
			$consultaFinal,
			$campoLoc,
			$formLoc,
			$tabLoc,
			$rotulo,
            $indice = '',
            $ordem = '',
            $clausulaEsp = '';

		/*
		Método construtor
		Recebe a consulta padrão da entidade para localizar e o campo que será comparado
		*/
		public function localiza($cons, $camploc, $rot) {
			$this->consulta = $cons;
			$this->campoLoc = $camploc;
			$this->rotulo = $rot;
			$this->formLoc = new form('formlocaliza','post',$_SERVER['PHP_SELF'],'Localizar:btnloc','');
			$this->tabLoc = new sqlMy();
		}

		//Redefine a imagem do link de edição, que pode ser usado para outro fim
		public function redefineImgEdit($_img) {
			//Chama o método correspondente na classe sqlMy
			$this->tabLoc->redefineImgEdit($_img);
		}


		//Redefine a imagem do link de edição, que pode ser usado para outro fim
		public function redefineImgExc($_img) {
			//Chama o método correspondente na classe sqlMy
			$this->tabLoc->redefineImgExc($_img);
		}

		/*
		Método que define qual índice  do resultado terá conversão de datas e o tipo da
		conversão (data ou datahora)
		*/
		public function setConvIndice($ind, $tipo) {
			//Chama o método correspondente na classe sqlMy
			$this->tabLoc->setConvIndice($ind, $tipo);
		}

                /*
                Método que define a coluna que ordenará a pesquisa e a ordem (asc ou desc)
                */
                public function setIndiceOrdem($ind, $order) {
                       $this->indice = $ind;
                       $this->ordem = $order;
                }
                
                /*
                Método que adiciona uma cláusula especial à consulta, caso necessária
                */
                public function setClausulaEsp($claus) {
                       $this->clausulaEsp = $claus;
                }

		/*
		Método que gera o localizador, recdebendo como parâmetros os mesmos parâmetros da tabela
		dinâmica
		*/
		public function montaLoc($campos, $rotulos, $txtedexc, $paged, $pagex, $idch, $vurl, $menscvazia) {
			$this->formLoc->setForm($this->rotulo.'::campoTexto,,'.$this->campoLoc.',,50');
			echo '<br><br><br><br><br>';
                        if (($this->indice != '') && ($this->ordem != '')) {
                           $this->consultaFinal = $this->consulta." where ".$this->campoLoc." like '%".$_POST[$this->campoLoc]."%'";
                           if ($this->clausulaEsp != '') {
                              $this->consultaFinal .= " and ".$this->clausulaEsp;
                           }
                           $this->consultaFinal .= " order by ".$this->indice." ".$this->ordem;
                        } else {
                           $this->consultaFinal = $this->consulta." where ".$this->campoLoc." like '%".$_POST[$this->campoLoc]."%'";
                           if ($this->clausulaEsp != '') {
                              $this->consultaFinal .= " and ".$this->clausulaEsp;
                           }
                        }
                        
                        if (isset($_POST[$this->campoLoc])) {
					$this->tabLoc->executaConsulta($this->consultaFinal);
					$this->tabLoc->tabDin($campos, $rotulos, $txtedexc, $paged, $pagex, $idch, $vurl, $menscvazia);
			}
		}
}
?>