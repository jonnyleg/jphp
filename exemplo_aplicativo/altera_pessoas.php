<?php //Referenciando o arquivo com a classe aplicativo e demais classes 
require_once('classes/apl.php');

$altera = new formBd();

$sql = sprintf("update pessoas set nome =%s, endereco =%s, telefone=%s, cidade=%s where idPessoa=%s",
				$altera->getSql($_POST['nome'],"text"),
				$altera->getSql($_POST['endereco'],"text"),
				$altera->getSql($_POST['telefone'],"text"),
				$altera->getSql($_POST['cidade'],"text"),
				$altera->getSql($_POST['idPessoa'],"int")
			);

//Código que deve ser passado via url novamente para o formulário de alteração
$codigoPessoa = $_POST['idPessoa'];

//Executa a alteração
$altera->executa($sql,"form_altera_pessoas.php?pessoa=$codigoPessoa","idPessoa");
?>