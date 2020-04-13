<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $title; ?> | App movies</title>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600&amp;subset=latin-ext" rel="stylesheet" />
	<link rel="stylesheet" href="<?= ASSETS; ?>css/main.css">
</head>
<body>
	<header id="header">
		<div id="logo">
			<a href="" title="Accueil">App movies</a>
		</div>
		<form action="" method="get">
			<div class="search">
				<label for="search">Rechercher un film</label>
				<input id="search" type="text" value="" placeholder="Rechercher par titre de film">
			</div>
			<div class="validate">
				<button type="submit">
					<svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" fill="#fff" viewBox="0 0 59.6 59.6"><path d="M40.3 40.3c-4 4-9.4 6.3-15.1 6.3S14.1 44.3 10 40.3C1.7 31.9 1.7 18.4 10 10c4.2-4.2 9.7-6.3 15.1-6.3s11 2.1 15.1 6.3c8.4 8.4 8.4 21.9.1 30.3M59 56.4L44.2 41.5c8.5-9.9 8.1-24.8-1.3-34.2-9.8-9.8-25.8-9.8-35.6 0s-9.8 25.8 0 35.6c4.8 4.8 11.1 7.4 17.8 7.4 6.1 0 11.8-2.2 16.4-6.1L56.4 59c.4.4.8.5 1.3.5s1-.2 1.3-.5c.8-.7.8-1.9 0-2.6"/></svg>
				</button>
			</div>
		</form>
	</header>
	<main class="wrapper">
