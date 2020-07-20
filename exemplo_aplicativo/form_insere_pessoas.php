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
<p class="tit">Inserir pessoas</p>
<?php
//Instancia o formulario
$form1 = new form('formulario1','post','insere_pessoas.php','Enviar Dados:enviar','localiza_pessoas.php');

//Monta e exibe o formulario incluindo os campos descritos
$form1->setForm('Nome::campoTexto,,nome,,20;;Endereço::campoTexto,,endereco,,50;;Telefone::campoTexto,,telefone,,15;;Cidade::campoTexto,,cidade,,15');

?>
</body>
</html>
