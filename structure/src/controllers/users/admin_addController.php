<?php
$requireFields = [
	'email' => [
		'message' => 'Merci de renseigner une adresse email.',
		'rule' => 'validateEmail'
	],
	'role_id' => [
		'message' => 'Merci de renseigner un rôle.'
	]
];

$requireFields = addValidate($requireFields);
$errors = checkFields($requireFields);
$userCurrent = existUser($router);
editOrAdd($router, $userCurrent, $errors);


/**
 * Detect if update or create user
 * 
 * @param object $router
 * @param array $userCurrent
 * @param array $errors
 */
function editOrAdd(object $router, array $userCurrent, array $errors) {
	if (!empty($_POST) && empty($errors)) :
		if (!empty($_GET['id'])) :
			updateUser($router);
		else :
			addUser();
		endif;
	elseif (empty($_POST)) :
		$_POST = $userCurrent;
	endif;
}


/**
 * Check if id matches with user into database
 * 
 * @param object $router
 * @return array $result
 */
function existUser(object $router) {
	$result = [];
	if (!empty($_GET['id'])) : 
		global $db;
		$data['id'] = $_GET['id'];
		$sql = 'SELECT * FROM users WHERE id = :id';
		$request = $db->prepare($sql);
		$request->execute($data);
		$result = $request->fetch();
		
		if (empty($result)) :
			header('Location: ' . $router->generate('usersList'));
			die();
		endif;
	endif;

	return $result;
}


/**	
 * Get roles
 * 
 * @return array all roles
 */
function getRoles(): array
{
	global $db;
	$sql = 'SELECT id, name FROM roles ORDER BY name ASC';
	$request = $db->query($sql);
	return $request->fetchAll();
}


/**
 * Edit user
 */
function updateUser($router) {
	global $db;
	$data = [
		'firstname' => $_POST['firstname'],
		'lastname' => $_POST['lastname'],
		'email' => $_POST['email'],
		'role_id' => $_POST['role_id'],
		'id' => $_POST['id']
	];

	$password = '';
	if (!empty($_POST['password'])) :
		$data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
		$password = ' password = :password, ';
	endif;

	$sql = 'UPDATE users SET firstname = :firstname, lastname = :lastname, email = :email, ' . $password . ' role_id = :role_id, modified = NOW() WHERE id = :id';
	$request = $db->prepare($sql);
	$request->execute($data);

	notif('L\'utilisateur a bien été modifié.', 'success');
	header('Location: ' . $router->generate('usersUpdate', ['id' => $_POST['id']]));
	die();
}


/**
 * Add user
 */
function addUser() {
	global $db;
	$data = [
		'firstname' => $_POST['firstname'],
		'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
		'lastname' => $_POST['lastname'],
		'email' => $_POST['email'],
		'role_id' => $_POST['role_id']
	];
	$sql = 'INSERT INTO users (firstname, lastname, email, password, role_id) VALUES (:firstname, :lastname, :email, :password, :role_id)';
	$request = $db->prepare($sql);
	$request->execute($data);

	notif('L\'utilisateur a bien été créé.', 'success');
	unset($_POST);
}


/**
 * Add fields to validate when edit form
 * 
 * @param array $requireFields 
 */
function addValidate(array $requireFields): array
{
	if (
		empty($_GET['id']) || 
		!empty($_POST) && !empty($_POST['password']) || 
		!empty($_POST) && !empty($_POST['passwordConfirm'])
	) :
		$requireFields['password'] =  [
			'message' => 'Merci de renseigner un mot de passe.',
			'rule' => 'validatePassword'
		];

		$requireFields['passwordConfirm'] = [
			'message' => 'Merci de renseigner une confirmation de mot de passe.',
			'rule' => 'validateSame'
		];
	endif;

	return $requireFields;
}
