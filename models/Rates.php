<?php
class Rates extends model{


	public function getRates($id, $qt){
		$array = array();

		$sql = "SELECT *,
		(select users.name from users where users.id = rates.id_user) as user_name
		FROM rates WHERE id_product = :id ORDER BY date_rated DESC LIMIT ".$qt;

		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id",$id);
		$sql->execute();

		if($sql->rowCount() > 0){
			$array = $sql->fetchAll();
		}

		return $array;
	}

	public function insert($id,$id_user,$title_rate,$text_rate,$star_rate){

		$star_rate = intval($star_rate);

		if($star_rate == -1) $star_rate = 0; 

		if($star_rate > 5 || $star_rate < 0){
			$star_rate = 5;
		}

		$text_rate = $this->limita_caracteres($text_rate,200);

		$sql = "INSERT rates (id_product,id_user,date_rated,points,title,comment) VALUES 
		(:id_product, :id_user, :date_rated, :points, :title, :comment)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id_product",$id);
		$sql->bindValue(":id_user",$id_user);
		$sql->bindValue(":date_rated",date("Y-m-d H:i"));
		$sql->bindValue(":points",$star_rate);
		$sql->bindValue(":title",$title_rate);
		$sql->bindValue(":comment",$text_rate);
		$sql->execute();

	}

	private function limita_caracteres($texto, $limite, $quebra = true){
	   
	   $tamanho = strlen($texto);

	   if($tamanho <= $limite){ //Verifica se o tamanho do texto é menor ou igual ao limite
	      $novo_texto = $texto;
	   }else{ // Se o tamanho do texto for maior que o limite
	      if($quebra == true){ // Verifica a opção de quebrar o texto
	         $novo_texto = trim(substr($texto, 0, $limite))."...";
	      }else{ // Se não, corta $texto na última palavra antes do limite
	         $ultimo_espaco = strrpos(substr($texto, 0, $limite), " "); // Localiza o útlimo espaço antes de $limite
	         $novo_texto = trim(substr($texto, 0, $ultimo_espaco))."..."; // Corta o $texto até a posição localizada
	      }
	   }
	   return $novo_texto; // Retorna o valor formatado
	}



}