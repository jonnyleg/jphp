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

//Instancia o formulário
$formarq = new form('formulario1','post','exemplo_upload.php','Postar:btnpost','');

//Define o formulário para trabalhar com arquivos
$formarq->defArq();

//Monta o formulário
$formarq->setForm("Arquivo::campoArq,,teste");
?>

</body>
</html>