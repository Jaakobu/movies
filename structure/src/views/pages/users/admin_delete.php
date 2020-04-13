<?php get_header('Supprimer un utilisateur', 'admin'); ?>
	<h1>Supprimer le compte "<?= $currentUser['email']; ?>"</h1>
	<p>Êtes vous certain de vouloir supprimer définitivement cet utilisateur ?</p>
	<a href="<?= $router->generate('usersDelete', ['id' => $_GET['id']]); ?>?confirm=1" title="Supprimer définitivement" class="btn btn-danger mr-2">
		Supprimer définitivement
	</a>
	<a href="<?= $router->generate('usersList'); ?>" title="Annuler la suppression" class="btn btn-secondary">
		Annuler
	</a>
<?php get_footer('admin'); ?>