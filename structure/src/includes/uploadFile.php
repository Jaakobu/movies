<?php
/**	
 * Upload file
 * 
 * @param string $path to save file
 * @param string $field name of input type file
 */
function uploadFile(string $path, string $field, array $exts = ['jpg', 'png', 'jpeg'], int $maxSize = 2097152): string
{
	// Check submit form with post method
	if (empty($_FILES)) :
		return '';
	endif;

	dump($path);
	
	// Check exit directory if not create
	if (!is_dir($path) && !mkdir($path, 0755)) :
		return 'Impossible d\'importer votre fichier.';
	endif;

	// Check not empty input file
	if (empty($_FILES[$field]['name'])) :
		return 'Merci d\'uploader un fichier';
	endif;
	
	// Check exts
	$currentExt = pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION);
	$currentExt = strtolower($currentExt);
	if (!in_array($currentExt, $exts)) :
		$exts = implode(', ', $exts);
		return 'Merci de charger un fichier avec l\'une de ces extensions : ' . $exts . '.';
	endif;

	// Check no error into current file
	if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK) :
		return 'Merci de sélectionner un autre fichier.';
	endif;

	// Check max size current file
	if ($_FILES[$field]['size'] > $maxSize) :
		return 'Merci de charger un fichier ne dépassant pas cette taille : ' . formatBytes($maxSize);
	endif;

	$filename = pathinfo($_FILES[$field]['name'], PATHINFO_FILENAME);
	$filename = renameFile($filename);
	$targetToSave = $path . '/' . $filename . '.' . $currentExt;
	
	if(move_uploaded_file($_FILES[$field]['tmp_name'], $targetToSave)) :
		return 'Super !';
	endif;

	return '';
}


function formatBytes($size, $precision = 2) {
	$base     = log($size, 1024);
	$suffixes = ['', 'Ko', 'Mo', 'Go', 'To'];

	return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
}


function renameFile(string $name) {
	$name = trim($name);
	$name = strip_tags($name);
	$name = removeAccent($name);
    $name = preg_replace('/[\s-]+/', ' ', $name);  //Clean up multiple dashes and whitespaces
	$name = preg_replace('/[\s_]/', '-', $name); //Convert whitespaces and underscore to dash
	$name = preg_replace('/[^A-Za-z0-9\-]/', '', $name);
	$name = strtolower($name);
	$name = trim($name, '-');

	return $name;
}


function removeAccent($string) {
	$string = str_replace(
		['à','á','â','ã','ä', 'ç', 'è','é','ê','ë', 'ì','í','î','ï', 'ñ', 'ò','ó','ô','õ','ö', 'ù','ú','û','ü', 'ý','ÿ', 'À','Á','Â','Ã','Ä', 'Ç', 'È','É','Ê','Ë', 'Ì','Í','Î','Ï', 'Ñ', 'Ò','Ó','Ô','Õ','Ö', 'Ù','Ú','Û','Ü', 'Ý'], 
		['a','a','a','a','a', 'c', 'e','e','e','e', 'i','i','i','i', 'n', 'o','o','o','o','o', 'u','u','u','u', 'y','y', 'A','A','A','A','A', 'C', 'E','E','E','E', 'I','I','I','I', 'N', 'O','O','O','O','O', 'U','U','U','U', 'Y'], 
		$string
	);
	return $string;
}