<?php
/**
 * Get all categories
 */
function getCategories(): array
{
	global $db;

	$sql = 'SELECT id, name FROM categories ORDER BY name ASC';
	$request = $db->query($sql);
	$results = $request->fetchAll();

	return $results;
}


function getMovies(): array
{
	global $db;
	$sql = 'SELECT id, title, description, image, releaseDate, viewer, slug FROM movies ORDER BY viewer DESC';
	$request = $db->query($sql);
	$results = $request->fetchAll();

	return $results;
}