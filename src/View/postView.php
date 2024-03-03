<?php ob_start(); ?>

<section class="container">
	<div class="col">
		<!-- Article -->
		<article class="row">
		<h2 class="post-title"><?= htmlspecialchars($post['title']); ?></h2>
		<div class="post-text"><?= $post['content']; ?></div>

			<div class="inline-container">

				<p class="date"><?= $post['date']; ?></p>

				<?php if(isset($_SESSION['statusAccount']) && ($_SESSION['statusAccount'] == 'admin')): ?>

					<a class="link-post" href="?action=getEditPost&id=<?=$post['ID']; ?>">Modifier</a>

					<?php if($status == "discarded"): ?>
						<a class="link-post confirm" href="?action=deletePost&token=<?=$_SESSION['token']; ?>&id=<?=$post['ID']; ?>">Supprimer</a>

					<?php else : ?>

						<a class="link-post confirm" href="?action=discardPost&token=<?=$_SESSION['token']; ?>&id=<?=$post['ID']; ?>">Supprimer</a>
					<?php endif; ?>

				<?php endif; ?>			
			</div>
		</article>
		<!-- Commenter -->
		<?php if(isset($_SESSION['statusAccount']) && ($_SESSION['statusAccount'] == 'admin' || 'member')): ?>
			<form action="?action=addComment&id=<?=$post['ID']; ?>&status=<?=$status ; ?>" method="post">
				<div class="form-group"><textarea name="content" class="form-control" rows="5" id="comment" required></textarea></div>
				<div class="flex-container"><button type="submit" class="button">Commenter</button></div>
			</form>
		<?php else : ?>
			<p class="flex-container">Inscrivez-vous pour commenter</p>
			  <div class="flex-container">
			  	<a href="?action=register" class="button">Inscription</a>
			  </div>
		<?php endif; ?>
		<!-- Commentaires -->
		<?php while ($data = $comments->fetch()) : ?>
			<article class="col top-border" id="<?= $data['ID']; ?>">
				<div class="inline-container">
					<a class="link-post" href="?action=member&id=<?=$data['ID_account']; ?>"><h3><?= htmlspecialchars($data['pseudo']); ?></h3></a>
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
						<div class="link-post delete confirm" data-token="<?= $_SESSION['token']; ?>" data-id="<?= $data['ID']; ?>">Supprimer</div>

					<?php elseif($data['status'] == 'posted' && $data['status_account'] !== 'admin'): ?>
						<div class="link-post report feedback" data-id="<?= $data['ID']; ?>">Signaler</div>
					<?php endif; ?>

				</div>
			</article>
		<?php endwhile; ?>
	</div>
</section>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>