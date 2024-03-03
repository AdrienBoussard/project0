<?php ob_start(); ?>

<section class="container mini-width">

    <h2>Pseudonyme</h2>
    <h3><?= $_SESSION['pseudoAccount'] ?></h3>
    <h2>Adresse e-mail</h2>
    <h3><?= $_SESSION['emailAccount'] ?></h3>
    <!-- Changement d'adresse e-mail -->
    <form action="?action=updateEmail" method="post">
        <div class="form-group">
            <label for="email">Nouvelle adresse e-mail</label>
            <input type="text" name="email" class="form-control" id="email" placeholder="Adresse e-mail" 
            value="<?php echo isset($email) ? $email : ""; ?>" required>
            <label for="confirm-email">Confirmation de la nouvelle adresse e-mail</label>
            <input type="text" name="confirmEmail" class="form-control" id="confirm-email" placeholder="Adresse e-mail" 
            value="<?php echo isset($confirmEmail) ? $confirmEmail : ""; ?>" required>
        </div>
        <div class="flex-container"><button type="submit" class="button">Changer d'adresse e-mail</button></div>
    </form>
    
    <?php if(isset($messageEmail)): ?>
        <div class="alert alert-primary" role="alert"><?= htmlspecialchars($messageEmail) ?></div>
    <?php endif; ?>
    <?php if(isset($checkEmail['alert'])): ?>
        <div class="alert alert-danger" role="alert"><?= htmlspecialchars($checkEmail['alert']) ?></div>
    <?php endif; ?>
    <!-- Changement de mot de passe -->
    <form action="?action=updatePassword" method="post">
        <div class="form-group">
            <label for="password">Nouveau mot de passe</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Mot de passe" required>
            <label for="confirm-password">Confirmation du nouveau mot de passe</label>
            <input type="password" name="confirmPassword" class="form-control" id="confirm-password" placeholder="Mot de passe" required>
        </div>
        <div class="flex-container">
            <button type="submit" class="button">Changer de mot de passe</button>
        </div>
    </form>

    <?php if(isset($checkPassword['alert'])): ?>
        <div class="alert alert-danger" role="alert"><?= htmlspecialchars($checkPassword['alert']) ?></div>
    <?php endif; ?>
    <?php if(isset($messagePassword)): ?>
        <div class="alert alert-primary" role="alert"><?= htmlspecialchars($messagePassword) ?></div>
    <?php endif; ?>

</section>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>