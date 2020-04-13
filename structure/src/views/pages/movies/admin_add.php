<?php get_header('Éditer un film', 'admin'); ?>

<h1 class="mb-4">Éditer un film</h1>

<form action="" method="post" class="form" novalidate autocomplete="off" enctype="multipart/form-data">
	<div class="form-group">
		<?php $error = errorField($errors, 'title'); ?>
		<label for="title">Titre</label>
		<input type="text" class="form-control<?= $error['class']; ?>" value="<?= valueField('title'); ?>" id="title" name="title">
		<?= $error['message']; ?>
	</div>
	<div class="form-group">
		<?php $error = errorField($errors, 'slug'); ?>
		<label for="title">Slug</label>
		<input type="text" class="form-control<?= $error['class']; ?>" value="<?= valueField('slug'); ?>" id="slug" name="slug">
		<?= $error['message']; ?>
	</div>
	<div class="form-group">
		<?php $error = errorField($errors, 'description'); ?>
		<label for="title">Description</label>
		<textarea name="description" class="form-control<?= $error['class']; ?>" id="description"><?= valueField('description'); ?></textarea>
		<?= $error['message']; ?>
	</div>
	<div class="form-group">
		<?php $error = errorField($errors, 'image'); ?>
		<label for="image">Image</label>
		<input class="form-control-file<?= $error['class']; ?>" type="file" id="image" name="image">
		<?= $error['message']; ?>
	</div>
	<div class="form-group">
		<?php $error = errorField($errors, 'releaseDate'); ?>
		<label for="title">Date de sortie</label>
		<input type="text" class="form-control<?= $error['class']; ?>" value="<?= valueField('releaseDate'); ?>" id="releaseDate" name="releaseDate">
		<?= $error['message']; ?>
	</div>
	<div class="form-group">
		<?php $error = errorField($errors, 'viewer'); ?>
		<label for="title">Nombre de spectateur</label>
		<input type="text" class="form-control<?= $error['class']; ?>" value="<?= valueField('viewer'); ?>" id="viewer" name="viewer">
		<?= $error['message']; ?>
	</div>
	<div>
		<input type="hidden" name="id" value="<?= getId(); ?>">
	</div>
	<div class="form-group">
		<input type="submit" value="Sauvegarder" class="btn btn-primary">
	</div>
</form>

<?php get_footer('admin'); ?>
