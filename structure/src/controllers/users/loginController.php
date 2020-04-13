<?php
$requireFields = [
	'email' => [
		'message' => 'Merci de renseigner une adresse email.',
		'rule' => 'validateEmail'
	],
	'password' => [
		'message' => 'Merci de renseigner un mot de passe.'
	]
];

$errors = [];
if (!empty($_POST) && empty($_POST['firstname'])) :
	$errors = checkFields($requireFields);
	if (empty($errors)) :
		$data = ['email' => $_POST['email']];
		$sql = 'SELECT password FROM users WHERE email = :email';
		$request = $db->prepare($sql);
		$request->execute($data);
		$result = $request->fetch();

		if (!empty($result['password']) && password_verify($_POST['password'], $result['password'])) :
			$_SESSION['auth'] = true;
			header('Location: ' . $router->generate('usersList'));
			die();
		endif;
		notif('Impossible de vous identifier');
	endif;
endif;
