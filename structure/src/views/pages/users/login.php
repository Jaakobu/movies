<?php get_header('Se connecter', 'login'); ?>

<form action="" class="form-signin text-center" method="post">
	<?= displayNotif(); ?>

	<h1 class="h3 mb-3">Se connecter</h1>
	<div>
		<?php $error = errorField($errors, 'email'); ?>
		<label for="email" class="sr-only">Adresse email</label>
		<input class="form-control<?= $error['class']; ?>" type="email" name="email" placeholder="Adresse email" value="<?= valueField('email'); ?>" id="email" autofocus>
		<?= $error['message']; ?>
	</div>
	<div>
		<?php $error = errorField($errors, 'password'); ?>
		<label for="password" class="sr-only">Mot de passe</label>
		<input class="form-control<?= $error['class']; ?>" type="password" name="password" placeholder="Mot de passe" id="password">
		<?= $error['message']; ?>
	</div>
	<div class="d-none">
		<label for="firstname" class="sr-only">Votre prénom</label>
		<input type="text" class="form-control" name="firstname" id="firstname">
	</div>
	<div class="mt-3">
		<input class="btn btn-primary btn-block" type="submit" value="Se connecter">
	</div>
	<div class="mt-3 small">
		<a href="" title="Mot de passe oublié" class="text-muted">Mot de passe oublié ?</a>
	</div>
</form>

<?php get_footer('login'); ?>
