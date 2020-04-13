<?php

function getMovie() 
{
	global $db;
	$data = ['slug' => $_GET['slug']];
	$sql = 'SELECT * FROM movies WHERE slug = :slug';
	$request = $db->prepare($sql);
	$request->execute($data);
	$result = $request->fetch();

	if (!$result) :
		header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
		require_once PAGES . 'errors/404.php';
		die();
	endif;

	return $result;
}

$movie = getMovie();
