<?php
/**
 * Get current movie data into database
 * 
 * @return array result sql request
 */
function getMovie(): array
{
	global $db;
	$data['id'] = $_GET['id'];
	$sql = 'SELECT title FROM movies WHERE id = :id';
	$request = $db->prepare($sql);
	$request->execute($data);
	$results = $request->fetch();

	return ($results) ? $results : [];
}
$currentMovie = getMovie();


/**
 * Check if id matches with movie into database
 * 
 * @param object $router
 * @param array $currentMovie data of current movie id
 */
function existMovie(object $router, array $currentMovie) {
	if (empty($currentMovie)) :
		header('Location: ' . $router->generate('moviesList'));
		die();
	endif;
}
existMovie($router, $currentMovie);


/**
 * Delete current movie into db and redirect
 * 
 * @param object $router
 */
function delete(object $router) {
	global $db;

	if (!empty($_GET['confirm'])) :
		$data['id'] = $_GET['id'];
		$sql = 'DELETE FROM movies WHERE id = :id';
		$request = $db->prepare($sql);
		$request->execute($data);

		notif('Le film a bien été supprimé.', 'success');
	
		header('Location: ' . $router->generate('moviesList'));
		die();
	endif;
}
delete($router);
