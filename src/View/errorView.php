<?php ob_start(); ?>

<div class="container mini-width">
	<div class="flex-container error-message"><h2><?= $errorMessage ?></h2></div>
	<div class="flex-container"><a href="?action=home" class="button">Retour accueil</a></div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>