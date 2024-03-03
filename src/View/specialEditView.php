<?php ob_start(); ?>

<section class="container">
	<div class="col">
		<form action="?action=updateSpecialPost&status=<?= $_GET['status'] ?>" method="post">
			<div class="form-group specialEdit">
				<textarea name="content" class="form-control" id="creation" rows="25" id="comment">
				<?= $post['content'] ?></textarea>
			</div>

			<div class="flex-container">
			<button type="submit" name="action" class="button">Modifier</button>		
			</div>
		</form>
	</div>
</section>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>