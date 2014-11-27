<?
$arquivo = isset($_FILES["foto"]) ? $_FILES["foto"] : FALSE;
$max_image_x = 128;
$max_image_y = 80;
$diretorio = 'imagens/';  //diretório onde esão as imagens
if($arquivo)
{
	$tamanho = getimagesize($arquivo["tmp_name"]);
	ini_set ("max_execution_time", 3600); // uma hora
	require_once "functionsUpload.php";
	$err = FALSE;
	if(is_uploaded_file($arquivo['tmp_name']))
	{
		if(verifica_image($arquivo))
		{
			$tamanho = getimagesize($arquivo["tmp_name"]);
			$dimensiona = verifica_dimensao_image($arquivo, $max_image_x, $max_image_y);
			if($dimensiona != '')
			{
				if($dimensiona == 'altura')
				{
						$auxImage = $max_image_x;
						$max_image_x = $max_image_y;
						$max_image_y = $auxImage;
				}
			}
			else
			{
				$max_image_x = $tamanho[0];
				$max_image_y = $tamanho[1];
			}
			
			$nome_foto  = ('imagem_' . time() . '.' . verifica_extensao_image($arquivo));// nome único para foto
			$endFoto = $diretorio . $nome_foto;
			if(reduz_imagem($arquivo['tmp_name'], $max_image_x, $max_image_y, $endFoto))
			{
				$err = TRUE;
			}  
		}
	}
}
?>