<?php

namespace Project\Controller;

class VisitorController {

	private $postManager;
	private $commentManager;
	private $accountManager;

	public function __construct() {
		$this->postManager = new \Project\Model\PostManager();
		$this->commentManager = new \Project\Model\CommentManager();
		$this->accountManager = new \Project\Model\AccountManager();
	}

	public function showPosts() {
		if(isset($_GET['page'])) {
			$page = $_GET['page'];
			$after = ($page - 1) * 9;

			$posts = $this->postManager->getAllPostsbyPage("posted", $after);
			$count = $this->postManager->countAllPosts("posted");
			
			$pages = ($count[0] / 9) + 1;
			$list = "posts";
			$active = "posted";
			require('../src/View/listPostsView.php');
		}
		else {
			throw new \Exception("Erreur : Paramètres absents");
		}
	}

	public function showHome() {
		$page = 1;
		$after = ($page - 1) * 9;
		
		$posts = $this->postManager->getAllPostsbyPage("posted", $after);
		$count = $this->postManager->countAllPosts("posted");	
		
		$pages = ($count[0] / 9) + 1;
		$list = "posts";
		$active = "posted";
		require('../src/View/listPostsView.php');
	}

	public function showPost() {
		if (isset($_GET['id'])) {
			$check = $this->postManager->checkPost($_GET['id']);
			if ($check == "true") {
				$post = $this->postManager->getPost($_GET['id']);
				$status = $post['status'];
				if ($status == "posted" || (isset($_SESSION['statusAccount']) && ($_SESSION['statusAccount'] == 'admin'))) {
					$active = $_GET['action'];
					$comments = $this->commentManager->getCommentsbyPost($_GET['id']);
					if ($status == "posted") {
						$list = "posts";
					}
					elseif ($status == "saved") {
						$list = "drafts";
					}
					else {
						$list = "trash";
					}
					require('../src/View/postView.php');
				}
				else {
					throw new \Exception("Erreur : Le billet n'est pas accessible.");
				}		
			}
			else {
				throw new \Exception("Erreur : Le billet n'existe pas.");
			}
		}
		else {
			throw new \Exception("Erreur : Paramètre absent");
		}
	}

	public function reportComment() {
		if (isset($_GET['id'])) {
			$comment = $this->commentManager->getComment($_GET['id']);
			if ($comment['status'] == 'posted' && $comment['status_account'] !== 'admin') {
				$this->commentManager->changeStatusComment($_GET['id'], "reported");
			}
			else {
				throw new \Exception("Erreur : Action non autorisé");
			}
		}
		else {
			throw new \Exception("Erreur : Paramètre absent");
		}
	}
	
	public function showMember() {
		if (isset($_GET['id'])) {
			$active = $_GET['action'];
			$member = $this->accountManager->getAccountById($_GET['id']);
			$comments = $this->commentManager->getCommentsbyAccount($_GET['id']);
			require('../src/View/memberView.php');
		}
		else {
			throw new \Exception("Erreur : Paramètre absent");
		}
	}
	public function showLogin() {
		$active = $_GET['action'];
		require('../src/View/loginView.php');
	}
	public function showRegister() {
		$active = $_GET['action'];
		require('../src/View/registerView.php');
	}
	public function showlegalNotice() {
		$active = $_GET['action'];
		$post = $this->postManager->getSpecialPost('legalNotice');
		require('../src/View/legalNoticeView.php');
	}
	public function showContact() {
		$active = $_GET['action'];
		$post = $this->postManager->getSpecialPost('contact');
		require('../src/View/contactView.php');
	}
}