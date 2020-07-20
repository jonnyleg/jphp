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
//Instancia o formulario
$form1 = new form('formulario1','post','insere.php','Enviar Dados:enviar','main.php');
 
//Monta e exibe o formulario incluindo os campos descritos
$form1->setForm('Nome::campoTexto,,nome,,20;;Senha::campoSenha,,passwd,,10;;Data Cadastro::campoData,,data,,15;;Inclusão::campoDataHoje,,datainc,,15;;Responsável::selectBdVal,,responsavel,,pessoas,,idPessoa,,nome,,3,,asc');

?>
</body>
</html>
