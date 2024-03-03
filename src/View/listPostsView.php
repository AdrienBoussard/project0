<?php ob_start(); ?>

<section>
	<div class="container">
	<!-- Menu administrateur -->
		<?php if(isset($_SESSION['statusAccount']) && ($_SESSION['statusAccount'] == 'admin') && ($list == "drafts" || $list == "trash")): ?>
		<div class="flex-container edit-menu">
			<a href="?action=edit" class="button" >Création</a>
			<a href="?action=drafts&category=all&page=1" class="button <?= $active == "saved" ? "active-button" : ""; ?>" >Brouillons</a>
			<a href="?action=trash&category=all&page=1" class="button <?= $active == "discarded" ? "active-button" : ""; ?>">Corbeille</a>
		</div>
		<?php endif; ?>
		<!-- Billets -->
		<div id="remove-first-border"></div>
		<?php while ($data = $posts->fetch()) : ?>

		<article class="col top-border">

			<h2 class="post-title"><?= htmlspecialchars($data['title']); ?></h2>
			

			<div class="post-text"><?= $data['content']; ?></div>

					<div class="inline-container">

					<a class="link-post" href="?action=post&id=<?=$data['ID']; ?>">Commentaires</a>

						<?php if(isset($_SESSION['statusAccount']) && ($_SESSION['statusAccount'] == 'admin')): ?>
						<a class="link-post" href="?action=getEditPost&id=<?=$data['ID']; ?>">Modifier</a>

							<?php if($list == "trash"): ?>

						<a class="link-post confirm" href="?action=deletePost&token=<?=$_SESSION['token']; ?>
						&id=<?=$data['ID']; ?>&list=<?=$list; ?>&page=<?=$page; ?>">Supprimer</a>

							<?php else : ?>

						<a class="link-post confirm" href="?action=discardPost&token=<?=$_SESSION['token']; ?>
						&id=<?=$data['ID']; ?>&list=<?=$list; ?>&page=<?=$page; ?>">Supprimer</a>

							<?php endif; ?>
		
						<?php endif; ?>
					
					</div>

		</article>

   	<?php endwhile; ?>
	   
	</div>
	<!-- Pages -->
	<form method="get" class='row options'>
		<input type="hidden" name="action" value="<?= $list; ?>">
		<select name="page">
       		<?php for ($i = 1; $i <= $pages; $i++): ?>
       			<option value="<?= $i; ?>" <?= $page == $i ? "selected" : ""; ?>>Page <?= $i ?></option>
       		<?php endfor; ?>
       	</select>
	</form>

</section>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>