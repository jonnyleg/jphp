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
<p class="tit">Cadastro de Pessoas</p><br><br>
<p class="texto"><a href="form_insere_pessoas.php">Inserir Nova</a></p>
<?php
	//Instancia o objeto localiza passando a consulta, o campo a ser pesquisado e a label do form
	$localizador = new localiza('select idPessoa, nome, endereco, telefone from pessoas','nome','Pesquisar');
	//Cria a tabela dinâmica
	$localizador->montaLoc('1,3','Nome,Telefone','Alterar,Deletar','form_altera_pessoas.php','form_deleta_pessoas.php',0,'pessoa','Pessoa não encontrada');
?>
</body>
</html>
