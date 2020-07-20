<?php //Referenciando o arquivo com a classe aplicativo e demais classes 
require_once('classes/apl.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- Referenciando o arquivo com as definições CSS -->
<link rel="StyleSheet" type="text/css" href="classes/defcss.css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Teste com J PHP</title>
</head>

<body>
<p class="tit">Alterar pessoa</p>
<?php
//Verifica se uma pessoa foi selecionada antes deste formulário ser chamado
if (!isset($_GET['pessoa'])) die('sem referência');

//Instancia a consulta para exibir os valores padrão
$pessoas = new sqlMy();

//Monta a sql com a referência ao código da pessoa selecionada
$sql = sprintf("select * from pessoas where idPessoa = %s",
				$pessoas->getSql($_GET['pessoa'], "int")
		);
//Executa a consulta		
$pessoas->executaConsulta($sql);

//Caso o código passado via url não corresponda a uma pessoa no banco de dados o sistema aborta
if ($pessoas->totalLinhas() == 0) die('sem referência');

//Instancia o formulário
$form1 = new form('formulario1','post','altera_pessoas.php','Alterar dados:alterar','localiza_pessoas.php');

/*
Monta e exibe o formulario incluindo os campos descritos com o resultado da consulta
como valores padrão
*/
$form1->setForm("Nome::campoTexto,,nome,,20,,".$pessoas->mostraItem('nome').";;Endereço::campoTexto,,endereco,,50,,".$pessoas->mostraItem('endereco').";;Telefone::campoTexto,,telefone,,15,,".$pessoas->mostraItem('telefone').";;Cidade::campoTexto,,cidade,,15,,".$pessoas->mostraItem('cidade').";;::campoOculto,,idPessoa,,".$pessoas->mostraItem('idPessoa'));
?>
</body>
</html>
