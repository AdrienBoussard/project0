<section class="container mini-width">
	<!-- Utilise API 'random user generator' qui permet de choisir un pseudo aléatoire. -->
	<div class="flex-container"><button class="button random-name">Choisir pseudonyme</button></div> 
	<form action="?action=registerAccount" method="post">

	<div class="form-group">
		<label for="pseudo">Pseudonyme</label>
		<input type="text" name="pseudo" class="form-control test" id="pseudo" placeholder="Pseudonyme" 
		value="<?php echo isset($pseudo) ? htmlspecialchars($pseudo) : ""; ?>" required>

		<?php if(isset($checkPseudo['alert'])): ?>
			<div class="alert alert-danger" role="alert"><?= htmlspecialchars($checkPseudo['alert']) ?></div>
		<?php endif; ?>

		<label for="email">Adresse e-mail</label>
		<input type="text" name="email" class="form-control" id="email" placeholder="Adresse e-mail" 
		value="<?php echo isset($email) ? $email : ""; ?>" required>
      
      	<label for="confirm-email">Confirmation de l'adresse e-mail</label>
      	<input type="text" name="confirmEmail" class="form-control" id="confirm-email" placeholder="Confirmation de l'adresse e-mail" 
      	value="<?php echo isset($confirmEmail) ? $confirmEmail : ""; ?>" required>

		<?php if(isset($checkEmail['alert'])): ?>
			<div class="alert alert-danger" role="alert"><?= htmlspecialchars($checkEmail['alert']) ?></div>
		<?php endif; ?>

		<label for="password">Mot de passe (8 caractères minimun)</label>
		<input type="password" name="password" class="form-control" id="password" 
		placeholder="Mot de passe" required>

		<label for="confirm-password">Confirmation du mot de passe</label>
		<input type="password" name="confirmPassword" class="form-control" id="confirm-password" 
		placeholder="Confirmation du mot de passe" required>

		<?php if(isset($checkPassword['alert'])): ?>
			<div class="alert alert-danger" role="alert"><?= htmlspecialchars($checkPassword['alert']) ?></div>
		<?php endif; ?>
	</div>
      
      <div class="flex-container"><button type="submit" class="button">Inscription</button></div>
  </form>
</section>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>