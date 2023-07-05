<?php
class Pages extends model {

	public function get($id_page){
		$array = array();

		$sql = "SELECT * FROM pages WHERE id = $id_page";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0){

			$array = $sql->fetch(PDO::FETCH_ASSOC);

		}

		return $array;
	}


}