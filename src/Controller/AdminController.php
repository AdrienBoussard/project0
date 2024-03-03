<?php

namespace Project\Controller;

// Il y a deux types de $post[type] : 'post' et 'specialPost'. 'post' est un article qui peut se trouver dans la liste de publications, de sauvegardes ou dans la poubelle et peut être crée, modifié ou supprimé. 'specialPost' contient les status suivants :'legalNotice' et 'contact' ; chaque élément présente une page avec le sujet approprié avec leur status et ne peuvent être que modifié. 'post' et 'specialPost' utilisent un éditeur différent.

class AdminController {

	private $postManager;
	private $commentManager;
	private $accountManager;

	public function __construct() {
		$this->postManager = new \Project\Model\PostManager();
		$this->commentManager = new \Project\Model\CommentManager();
		$this->accountManager = new \Project\Model\AccountManager();
	}

	private function verifyAdmin() {
		if (!isset($_SESSION['statusAccount']) || $_SESSION['statusAccount'] !== 'admin') {
			throw new \Exception("Erreur : Action non autorisé");
		}
	}

	public function getEditPost() {
		$this->verifyAdmin();
		$active = $_GET['action'];
		if(isset($_GET['id'])) {
			$post = $this->postManager->getPost($_GET['id']);
			if ($post['type'] == 'post') {
				require('../src/View/editView.php');
			}
			else {
				throw new \Exception("Erreur : Billet non modifiable");
			}
		}
		else {
			throw new \Exception("Erreur : Paramètre absent");
		}
	}
	public function discardPost() {
		$this->verifyAdmin();
		if(isset($_GET['id'])) {
			$post = $this->postManager->getPost($_GET['id']);
			if ($post['type'] == 'post') {
				if (isset($_GET['list']) && isset($_GET['page'])) {
					$list = $_GET['list'];
					$page = $_GET['page'];
					$this->postManager->discardPost($_GET['id']);
					header("Location: ?action=$list&page=$page");
				}
				else {
					$this->postManager->discardPost($_GET['id']);
					header("Location: ?action=home");		
				}
			}
			else {
				throw new \Exception("Erreur : Billet non modifiable");
			}
		}
		else {
			throw new \Exception("Erreur : Paramètre absent");
		}
	}

	private function showListPosts($list, $status, $page) {
		$after = ($page - 1) * 9;

		$posts = $this->postManager->getAllPostsbyPage($status, $after);
		$count = $this->postManager->countAllPosts($status);	
		
		$pages = ($count[0] / 9) + 1;
		$active = $status;	
		require('../src/View/listPostsView.php');
	}
	public function showDrafts() {
		$this->verifyAdmin();
		if(isset($_GET['page'])) {
			$this->showListPosts("drafts", "saved", $_GET['page']);
		}
		else {
			throw new \Exception("Erreur : Paramètres absents");
		}
	}
	public function showTrash() {
		$this->verifyAdmin();
		if(isset($_GET['page'])) {
			$this->showListPosts("trash", "discarded", $_GET['page']);
		}
		else {
			throw new \Exception("Erreur : Paramètres absents");
		}
	}
	
