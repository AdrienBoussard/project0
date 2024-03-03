<?php

namespace Project\Model;

class CommentManager extends Manager {
	public function getComment($id) {
		$bdd = $this->dbConnect();
        $req = $bdd->prepare("SELECT * FROM comments WHERE ID = ?");
        $req->execute(array($id));
        $comment = $req->fetch();
        return $comment;
	}
	public function getCommentsbyPost($id) {
		$bdd = $this->dbConnect();
        $req = $bdd->prepare("SELECT * FROM comments WHERE ID_post = ? ORDER BY date");
        $req->execute(array($id));
        return $req;
	}
	public function getCommentsbyAccount($id) {
		$bdd = $this->dbConnect();
        $req = $bdd->prepare("SELECT * FROM comments WHERE ID_account = ? ORDER BY date");
        $req->execute(array($id));
        return $req;
	}
	public function changeStatusComment($id, $status) {
		$bdd = $this->dbConnect();
        $req = $bdd->prepare("UPDATE comments SET status = :status WHERE ID = :id");
        $req->execute(array(
        	'id' => $id,
			'status' => $status,
        ));
	}
	public function addComment($id, $idAccount, $pseudo, $statusAccount, $content) {
		$bdd = $this->dbConnect();
        $req = $bdd->prepare("INSERT INTO comments(ID_account, ID_post, pseudo, status, status_account, content, date) 
        VALUES(:idAccount, :idPost, :pseudo, 'posted', :statusAccount, :content, CURDATE())");
        $req->execute(array(
			'idAccount' => $idAccount,
			'idPost' => $id,
			'pseudo' => $pseudo,
			'statusAccount' => $statusAccount,
			'content' => $content,
			));
	}
	public function deleteComment() {
		$bdd = $this->dbConnect();
        $req = $bdd->prepare("DELETE FROM comments WHERE ID = ?");
        $req->execute(array($_GET['id']));
	}
	public function deleteCommentsPost($id) {
		$bdd = $this->dbConnect();
        $req = $bdd->prepare("DELETE FROM comments WHERE ID_post = ?");
        $req->execute(array($id));
	}
	public function getAllComments() {
		$bdd = $this->dbConnect();
        $req = $bdd->query("SELECT * FROM comments ORDER BY date");
        return $req;
	}
	public function getCommentsbyStatus($status) {
		$bdd = $this->dbConnect();
        $req = $bdd->prepare("SELECT * FROM comments WHERE status = ? ORDER BY date");
        $req->execute(array($status));
        return $req;
	}
	public function deleteAccountComments($id) {
		$bdd = $this->dbConnect();
        $req = $bdd->prepare("DELETE FROM comments WHERE ID_account = ?");
        $req->execute(array($id));
	}
}