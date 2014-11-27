<?php
$hostname = "localhost";
$database = "testeupload";
$username = "root";
$password = "";
$con = @mysql_pconnect($hostname, $username, $password) or trigger_error(mysql_error(),E_USER_ERROR); 

header("Content-type: text/html; charset=iso-8859-1"); // corrigir acentuação

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
	case "text":
	  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
	  break;	
	case "long":
	case "int":
	  $theValue = ($theValue != "") ? intval($theValue) : "NULL";
	  break;
	case "double":
	  $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
	  break;
	case "date":
	  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
	  break;
	case "defined":
	  $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
	  break;
  }
  return $theValue;
}

if(isset($_POST["insert"]) && ($_POST["insert"] == "form1")) {
if($_FILES['foto'] == '')
{
	if(isset($_POST['foto']) && $_POST['foto'] != '')
	{
		$nome_foto = $_POST['foto'];
	}
	else
	{
		$nome_foto = 'fotoDefault.jpg';
	}
	$err = TRUE;
}
else
{
	require_once "uploadImage.php";
}
if($err)
{

$insertSQL = sprintf("INSERT INTO usuario (nome, email, foto) VALUES (%s, %s, '$nome_foto')",
					   GetSQLValueString($_POST['nome'], "text"),
					   GetSQLValueString($_POST['email'], "text"));

  mysql_select_db($database, $con);
  $Result1 = mysql_query($insertSQL, $con) or die(mysql_error());
  if($Result1 > 0)
  {
	 echo('<script> alert("Cadastro efetuado com sucesso!");  </script>');
  }
}
  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
	$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
	$insertGoTo .= $_SERVER['QUERY_STRING'];
  }
	  
  echo('<meta http-equiv="refresh" content="0;URL=' . $insertGoTo  . '">');
}
?>
<html>
<head>
<title>Upload</title>

<script>
<!--
function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
	if (val) { nm=val.name; if ((val=val.value)!="") {
	  if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
		if (p<1 || p==(val.length-1)) errors+='- '+nm+' e-mail não é válido.\n';
	  } else if (test!='R') { num = parseFloat(val);
		if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
		if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
		  min=test.substring(8,p); max=test.substring(p+1);
		  if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
	} } } else if (test.charAt(0) == 'R') errors += '- '+nm+' Campo obrigatório.\n'; }
  } if (errors) alert('OCORRÊNCIAS DE ERROS:\n'+errors);
  document.MM_returnValue = (errors == '');
}
//-->

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
	d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
//-->
</script>

</head>
<body>

<?php
if((!isset($_GET['formulario'])) && (!isset($_GET['foto'])))
{
?>
<table width="450" border="0" align="center">
  <tr>
	<td align="center"><a href="index.php?formulario=1&img=1" title="Sem foto específica" target="_self">Inserir dados sem foto</a></td>
	<td align="center"><a href="index.php?formulario=1&img=2" title="Com foto específica" target="_self">Inserir dados com foto</a></td>
	<td align="center"><a href="listaFotos.php" title="Visualizar fotos do servidor" target="_blank">Ver fotos do servidor</a></td>
  </tr>
  <tr>
	<td colspan="3" align="justify"><br><br>

	<font face="Verdana, Arial, Helvetica, sans-serif" color="#996600">Nos links acima escolha inserir dados sem foto se queira inserir uma informação que não tenha foto específica, podendo para isto colocar uma foto que já esteja no servidor.<br><br>

	Para escolher uma foto que já esteja no servidor clique em ver fotos do servidor, copie o nome da foto escolhida, depois clique em inserir dados sem foto, então preencha os campos do formulário, colocando o nome da foto escolhida no campo foto.<br><br>

	Para inserir dados com uma foto específica, escolha inserir dados com foto, depois preencha o formulário completamente escolhendo no campo foto, qual foto queira e que está em seu disco.<br>

	Qualquer problema ou sugestão comunique-nos (Email).</font><br>
	
	</td>
  </tr>
</table>

<?php
}
else
{
if(isset($_GET['formulario']) && isset($_GET['img']))
{
if($_GET['img'] == 1)
{
?>
<form action="index.php" method="post" name="form1" onSubmit="MM_validateForm('nome','','R','email','','RisEmail');return document.MM_returnValue">
<? 
}
else
{
if($_GET['img'] == 2)
{
?>
<form action="index.php" method="post" enctype="multipart/form-data" name="form1" onSubmit="MM_validateForm('nome','','R','email','','RisEmail');return document.MM_returnValue">
<?
}
}
?>
  Nome: <input name="nome" type="text" maxlength="30"><br>
  Email: <input name="email" type="text" maxlength="30"><br>
<?php
if($_GET['img'] == 1)
{
?>
  Foto: <input name="foto" type="text" maxlength="30"><br>
<?php 
}
else
{
if($_GET['img'] == 2)
{
?>
Foto: <input type="file" name="foto" maxlength="15"><br>
<?php
}
}
?>
  <input type="submit" name="Submit" value="Enviar">
  <input type="hidden" name="insert" value="form1">
</form>
<?php
}
}
?>
</body>
</html>