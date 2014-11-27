<table border="1" align="center"> 
<?php
require_once "functionsUpload.php";
$dir = 'imagens'; //diretório onde estão as imagens
$handle=opendir($dir);
$i=0;
$j = 0;
while ($file = readdir($handle)) {
if (eregi("jpg$",$file) || eregi("gif$",$file) || eregi("png$",$file)){
if($i == 0 || $j == 5)
{
	$j = 0;
	echo('<tr>');
}
?>
<td align="center" valign="top">
<img src=<?php echo($dir . '/' . $file) ?> width=128 height=96>
<br><font size=2><b><?php echo($file) ?></b>
</td>
<?php
if($j == 4)
{
	echo('</tr>');	
}
$j=$j+1;
$i=$i+1;
};
};
closedir($handle);
?> 

</table>