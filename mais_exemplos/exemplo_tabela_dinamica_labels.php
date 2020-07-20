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
<?php
	//Instancia o objeto sqlMy com as informações padrão do banco de dados na classe aplicativo
	$pessoas = new sqlMy();
	//Executa a consulta
	$pessoas->executaConsulta("select idPessoa, nome, endereco, telefone from pessoas order by nome");
	echo "<p class='tit'>Consulta utilizando tabela dinâmica</p><br><br>";
	//Cria a tabela dinâmica
	$pessoas->tabDin('1,3','Nome,Telefone','Alterar,Deletar','edita.php','exclui.php',0,'pessoa','Não exitem pessoas cadastradas');
?>
</body>
</html>