	public function banAccount() {
		$this->verifyAdmin();
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
			$this->changeStatusAccount($id, "banned");
			header("Location: ?action=member&id=$id");
		}
		else {
			throw new \Exception("Erreur : Paramètre absent.");
		}
	}
	public function debanAccount() {
		$this->verifyAdmin();
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
			$this->changeStatusAccount($id, "member");
			header("Location: ?action=member&id=$id");
		}
		else {
			throw new \Exception("Erreur : Paramètre absent.");
		}
	}
	private function changeStatusAccount($id, $status) {
		$account = $this->accountManager->getAccountById($id);
		if (isset($_SESSION['idAccount']) && $_SESSION['idAccount'] !== $account['ID']) {
			$this->accountManager->changeStatusAccount($id, $status);
		}
		else {
			throw new \Exception("Erreur : Action non autorisé");
		}
	}

	public function showEdit() {
		$this->verifyAdmin();
		$active = $_GET['action'];
		require('../src/View/editView.php');
	}
	public function editPost() {
		$this->verifyAdmin();
		if (isset($_POST['status']) && isset($_POST['title']) && isset($_POST['content'])) {

			$title = htmlspecialchars($_POST['title']);

			// Modifie le billet si l'identifiant existe déja ou sinon crée un nouveau.
			if (isset($_GET['id'])) {
				$post = $this->postManager->getPost($_GET['id']);
				if ($post['type'] == 'post') {
					$this->postManager->updatePost($_GET['id'], $_POST['status'], $title, $_POST['content']);
				}
				else {
					throw new \Exception("Erreur : Billet non modifiable");
				}
			}
			else {
				$this->postManager->createPost($_POST['status'], $title, $_POST['content']);
			}	

			// Si le billet est publié, l'administrateur est redirigé dessus sinon il reste sur la page d'édition. 
			if ($_POST['status'] == 'posted') {
				if (isset($_GET['id'])) {
					$id = $_GET['id'];
				}
				else {
					$post = $this->postManager->getLastPost();
					$id = $post['ID'];
				}
					header("Location:?action=post&id=$id");
			}
			elseif ($_POST['status'] == 'discarded') {
				header("Location:?action=edit");
			}
			else {
				if (isset($_GET['id'])) {
					$id = $_GET['id'];
				}
				else {
					$post = $this->postManager->getLastPost();
					$id = $post['ID'];
				}
				header("Location:?action=getEditPost&id=$id");
			}

		}
		else {
			throw new \Exception("Erreur : Paramètres absents");
		}
	}
	public function deletePost() {
		$this->verifyAdmin();
		if(isset($_GET['id'])) {
			$post = $this->postManager->getPost($_GET['id']);
			// Si il supprime le billet à partir d'une liste de billets l'administrateur est redirigé dessus sinon il se retrouve à la page d'accueil.
			if ($post['type'] == 'post') {
				if (isset($_GET['list']) && isset($_GET['page'])) {
					$list = $_GET['list'];
					$page = $_GET['page'];
					$this->postManager->deletePost($_GET['id']);
					$this->commentManager->deleteCommentsPost($_GET['id']);
					header("Location: ?action=$list&page=$page");
				}
				else {
					$this->postManager->deletePost($_GET['id']);
					$this->commentManager->deleteCommentsPost($_GET['id']);
					header("Location: ?action=home");		
				}
			}
			else {
				throw new \Exception("Erreur : Billet non modifiable");
			}
		}
		else {
			throw new \Exception("Erreur : Paramètre absent");
		}
	}
	public function showSpecialEdit() {
		$this->verifyAdmin();
		$active = $_GET['action'];
		if (isset($_GET['status']) && ($_GET['status'] == 'contact' || $_GET['status'] == 'legalNotice')) {
			$post = $this->postManager->getSpecialPost($_GET['status']);
			require('../src/View/specialEditView.php');
		}
		else {
			throw new \Exception("Erreur : Paramètre non valide");
		}
	}
	public function updateSpecialPost() {
		$this->verifyAdmin();
		if (isset($_POST['content']) && isset($_GET['status'])) {
			$this->postManager->updateSpecialPost($_POST['content'], $_GET['status']);
			if ($_GET['status'] == 'legalNotice') {
				header("Location:?action=legalNotice");
			}
			else {
				header("Location:?action=contact");
			}
		}
		else {
			throw new \Exception("Erreur : Paramètres absents");
		}
	}
	public function showListMembers() {
		$this->verifyAdmin();
		$active = $_GET['action'];
		if (isset($_GET['status']) && $_GET['status'] == 'banned') {
			$accounts = $this->accountManager->getAccountsbyStatus($_GET['status']);
			require('../src/View/listMembersView.php');
		}
		else {
			$accounts = $this->accountManager->getAllAccounts();
			require('../src/View/listMembersView.php');
		}
	}
	public function showListComments() {
		$this->verifyAdmin();
		$active = $_GET['action'];
		if (isset($_GET['status'] )&& $_GET['status'] == 'reported') {
			$comments = $this->commentManager->getCommentsbyStatus($_GET['status']);
			require('../src/View/listCommentsView.php');
		}
		else {
			$comments = $this->commentManager->getAllComments();
			require('../src/View/listCommentsView.php');
		}
	}
	public function approveComment() {
		$this->verifyAdmin();
		if ($_GET['id']) {
			$comment = $this->commentManager->getComment($_GET['id']);
			if (($comment['status'] == 'posted' || $comment['status'] == 'reported') && $comment['status_account'] !== 'admin') {
				$this->commentManager->changeStatusComment($_GET['id'], "approved");
			}
			else {
				throw new \Exception("Erreur : Commentaire non approuvable");
			}
		}
		else {
			throw new \Exception("Erreur : Paramètre absent");
		}
	}
}