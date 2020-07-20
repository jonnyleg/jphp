<?php
/*
Classe para formulários de inserção, alteração e exclusão de dados em BD.
Autor: Jonatas Vieira
		jonnyleg@gmail.com
Data Criação: 29/10/2006
Última Alteração: 22/04/2007
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
class formBd extends aplicativo {
		protected
			$comando,
			$comandoSql = array(),
			$pagDest,
			$user = '',
			$password = '';
			
			
		public function monta($sql, $pag) {
			$this->comandoSql = explode("::",$sql);
			$this->pagDest = $pag;
		}	
		
		//Método que redefine o usuário e senha do bd
		public function redefineUsu($usr, $pass) {
			$this->user = $usr;
			$this->password = $pass;
		}
		
		/*
		Método que monta o formulário
		*/
		public function executa($sql, $pag, $varpost) {
		
			$this->monta($sql, $pag);
						
			/*Só executa os comando SQL se a variável post definida existir
			Isto acontece quando o usuário clica no botão de inserir/deletar/editar do formulário da página anterior e a página onde reside este script é chamada
			*/
			if ((isset($_POST[$varpost]))) {
				//Executa o(s) comando(s) SQL definido(s)
				$this->comando = new sqlMy();
				//Reconecta com outro usuário no banco caso tenha sido redefinido
				if ($this->user != '') {
					$this->comando->reconecta($this->user, $this->password);
				}
				//Executa o(s) comando(s) sql
				for($i = 0; $i < sizeof($this->comandoSql); $i ++) {
					$this->comando->executaComandoSQL($this->comandoSql[$i]);
				}
			}
			//Vai para a página de destino
			header("Location: ".$this->pagDest);
			
		}
}