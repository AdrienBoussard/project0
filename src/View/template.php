<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- API d'un éditeur WYSIWYG. -->
    <script src="https://cdn.tiny.cloud/1/zqtc6uz9r6cfc6cj3z36vdtltnifwl20oy2gryskc91ckih4/tinymce/5/tinymce.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css"/>

    <title>Lorem Ipsum</title>
    <meta name="description" content="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."/>
    <meta property="og:title" content="Lorem Ipsum"/>
    <meta property="og:description" content="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."/>
    <meta property="og:type" content="website"/>    
    <meta property="og:url" content="http://adrien-boussard.com/project0"/>
  </head>
  
  <body>
    <header class="navbar navbar-expand-lg navbar-light">
      
        <a class="navbar-brand" href="?action=posts&category=all&page=1"><h1>Lorem Ipsum</h1></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu" aria-controls="menu" 
        aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

        <nav class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ml-auto">
                 <li><a class="menu-link <?= $active == "posted" ? "active" : ""; ?>" href="?action=posts&category=all&page=1">Billets</a></li>
              
                <?php if(isset($_SESSION['statusAccount']) && ($_SESSION['statusAccount'] == 'member')): ?>
                    <li><a class="menu-link <?= $active == "account" ? "active" : ""; ?>" href="?action=account">Paramètres</a></li>
                    <li><a class="menu-link" href="?action=logout&token=<?=$_SESSION['token']; ?>">Déconnexion</a></li>
              
                <?php elseif(isset($_SESSION['statusAccount']) && ($_SESSION['statusAccount'] == 'admin')): ?>
                    <li class="dropdown-submenu">
                    <a href="#" class="dropdown-toggle menu-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <span class="nav-label">Paramètres</span></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a class="menu-link <?= $active == "account" ? "active" : ""; ?>" href="?action=account">Compte</a></li>
                            <li><a class="menu-link <?= $active == "edit" ? "active" : ""; ?>" href="?action=edit">Édition</a></li>
                            <li><a class="menu-link <?= $active == "listMembers" ? "active" : ""; ?>" href="?action=listMembers">Utilisateurs</a></li>
                            <li><a class="menu-link <?= $active == "listComments" ? "active" : ""; ?>" href="?action=listComments">Commentaires</a></li>
                        </ul>
                    </li>
                    <li><a class="menu-link" href="?action=logout&token=<?=$_SESSION['token']; ?>">Déconnexion</a></li>
                  
                <?php else : ?>
                    <li><a class="menu-link <?= $active == "login" ? "active" : ""; ?>" href="?action=login">Connexion</a></li>
                    <li><a class="menu-link <?= $active == "register" ? "active" : ""; ?>" href="?action=register">Inscription</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <section id="content"><?= $content ?></section>

    <footer id="footer">
    <a class="footer-link <?= $active == "legalNotice" ? "active" : ""; ?>" href="?action=legalNotice">Mentions légales</a>
    <a class="footer-link <?= $active == "contact" ? "active" : ""; ?>" href="?action=contact">Nous contacter</a>
    </footer>

    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" 
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" 
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="js/app.js"></script>
  </body>
</html>