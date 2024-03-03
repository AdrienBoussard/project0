<?php ob_start(); ?>

<section class="container">
	<div class="col">

  		<div class="flex-container">
  			<?php if (isset($_GET['status'])): ?>
  				<a href="?action=listComments"><button type="button" class="button">Voir tous</button></a>
  			<?php else : ?>
  				<a href="?action=listComments&status=reported"><button type="button" class="button moderation-button">Voir signalés</button></a>
  			<?php endif; ?>
  		</div>

		<?php while ($data = $comments->fetch()) : ?>
			<article class="col top-border" id="<?= $data['ID']; ?>">
				<div class="inline-container top-margin">
					<a class="link" href="?action=member&id=<?=$data['ID_account']; ?>"><h3><?= htmlspecialchars($data['pseudo']); ?></h3></a>
				</div>

				<p class="content"><?= htmlspecialchars($data['content']); ?></p>

				
				<div class="inline-container">

					<p class="date"><?= $data['date']; ?></p>

					<?php if($data['status'] !== 'approved' && $data['status_account'] !== 'admin' 
					&& isset($_SESSION['statusAccount']) && $_SESSION['statusAccount'] == 'admin'): ?>
						<div class="link-post approve" data-token="<?= $_SESSION['token']; ?>" data-id="<?= $data['ID']; ?>">Approuver</div>
					<?php endif; ?>

					<?php if((isset($_SESSION['idAccount']) && ($_SESSION['idAccount'] == $data['ID_account'])) || 
					(isset($_SESSION['statusAccount']) && ($_SESSION['statusAccount'] == 'admin'))): ?>
						<div class="link-post delete" data-token="<?= $_SESSION['token']; ?>" data-id="<?= $data['ID']; ?>">Supprimer</div>

					<?php elseif($data['status'] == 'posted' && $data['status_account'] !== 'admin'): ?>
						<div class="link-post report" data-id="<?= $data['ID']; ?>">Signaler</div>
					<?php endif; ?>

				</div>
			</article>
		<?php endwhile; ?>

	</div>
</section>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>