<?php ob_start(); ?>

<section class="container">

	<div class="col">
		<form action="?action=editPost<?php echo isset($_GET['id']) ? '&id=' . $_GET['id'] : ""; ?>" method="post" enctype="multipart/form-data">
			<!-- Catégories -->
			<div class="flex-container edit-menu">
			<a href="?action=edit" class="button <?= $active == "edit" ? "active-button" : ""; ?>" >Création</a>
			<a href="?action=drafts&category=all&page=1" class="button">Brouillons</a>
			<a href="?action=trash&category=all&page=1" class="button">Corbeille</a>
			</div>
			<!-- Création -->
			<div class="top-margin">
				<input type="text" name="title" class="form-control col" placeholder="Titre" 
				value="<?php echo isset($post['title']) ? htmlspecialchars($post['title']) : ""; ?>" required>
			</div>

			<div class="form-group edit">
				<textarea name="content" class="form-control" id="creation" rows="25" id="comment">
				<?php echo isset($post['content']) ? ($post['content']) : ""; ?></textarea>
			</div>
			<!-- Actions -->
			<div class="flex-container">
			<button type="submit" name="status" value="posted"class="button">Publier</button>
			<button type="submit" name="status" value="saved" class="button">Sauvegarder</button>
			<button type="submit" name="status" value="discarded" class="button">Supprimer</button>
			</div>
			
		</form>
	</div>
	
</section>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>