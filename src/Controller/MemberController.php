<?php

namespace Project\Controller;

class MemberController {

    private $postManager;
    private $commentManager;
    private $accountManager;

    public function __construct() {
        $this->postManager = new \Project\Model\PostManager();
        $this->commentManager = new \Project\Model\CommentManager();
        $this->accountManager = new \Project\Model\AccountManager();
    }

    public function addComment() {
    	if (isset($_GET['id']) && isset($_SESSION['idAccount']) && isset($_SESSION['pseudoAccount']) 
        && isset($_SESSION['statusAccount']) && isset($_POST['content'])) {
    	$id = $_GET['id'];
        $status = $_GET['status'];
        $content = htmlspecialchars($_POST['content']);
        $post = $this->commentManager->addComment($id, $_SESSION['idAccount'], $_SESSION['pseudoAccount'], $_SESSION['statusAccount'], $content);
        header("Location:?action=post&id=$id&status=$status");
		}
		else {
			throw new \Exception("Erreur : Paramètres absents");
		}
    }
    public function deleteComment() {
    	if (isset($_GET['id'])) {
    		$id = $_GET['id'];
	    	$comment = $this->commentManager->getComment($id);
	        if ($comment['ID_account'] == $_SESSION['idAccount'] || $_SESSION['statusAccount'] == 'admin') {
	            $this->commentManager->deleteComment();
	        }
	        else {
	            throw new \Exception("Erreur : Action non autorisé");
	        }
		}
		else {
			throw new \Exception("Erreur : Paramètre absent");
		}
    }

