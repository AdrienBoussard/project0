<?php ob_start(); ?>

<section class="container">
	<div class="col">

  		<div class="flex-container">
  			<?php if (isset($_GET['status'])): ?>
  				<a href="?action=listMembers"><button type="button" class="button">Voir tous</button></a>
  			<?php else : ?>
  				<a href="?action=listMembers&status=banned"><button type="button" class="button moderation-button">Voir bannis</button></a>
  			<?php endif; ?>
  		</div>

		<?php while ($data = $accounts->fetch()) : ?>
			<article class="row top-border">
					<a class="title" href="?action=member&id=<?=$data['ID']; ?>"><h3 class="link"><?= htmlspecialchars($data['pseudo']); ?></h3></a>
					<h3 class="title"><?= htmlspecialchars($data['email']); ?></h3>
			</article>
		<?php endwhile; ?>
		
	</div>
</section>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>