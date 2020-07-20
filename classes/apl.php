<?php
/*
J PHP - Versão 1.0
Autor: Jonatas Vieira Coutinho
		jonnyleg@gmail.com
Última modificação: 10/01/2007

Este arquivo apl.php deve ser refetenciado no cabeçalho das páginas da aplicação
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
// =============================================================================================
//Verifica a versão do PHP. Se for menor que 5, aborta o aplicativo
if (0 > version_compare(PHP_VERSION, '5')) {
    die('Este aplicativo só funciona com PHP versão 5 ou superior');
}
//Classe principal do aplicativo
class aplicativo {
		protected
			//Aqui entram as informações para o banco de dados
			//==================================
			/*
			Aqui entra o host do servidor MySQL
			Geralmente o servidor MySQL está na mesma máquina do servidor Apache/PHP, sendo o 
			host definido então como localhost. Caso seja outra máquina, substitua o localhost
			pelo endereço IP do servidor MySQL
			*/
			$hostname = "localhost",
			//Nome do banco de dados
			$database = "database",
			//Usuário do banco de dados
			$userDb = "usuario",
			//Senha do banco de dados
			$passwordDb = "senha",
			//==================================
			/*
			Aqui entram informações das imagens para exclusão/Alteração e botão de voltar nos
			formulários e tabelas dinâmicas
			Estas imagens já estão incluídas no "pacote". Não é necessária a alteração destes
			parâmetros se você não quiser substituí-las.			
			*/
			$img_editar = 'imagens/b_edit.png',
			$img_excluir = 'imagens/b_drop.png',
			$img_voltar = 'imagens/undo.png',
			//Alinhamentos de componentes (tabelas, formulários e botões de voltar)
			$alin_tabelas = 'left',
			$alin_forms = 'left',
			$alin_btn_voltar = 'right',
			//Outras variáveis para as funções da classes
			$_dataconv;

		/*
		Método para conversão de datas formato mysql (aaaa-mm-dd) para data brasileira (dd-mm-aaaa)
		e vice-versa
		Esta função foi retirada e adaptada de exemplos de scrips em PHP em fóruns de discussão
		*/
		public function convData($dataform, $tipo){
			  if ($tipo == 0) {
				 $datatrans = explode ("/", $dataform);
				 $this->_dataconv = "$datatrans[2]-$datatrans[1]-$datatrans[0]";
			  } elseif ($tipo == 1) {
				 $datatrans = explode ("-", $dataform);
				 $this->_dataconv = "$datatrans[2]/$datatrans[1]/$datatrans[0]";
			  }
			  return $this->_dataconv;
		}

		/*
		Método que prepara um valor para ser inserido à uma consulta SQL
		Deve-se usá-lo para evitar invasões bem sucedidas utilizando SQL Inject
		Esta função foi retirada e adaptada de exemplos de scrips em PHP em fóruns de discussão 
		*/
		public function getSql($Value, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
			{
			  $theValue = (!get_magic_quotes_gpc()) ? addslashes($Value) : $Value;

			  switch ($theType) {
				case "text":
				  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
				  break;
				case "long":
				case "int":
				  $theValue = ($theValue != "") ? intval($theValue) : "NULL";
				  break;
				case "double":
				  $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
				  break;
				case "date":
				  $theValue = ($theValue != "") ? "'" . $this->convData($theValue,0) . "'" : "NULL";
				  break;
				case "datetime":
				  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
				  break;
				case "time":
				  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
				  break;
				case "defined":
				  $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
				  break;
			  }
			  return $theValue;
			}
}
//Chama as demais classes do aplicativo
require_once('sqlmy.php');
require_once('componentesform.php');
require_once('form.php');
require_once('formbd.php');
require_once('localiza.php');
require_once('recebearq.php');
//==============================================================================================
?>