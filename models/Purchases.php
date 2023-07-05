<?php 
class Purchases extends model{

	public function createPurchase($uid, $total, $frete, $withStore, $payment_type, $cpf){

		$sql = "INSERT INTO purchases (id_user, purchase_date, total_amount, shipping_cost, shipping_status, payment_type, payment_status, cpf_pessoal) VALUES (:uid, NOW(), :total, :frete, :with_store, :type,1,:cpf)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":uid",$uid);
		$sql->bindValue(":total",$total);
		$sql->bindValue(":frete",$frete);
		$sql->bindValue(":with_store",$withStore);
		$sql->bindValue(":type",$payment_type);
		$sql->bindValue(":cpf",$cpf);
		$sql->execute();

		return $this->db->lastInsertId();

	}

	public function addItem($id, $id_product, $qt, $price){

		$sql ="INSERT INTO purchases_products (id_purchase, id_product, quantify, product_price) 
		VALUES (:id, :idp, :qt, :price)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id",$id);
		$sql->bindValue(":idp",$id_product);
		$sql->bindValue(":qt",$qt);
		$sql->bindValue(":price",$price);
		$sql->execute();
	}


	public function setPaid($id,$status){

		$sql = "UPDATE purchases SET payment_status = :status WHERE id = :id";
		$sql= $this->db->prepare($sql);
		$sql->bindValue(":status",$status); // 3 = Pago
		$sql->bindValue(":id",$id);
		$sql->execute();

	}



	public function setCancelled($id){

		$sql = "UPDATE purchases SET payment_status = :status WHERE id = :id";
		$sql= $this->db->prepare($sql);
		$sql->bindValue(":status",'7'); // 7 = Cancelado 
		$sql->bindValue(":id",$id);
		$sql->execute();

	}


	public function updateBilletUrl($id,$link){
		$sql = "UPDATE purchases SET billet_link = :link WHERE id = :id";
		$sql= $this->db->prepare($sql);
		$sql->bindValue(":link",$link);
		$sql->bindValue(":id",$id);
		$sql->execute();
	}



	public function getMyPurchases($id_sess,$pag){
		$array = array();

		$pagfilter = array(
			'offset'=> 0,
			'limit'=> 10
		);

		if(!empty($pag['per_page'])){
			$pagfilter['limit'] = $pag['per_page'];
		}

		if(!empty($pag['currentpage'])){
			$pagfilter['offset'] = $pag['currentpage'] * $pagfilter['limit'];
		}


		$sql = "SELECT * FROM purchases
		WHERE id_user = :id_sess ORDER BY id DESC LIMIT ".$pagfilter['offset'].','.$pagfilter['limit'];

		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id_sess",$id_sess);
		$sql->execute();

		if($sql->rowCount()> 0){
			$array = $sql->fetchAll(PDO::FETCH_ASSOC);
		}


		return $array;

	}

	public function getTotMyPurchases($id_sess){

		$sql = "SELECT COUNT(*) as c FROM purchases WHERE id_user = :id_sess";
		$sql = $this->db->prepare($sql);

		$sql->bindValue(":id_sess",$id_sess);
		$sql->execute();

		$data = $sql->fetch();

		return $data['c'];
	}


	public function delPurchaseFail($id_purchase){

		if(!empty($id_purchase)){
			$sql = "DELETE FROM purchases WHERE id = $id_purchase";
			$this->db->query($sql);

			$sql = "DELETE FROM purchases_products WHERE id_purchase = $id_purchase";
			$this->db->query($sql);
		}
	}



	public function getAjaxPurchase($id_purchase,$id_user){
	   $array = array();

	   $sql = "SELECT * FROM purchases
	   		  INNER JOIN purchases_products as pp ON purchases.id = pp.id_purchase
	   		  INNER JOIN products ON pp.id_product = products.id
	   		  WHERE purchases.id=:id AND purchases.id_user = :id_user";
	   	$sql = $this->db->prepare($sql);
	   	$sql->bindValue(":id",$id_purchase);
	   	$sql->bindValue(":id_user",$id_user);
	   	$sql->execute();

	   	if($sql->rowCount() > 0){
	   		$array = $sql->fetchAll(PDO::FETCH_ASSOC);
	   	}

	   	return $array;

	}




}