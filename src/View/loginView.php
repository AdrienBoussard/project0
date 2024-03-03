<?php ob_start(); ?>

<section class="container mini-width">

	<form action="?action=loginAccount" method="post"> 

    <?php if(isset($message)): ?>
    	<div class="alert alert-primary" role="alert"><?= $message ?></div>
    <?php endif; ?>

    <?php if(isset($alert)): ?>
    	<div class="alert alert-danger" role="alert"><?= $alert ?></div>
    <?php endif; ?>

 	<div class="form-group">
    	<label for="pseudo">Pseudonyme</label>
    	<input type="text" name="pseudo" class="form-control" id="pseudo" placeholder="Pseudonyme" 
    	value="<?php echo isset($pseudo) ? htmlspecialchars($pseudo) : ""; ?>" required>

    	<label for="password">Mot de passe</label>
   		<input type="password" name="password" class="form-control" id="password" placeholder="Mot de passe" required>
  	</div>

  	<div class="flex-container"><button type="submit" class="button">Connexion</button></div>

	</form>

</section>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>