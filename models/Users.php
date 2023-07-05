<?php 
class Users extends model{


	 public function resetQtdBoletosUsers(){
	   $sql = "UPDATE users SET boletos_day = 15";
	   $sql->query($sql);
	 }	

	 public function oneLessBoleto($id_user){
	 	$sql = $this->db->prepare("UPDATE users SET boletos_day = boletos_day - 1 WHERE id = :id");
	 	$sql->bindValue(":id",$id_user);
	 	$sql->execute();
	 }

	 public function qtdBoletosDay($id_user){

	 	$sql = $this->db->prepare("SELECT boletos_day FROM users WHERE id=:id");
	 	$sql->bindValue(":id",$id_user);
	 	$sql->execute();

	 	if($sql->rowCount() > 0){
	 		$qtd = $sql->fetch();

	 		if($qtd['boletos_day'] > 0){
	 			return true;
	 		}
	 	}

	 	return false;

	 }

	 public function isLogged(){

	 	if(isset($_SESSION['ccUser']) &&  !empty($_SESSION['ccUser'])){

	 		return true;
	 	}

	 	return false;

	 }


	 public function doLogin($email,$pass){

 		$sql = $this->db->prepare("SELECT * FROM users WHERE email=:email AND password=:pass");
 		$sql->bindValue(":email",$email);
 		$sql->bindValue(":pass",MD5($pass));
 		$sql->execute();

 		if($sql->rowCount() > 0){

 			$row = $sql->fetch();
 			if($row['confirm_email'] == "1"){

 				$_SESSION['ccUser'] = $row['id'];
 				return array("success"=>true);
 			}

 			$page_resend = BASE_URL."login/resend";
 			return array("success"=>false,"msg"=>"É preciso que você confirme seu e-mail para poder acessar o site, <br><br> Caso queira receber novamente a confirmação de e-mail <a href=".$page_resend.">Clique Aqui</a>");
 		}

 		return array("success"=>false,"msg"=>"E-mail e/ou Senha estão incorretos");
	 		
	 }

	public function sessionLogin($id_sess){

		$array = array();

		$sql = "SELECT * FROM users WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id",$id_sess);
		$sql->execute();

		if($sql->rowCount() > 0){
			$array = $sql->fetch(PDO::FETCH_ASSOC);
		}

		return $array;
	} 

	public function emailExists($email){

		$sql = "SELECT * FROM users WHERE email = :email";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":email",$email);
		$sql->execute();

		if($sql->rowCount() > 0){
			return true;
		}else{
			return false;
		}

	}

	public function validate($email,$pass){
		$uid = '';

		$sql = "SELECT * FROM users WHERE email = :email AND password = :password";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":email",$email);
		$sql->bindValue(":password",md5($pass));
		$sql->execute();

		if($sql->rowCount() > 0){
			$sql = $sql->fetch();
			$uid = $sql['id'];
		}

		return $uid;

	}

	public function createUser($name,$email,$pass,$hash){

		$sql = "INSERT INTO users (name,email,password,hash_confirm_email) VALUES (:name,:email,:pass,:hash)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":name",$name);
		$sql->bindValue(":email",$email);
		$sql->bindValue(":pass",md5($pass));
		$sql->bindValue(":hash",$hash);
		$sql->execute();

		return $this->db->lastInsertId();

	}


	public function tokenForgot($email){

		$array = array("response"=>false);

		$sql = "SELECT * FROM users WHERE email = :email";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":email",$email);
		$sql->execute();

		if($sql->rowCount() > 0){

			$sql = $sql->fetch();
			$id = $sql['id'];
			$nome = $sql['name'];

			$token = md5($id.time().rand(0,999999).rand(0,99999));
			$data = date("Y-m-d H:i",strtotime("+ 1 day"));

			$sql = "INSERT INTO users_token (id_user, hash_forgot, expired_at) 
			VALUES ('".$id."','".$token."','".$data."')";
			$this->db->query($sql);

			$url = BASE_URL."login/reset?token=".$token;

			$array = array("response"=>true, "url"=>$url,"nome"=>$nome);

		
		}


		return $array;
		

	}


	public function tokenExists($token){

		$array = array();

		$sql = "SELECT * FROM users_token WHERE hash_forgot = :hash AND used = 0 AND expired_at > NOW()";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":hash",$token);
		$sql->execute();

		if($sql->rowCount() > 0){
			$sql = $sql->fetch();
			$array = array("response"=>true, "id_user"=>$sql['id_user']);
		}else{
			$array = array("response"=>false);
		}

		return $array;

	}



	public function changePassword($pass,$pass2,$id_user){

		if($pass == $pass2){

			$sql= "UPDATE users SET password = :pass WHERE id = :id";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":pass",md5($pass));
			$sql->bindValue(":id",$id_user);
			$sql->execute();

			return true;
		}else{
			return false;
		}

	}


	public function usedTokenForgot($token){

		$sql = "UPDATE users_token SET used = 1 WHERE hash_forgot=:hash";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":hash",$token);
		$sql->execute();
	}


	public function validateCurrentPass($id_user,$password){

		$sql = "SELECT password FROM users WHERE id = :id_user AND password = :password";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id_user",$id_user);
		$sql->bindValue(":password",md5($password));
		$sql->execute();

		if($sql->rowCount() > 0){
			return true;
		}

		return false;

	}


	public function confirmEmail($cad_hash){

		$sql = "SELECT * FROM users WHERE hash_confirm_email = :hash";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":hash",$cad_hash);
		$sql->execute();

		if($sql->rowCount() > 0){

			$sql = "UPDATE users SET confirm_email = 1 WHERE 
			hash_confirm_email = :hash";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":hash",$cad_hash);
			$sql->execute();

			return true;
		}

		return false;

	}


	public function getInfoEmail($email){
		$array = array();

		$sql = "SELECT * FROM users WHERE email = :email";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":email",$email);
		$sql->execute();

		if($sql->rowCount() > 0){

			$array = $sql->fetch();
		}

		return $array;
	}



}