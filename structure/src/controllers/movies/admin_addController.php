<?php
$requireFields = [
	'title' => [
		'message' => 'Merci de renseigner un titre de film.',
	],
	'slug' => [
		'message' => 'Merci de renseigner un slug.',
		'rule' => 'validateSlug'
	],
	'description' => [
		'message' => 'Merci de renseigner une description.',
	],
	'releaseDate' => [
		'message' => 'Merci de renseigner une date de sortie.',
		'rule' => 'validateDate'
	],
	'viewer' => [
		'message' => 'Merci de renseigner un nombre de spectateur.',
		'rule' => 'validateInt'
	],
	'image' => [
		'message' => 'Merci de renseigner une affiche de film.',
		'rule' => [
			'name' => 'validateImage',
			'options' => [
				'path' => 'images/movies',
				'extensions' => ['jpg', 'png', 'jpeg']
			]
		]
	]
];

$errors = checkFields($requireFields);
$movieCurrent = existMovie($router);
editOrAdd($router, $movieCurrent, $errors);


/**
 * Detect if update or create movie
 * 
 * @param object $router
 * @param array $movieCurrent
 * @param array $errors
 */
function editOrAdd(object $router, array $movieCurrent, array $errors) {
	if (!empty($_POST) && empty($errors)) :
		if (!empty($_GET['id'])) :
			updateMovie($router);
		else :
			addMovie();
		endif;
	elseif (empty($_POST)) :
		$_POST = $movieCurrent;
	endif;
}


/**
 * Check if id matches with movie into database
 * 
 * @param object $router
 * @return array $result
 */
function existMovie(object $router) {
	$result = [];
	if (!empty($_GET['id'])) : 
		global $db;
		$data['id'] = $_GET['id'];
		$sql = 'SELECT * FROM movies WHERE id = :id';
		$request = $db->prepare($sql);
		$request->execute($data);
		$result = $request->fetch();
		
		if (empty($result)) :
			header('Location: ' . $router->generate('moviesList'));
			die();
		endif;
	endif;

	return $result;
}


/**
 * Edit movie
 */
function updateMovie($router) {
	global $db;
	$data = [
		'title' => $_POST['title'],
		'slug' => $_POST['slug'],
		'description' => $_POST['description'],
		'viewer' => $_POST['viewer'],
		'releaseDate' => $_POST['releaseDate'],
		'id' => $_POST['id']
	];

	$sql = 'UPDATE movies SET title = :title, slug = :slug, description = :description, viewer = :viewer, releaseDate = :releaseDate, modified = NOW() WHERE id = :id';
	$request = $db->prepare($sql);
	$request->execute($data);

	notif('Le film a bien été modifié.', 'success');
	header('Location: ' . $router->generate('moviesUpdate', ['id' => $_POST['id']]));
	die();
}


/**
 * Add movie
 */
function addMovie() {
	global $db;
	$data = [
		'title' => $_POST['title'],
		'slug' => $_POST['slug'],
		'description' => $_POST['description'],
		'viewer' => $_POST['viewer'],
		'releaseDate' => $_POST['releaseDate']
	];
	$sql = 'INSERT INTO movies (title, slug, description, viewer, releaseDate) VALUES (:title, :slug, :description, :viewer, :releaseDate)';
	$request = $db->prepare($sql);
	$request->execute($data);

	notif('Le film a bien été créé.', 'success');
	unset($_POST);
}
