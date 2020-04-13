<?php 
if (isset($_SESSION['auth'])) :
	unset($_SESSION['auth']);
	notif('Vous êtes bien déconnecté.', 'success');
endif;

header('Location: ' . $router->generate('login'));
die();