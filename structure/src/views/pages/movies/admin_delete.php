<?php get_header('Supprimer un film', 'admin'); ?>
	<h1>Supprimer le compte "<?= $currentMovie['title']; ?>"</h1>
	<p>Êtes vous certain de vouloir supprimer définitivement ce film ?</p>
	<a href="<?= $router->generate('moviesDelete', ['id' => $_GET['id']]); ?>?confirm=1" title="Supprimer définitivement" class="btn btn-danger mr-2">
		Supprimer définitivement
	</a>
	<a href="<?= $router->generate('moviesList'); ?>" title="Annuler la suppression" class="btn btn-secondary">
		Annuler
	</a>
<?php get_footer('admin'); ?>