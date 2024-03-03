<?php ob_start(); ?>

<section class="container">
	<div class="col">
		<article class="row special-post">
			<div class="post-text"><?= ($post['content']); ?></div>

			<?php if(isset($_SESSION['statusAccount']) && ($_SESSION['statusAccount'] == 'admin')): ?>
				<a class="link" href="?action=editSpecial&status=legalNotice">Modifier</a>
			<?php endif; ?>
			
		</article>
	</div>  
</section>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>