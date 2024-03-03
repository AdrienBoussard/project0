<?php ob_start(); ?>

<section class="container">
	<div class="col">

  		<h2 class="post-title"><?= htmlspecialchars($member['pseudo']); ?></h2>

  		<?php if (isset($_SESSION['statusAccount']) && $_SESSION['statusAccount'] == 'admin' && $member['status'] == 'member'): ?>
			<div class="flex-container"><a class="button confirm" href="?action=banAccount&token=<?=$_SESSION['token']; ?>
			&id=<?=$member['ID']; ?>">Bannir</a></div>

		<?php elseif (isset($_SESSION['statusAccount']) && $_SESSION['statusAccount'] == 'admin' && $member['status'] == 'banned'): ?>
			<div class="flex-container"><a class="button confirm" href="?action=debanAccount&token=<?=$_SESSION['token']; ?>
			&id=<?=$member['ID']; ?>">Débannir</a></div>
		<?php endif; ?>

		<?php while ($data = $comments->fetch()) : ?>
			<article class="col top-border" id="<?= $data['ID']; ?>">

				<p class="content top-margin"><?= htmlspecialchars($data['content']); ?></p>
				<p class="date"><?= $data['date']; ?></p>
				
				<div class="inline-container">

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