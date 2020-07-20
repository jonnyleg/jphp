<?php //Referenciando o arquivo com a classe aplicativo e demais classes 
require_once('classes/apl.php');

//Instancia o objeto da classe formBd
$insere = new formBd();

//Monta a sql utilizando o método getSql para tratar as strings
$sql = sprintf("insert into pessoas values (NULL, %s, %s, %s, %s)",
				$insere->getSql($_POST['nome'],"text"),
				$insere->getSql($_POST['endereco'],"text"),
				$insere->getSql($_POST['telefone'],"text"),
				$insere->getSql($_POST['cidade'],"text")
			);
//Insere os valores
$insere->executa($sql,"form_insere_pessoas.php","nome");
?>
