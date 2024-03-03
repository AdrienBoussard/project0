<?php

namespace Project;

class Router {

	private $visitorController;
	private $memberController;
	private $adminController;
	private $routes = array();
    
    public function __construct() {
    	$this->visitorController = new \Project\Controller\VisitorController();
		$this->memberController = new \Project\Controller\MemberController();
		$this->adminController = new \Project\Controller\AdminController();
    	$this->createRoutes();
    }

	private function addRoute($action, $controller, $function, $token) {
		$this->routes[] = array(
			'action' => $action,
    		'controller' => $controller,
    		'function' => $function,
    		'token' => $token,    		
		);
	}

	private function createRoutes() {
		$this->addRoute('home', $this->visitorController, 'showHome', false);
    	$this->addRoute('posts', $this->visitorController, 'showPosts', false);
    	$this->addRoute('drafts', $this->adminController, 'showDrafts', false);
    	$this->addRoute('trash', $this->adminController, 'showTrash', false);
    	$this->addRoute('login', $this->visitorController, 'showLogin', false);
    	$this->addRoute('register', $this->visitorController, 'showRegister', false);
    	$this->addRoute('legalNotice', $this->visitorController, 'showLegalNotice', false);
    	$this->addRoute('contact', $this->visitorController, 'showContact', false);
    	$this->addRoute('account', $this->memberController, 'showAccount', false);
    	$this->addRoute('updateEmail', $this->memberController, 'updateEmail', false);
    	$this->addRoute('updatePassword', $this->memberController, 'updatePassword', false);
    	$this->addRoute('logout', $this->memberController, 'logout', true);
    	$this->addRoute('edit', $this->adminController, 'showEdit', false);
    	$this->addRoute('listMembers', $this->adminController, 'showListMembers', false);
    	$this->addRoute('listComments', $this->adminController, 'showListComments', false);
    	$this->addRoute('loginAccount', $this->memberController, 'loginAccount', false);
    	$this->addRoute('editSpecial', $this->adminController, 'showSpecialEdit', false);
    	$this->addRoute('updateSpecialPost', $this->adminController, 'updateSpecialPost', false);
    	$this->addRoute('member', $this->visitorController, 'showMember', false);
    	$this->addRoute('banAccount', $this->adminController, 'banAccount', true);
    	$this->addRoute('debanAccount', $this->adminController, 'debanAccount', true);
   		$this->addRoute('reportComment', $this->visitorController, 'reportComment', false);
    	$this->addRoute('addComment', $this->memberController, 'addComment', false);
    	$this->addRoute('deleteComment', $this->memberController, 'deleteComment', true);
    	$this->addRoute('approveComment', $this->adminController, 'approveComment', true);
    	$this->addRoute('editPost', $this->adminController, 'editPost', false);
    	$this->addRoute('registerAccount', $this->memberController, 'registerAccount', false);
    	$this->addRoute('post', $this->visitorController, 'showPost', false);
    	$this->addRoute('discardPost', $this->adminController, 'discardPost', true);
    	$this->addRoute('getEditPost', $this->adminController, 'getEditPost', false);
    	$this->addRoute('deletePost', $this->adminController, 'deletePost', true);
    }

	public function routerQuery() {
		try {
			if(isset($_GET['action'])) {
				$routeFound = false; 
				foreach($this->routes as $route) {
					if ($_GET['action'] == $route['action']) {
						if ($route['token'] == true) {
							if (isset($_GET['token']) && isset($_SESSION['token']) && $_GET['token'] == $_SESSION['token']) {
								$function = $route['function'];
								$route['controller']->$function();
								$routeFound = true;
								break;
							}
							else {
								throw new \Exception("Erreur : Token non valide");
							}
						}
						else {
							$function = $route['function'];
							$route['controller']->$function();
							$routeFound = true;
							break;
						}
					}
				}
				if ($routeFound == false) {
					throw new \Exception("Erreur : Action non valide");
				}					 
			}
			else {
				$this->visitorController->showHome();
			}
		} 
		catch (\Exception $e) {
				$active = NULL; // Variable qui permet de souligner le lien du menu où se trouve le visiteur si il existe.
				$errorMessage = $e->getMessage();
				require('View/errorView.php');
	    }
	}

}
