<?php get_header('Liste des utilisateurs', 'admin'); ?>

<div class="row mb-4">
	<h1 class="col-6">Liste des utilisateurs</h1>
	<div class="col-6 text-right">
		<a href="<?= $router->generate('usersAdd'); ?>" class="btn btn-success" title="Ajouter">Ajouter</a>
	</div>
</div>

<table class="table table-striped">
	<thead class="thead-dark">
		<tr>
			<th>Email</th>
			<th>Date d'ajout</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $value) : ?>
			<tr>
				<td class="align-middle"><?= $value['email']; ?></td>
				<td class="align-middle"><?= dateFormat($value['created']); ?></td>
				<td class="align-middle">
					<a href="<?= $router->generate('usersUpdate', ['id' => $value['id']]); ?>" class="btn btn-warning mr-2" title="Modifier">Modifier</a>
					<a href="<?= $router->generate('usersDelete', ['id' => $value['id']]); ?>" class="btn btn-danger" title="Supprimer">Supprimer</a>					
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php get_footer('admin'); ?>