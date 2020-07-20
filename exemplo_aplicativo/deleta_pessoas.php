<?php //Referenciando o arquivo com a classe aplicativo e demais classes 
require_once('classes/apl.php');

$deleta = new formBd();

$sql = sprintf("delete from pessoas where idPessoa =%s",
				$deleta->getSql($_POST['idPessoa'],"int")
			);

//Executa a alteração
$deleta->msg("oi");
$deleta->executa($sql,"localiza_pessoas.php","idPessoa");
?>
