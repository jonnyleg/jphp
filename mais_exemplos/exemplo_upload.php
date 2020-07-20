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
//Tamanho máximo, em bytes
$maxtam = 2000000;
//Pasta destino
$pasta = "/var/www/jphp/teste/arquivos/";

//Instancia o objeto
$arquivo = new recebeArq($maxtam, $pasta);

//Define o upload para adicionar o timestamp atual no nome dos arquivos postados
$arquivo->setTime();

//Recebe o arquivo
if ($arquivo->recebeArquivo($_FILES['teste'])) {
	//Se o arquivo foi postado com sucesso exibe a mensagem abaixo
	echo '<p class="mensconf">Arquivo postado com sucesso</p>';
//Caso contrário, exibe o erro correspondente
} else echo $arquivo->exibeErro();


?>
</body>
</html>