    private function verifyPseudo($pseudo) {
        $sizePseudo = strlen($pseudo);
        $existPseudo = $this->accountManager->checkPseudo($pseudo);
        if (($sizePseudo < 3) || ($sizePseudo > 20)) {        
            return array(
                'alert' => "Le pseudonyme doit être entre 3 et 20 caractères.",
                'check' => false,
            );
        }
        elseif ($existPseudo) {
            return array(
                'alert' => "Le pseudonyme est déjà utilisé.",
                'check' => false,
            );
        }
        else {
            return array(
                'check' => true,
            );
        }
    }
    private function verifyEmail($email, $confirmEmail) {
        $existEmail = $this->accountManager->checkEmail($email, $confirmEmail);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !filter_var($confirmEmail, FILTER_VALIDATE_EMAIL)) { 
            return array(
                'alert' => "L'adresse e-mail n'est pas valide.",
                'check' => false,
            );
        }
        elseif ($email !== $confirmEmail) {
            return array(
                'alert' => "Les adresse e-mail ne correspondent pas.",
                'check' => false,
            );
        }
        elseif ($existEmail) {
            return array(
                'alert' => "L'adresse e-mail est déjà utilisé.",
                'check' => false,
            );
        }
        else { 
            return array(
                'check' => true,
            );
        }
    }
    private function verifyPassword($password, $confirmPassword) {       
        $sizePassword = strlen($password);
        if (($sizePassword < 8) || ($sizePassword > 25)) {
            return array(
            'alert' => "Le mot de passe doit être entre 8 et 25 caractères.",
            'check' => false,
            ); 
        }
        elseif ($password !== $confirmPassword) {
            return array(
                'alert' => "Les mots de passe ne correspondent pas.",
                'check' => false,
            );
        }
        else {
            return array(
                'check' => true,
            );
        }
    }

	public function registerAccount() {
        if (isset($_POST['pseudo']) && isset($_POST['email']) && isset($_POST['confirmEmail']) 
        && isset($_POST['password']) && isset($_POST['confirmPassword'])) {

            $pseudo = htmlspecialchars($_POST['pseudo']);
            $email = htmlspecialchars($_POST['email']);
            $confirmEmail = htmlspecialchars($_POST['confirmEmail']);
            $password = htmlspecialchars($_POST['password']);
            $confirmPassword = htmlspecialchars($_POST['confirmPassword']);

            $checkPseudo = $this->verifyPseudo($pseudo);
            $checkEmail = $this->verifyEmail($email, $confirmEmail);
            $checkPassword = $this->verifyPassword($password, $confirmPassword);

            if (($checkPseudo['check'] == true) && ($checkEmail['check'] == true) && ($checkPassword['check'] == true)) {
                $hashPassword = password_hash($password, PASSWORD_DEFAULT);
                $this->accountManager->signUpAccount($pseudo, $email, $hashPassword);
                $message = "Votre inscription a bien été enregistrée.";
                $active = "login";
                require('../src/View/loginView.php');
            }
            else {
                $active = "register";
                require('../src/View/registerView.php');
            }

        }
        else {
            throw new \Exception("Erreur : Paramètres absent");
        }

	}

    public function loginAccount() {
        if (isset($_POST['pseudo']) && isset($_POST['password'])) {
            $active = "login";
            $pseudo = htmlspecialchars($_POST['pseudo']);
            $password = htmlspecialchars($_POST['password']);

            $existPseudo = $this->accountManager->checkPseudo($pseudo);
            if (!$existPseudo) {
                $alert = "Le pseudonyme ou mot de passe est incorrect.";
                require('../src/View/loginView.php');
            }
            else {
                $data = $this->accountManager->getAccountByPseudo($pseudo);
                $passwordVerify = password_verify($password, $data['password']);

                if($passwordVerify) {            
                    if ($data['status'] != 'banned') {
                        $token = bin2hex(openssl_random_pseudo_bytes(8));
                        $_SESSION['token'] = $token;
                        $_SESSION['idAccount'] = $data['ID'];
                        $_SESSION['statusAccount'] = $data['status'];
                        $_SESSION['pseudoAccount'] = $data['pseudo'];
                        $_SESSION['emailAccount'] = $data['email'];
                        header('Location:?action=home');
                    }
                    else {
                        $alert = "Connexion refusé. Le compte a été banni.";
                        require('../src/View/loginView.php');
                    }
                }
                else {
                    $alert = "Le pseudonyme ou mot de passe est incorrect.";
                    require('../src/View/loginView.php');
                }
            }
        }
        else {
            throw new \Exception("Erreur : Paramètres absent");
         }
    }

    public function showAccount() {
        $active = $_GET['action'];
        require('../src/View/accountView.php');
    }
    public function updateEmail() {
        if (isset($_POST['email']) && isset($_POST['confirmEmail'])) {
            $active = "account";
            $email = htmlspecialchars($_POST['email']);
            $confirmEmail = htmlspecialchars($_POST['confirmEmail']);
            $checkEmail = $this->verifyEmail($email, $confirmEmail);

            if ($checkEmail['check'] == true) {
                $this->accountManager->updateEmail($email, $_SESSION['idAccount']);
                $_SESSION['emailAccount'] = $email;
                $messageEmail = "Votre changement d'email a bien été enregistrée.";
                require('../src/View/accountView.php');
            }
            else {
                require('../src/View/accountView.php');
            }     
        }
        else {
            throw new \Exception("Erreur : Paramètres absent");
        }
    }
    public function updatePassword() {
        if (isset($_POST['password']) && isset($_POST['confirmPassword'])) {
            $active = "account";
            $password = htmlspecialchars($_POST['password']);
            $confirmPassword = htmlspecialchars($_POST['confirmPassword']);
            $checkPassword = $this->verifyPassword($password, $confirmPassword);

            if ($checkPassword['check'] == true) {
                $hashPassword = password_hash($password, PASSWORD_DEFAULT);
                $this->accountManager->updatePassword($hashPassword, $_SESSION['idAccount']);
                $messagePassword = "Votre changement de mot de passe a bien été enregistrée.";
                require('../src/View/accountView.php');
            }
            else {
                require('../src/View/accountView.php');
            }          
        }
        else {
            throw new \Exception("Erreur : Paramètres absent");
        }
    }
    
    public function logout() {  
        unset ($_SESSION['token'], $_SESSION['idAccount'], $_SESSION['statusAccount'], $_SESSION['pseudoAccount'], $_SESSION['emailAccount']);   
        session_destroy();   
        header('Location:?action=home');   
    }
}