<?php

namespace Project\Model;

class PostManager extends Manager {
	public function getSpecialPost($status) {
		$bdd = $this->dbConnect();
        $req = $bdd->prepare("SELECT * FROM posts WHERE status = ?");
        $req->execute(array($status));
        $data = $req->fetch();
        return $data;
	}
	public function updateSpecialPost($content, $status) {
		$bdd = $this->dbConnect();
        $req = $bdd->prepare("UPDATE posts SET content = :content WHERE status = :status");
        $req->execute(array(
			'content' => $content,
			'status' => $status,
		));
	}
	public function getAllPostsbyPage($status, $after) {
		$bdd = $this->dbConnect();
        $req = $bdd->prepare("SELECT * FROM posts WHERE type = 'post' AND status = ? ORDER BY date DESC LIMIT 9 OFFSET " . $after);
        $req->execute(array($status));
        return $req;
	}
	public function countAllPosts($status) {
		$bdd = $this->dbConnect();
        $req = $bdd->prepare("SELECT COUNT(*) FROM posts WHERE type = 'post' AND status = ?");
        $req->execute(array($status));
        $data = $req->fetch();
        return $data;
	}
	public function checkPost($id) {
		$bdd = $this->dbConnect();
        $req = $bdd->prepare("SELECT * FROM posts WHERE ID = ?");
        $req->execute(array($id));
        $data = $req->fetch();
        return ($data) ? true : false;
	}
	public function getPost($id) {
		$bdd = $this->dbConnect();
        $req = $bdd->prepare("SELECT * FROM posts WHERE ID = ?");
        $req->execute(array($id));
        $data = $req->fetch();
        return $data;
	}
	public function discardPost($id) {
		$bdd = $this->dbConnect();
        $req = $bdd->prepare("UPDATE posts SET status = 'discarded' WHERE ID = ?");
        $req->execute(array($id));
	}
	public function updatePost($id, $status, $title, $content) {
		$bdd = $this->dbConnect();
        $req = $bdd->prepare("UPDATE posts SET status = :status, title = :title, content = :content, date = CURDATE() WHERE ID = :id");
        $req->execute(array(
            'id' => $id,
        	'status' => $status,
			'title' => $title,
			'content' => $content,
		));
	}
	public function createPost($status, $title, $content) {
		$bdd = $this->dbConnect();
        $req = $bdd->prepare("INSERT INTO posts(type, status, title, content, date) 
        	VALUES('post', :status, :title, :content, CURDATE())");
        $req->execute(array(
        	'status' => $status,
			'title' => $title,
			'content' => $content,
			));
	}
	public function getLastPost() {
		$bdd = $this->dbConnect();
        $req = $bdd->query("SELECT * FROM posts ORDER BY ID DESC LIMIT 0, 1");
        $post = $req->fetch();
        return $post;
	}
	public function retrievePost($id) {
		$bdd = $this->dbConnect();
        $req = $bdd->prepare("UPDATE posts SET status = 'saved' WHERE ID = ?");
        $req->execute(array($id));
	}
	public function deletePost($id) {
		$bdd = $this->dbConnect();
        $req = $bdd->prepare("DELETE FROM posts WHERE ID = ?");
        $req->execute(array($id));
	}
}