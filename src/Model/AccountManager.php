<?php

namespace Project\Model;

class AccountManager extends Manager {
    public function getAccountbyId($id) {
        $bdd = $this->dbConnect();
        $req = $bdd->prepare("SELECT * FROM accounts WHERE ID = ?");
        $req->execute(array($id));
        $data = $req->fetch();
        return $data;
    }
    public function getAccountbyPseudo($pseudo) {
        $bdd = $this->dbConnect();
        $req = $bdd->prepare("SELECT * FROM accounts WHERE pseudo = ?");
        $req->execute(array($pseudo));
        $data = $req->fetch();
        return $data;
    }
	public function checkPseudo($pseudo) {
        $bdd = $this->dbConnect();
        $req = $bdd->prepare("SELECT * FROM accounts WHERE pseudo = ?");
        $req->execute(array($pseudo));
        $data = $req->fetch();
        return ($data) ? true : false;
    }
    public function checkEmail($email) {
        $bdd = $this->dbConnect();
        $req = $bdd->prepare("SELECT * FROM accounts WHERE email = ?");
        $req->execute(array($email));
        $data = $req->fetch();
        return ($data) ? true : false;
    }
    public function signUpAccount($pseudo, $email, $password) {
        $bdd = $this->dbConnect();
        $req = $bdd->prepare("INSERT INTO accounts(status, pseudo, email, password) VALUES('member', :pseudo, :email, :password)");
        $req->execute(array(
            'pseudo' => $pseudo,
            'password' => $password,
            'email' => $email,
        ));
    }
    public function updateEmail($email, $id) {
        $bdd = $this->dbConnect();
        $req = $bdd->prepare("UPDATE accounts SET email = :email WHERE ID = :id");
        $req->execute(array(
            'email' => $email,
            'id' => $id,
        ));
    }
    public function updatePassword($password, $id) {
        $bdd = $this->dbConnect();
        $req = $bdd->prepare("UPDATE accounts SET password = :password WHERE ID = :id");
        $req->execute(array(
            'password' => $password,
            'id' => $id,
        ));
    }
    public function changeStatusAccount($id, $status) {
        $bdd = $this->dbConnect();
        $req = $bdd->prepare("UPDATE accounts SET status = :status WHERE ID = :id");
        $req->execute(array(
            'id' => $id,
            'status' => $status,
        ));
    }
    public function getAllAccounts() {
        $bdd = $this->dbConnect();
        $req = $bdd->query("SELECT * FROM accounts");
        return $req;
    }
    public function getAccountsbyStatus($status) {
        $bdd = $this->dbConnect();
        $req = $bdd->prepare("SELECT * FROM accounts WHERE status = ?");
        $req->execute(array($status));
        return $req;
    }
}