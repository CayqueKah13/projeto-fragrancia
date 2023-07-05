<?php
class boletoController extends controller{

	private $user;
	private $purchases;
	private $id_user;
	private $id_purchase;
	private $frete;
	private $total;
	private $discount;
	private $valExtraDesconto;
	private $cart;
	private $withStore;
	private $cpf;

	public function __construct(){
		parent::__construct();

		$this->user = new Users();
		$this->purchases = new Purchases();
		$this->cart = new Cart();
	}


	private function auxBoleto($list){

		$this->frete = 0;
	    $this->total = 0;

	    foreach($list as $item){
            $this->total += (floatval($item['price']) * intval($item['qt']));
        }

    	if(!empty($_SESSION['shipping'])){
            $shipping = $_SESSION['shipping'];

            if(isset($shipping['price'])){
                $this->frete = floatval(str_replace(',','.',$shipping['price']));
            }else{
                $this->frete = 0;
            }

            $this->total += $this->frete;
        }else{

            $stores_available = $this->cart->getStoreAvailable();
            
            $this->withStore = $_SESSION['op_insert'];
            
            $this->frete = 0;
        }



        //Valor do desconto nessa variavel abaixo, 5% atualmente
        $pctm = 0;
        if($pctm != 0){
	        $this->valExtraDesconto = number_format(($this->total / 100 * $pctm),2,".","");
	        $this->totDiscount = $this->total - number_format(($this->total / 100 * $pctm),2,".","");
        }else{
        	$this->valExtraDesconto = 0;
        	$this->totDiscount = $this->total;

        }
 

	}

	private function boletoPagseguro($array){

		$this->id_purchase = $this->purchases->createPurchase($this->id_user,$this->totDiscount+1,$this->frete,$this->withStore,'boletopagseguro',$this->cpf);
        
        foreach($array['list'] as $item){
	        $this->purchases->addItem($this->id_purchase,$item['id'],$item['qt'],$item['price']);
	    }

	 	global $config;

	 	$boleto = new \PagSeguro\Domains\Requests\DirectPayment\Boleto();
	 	$boleto->setMode('DEFAULT');
	 	$boleto->setReceiverEmail($config['pagseguro_seller']); 
	 	$boleto->setCurrency("BRL");

	 	foreach($array['list'] as $item){

	 		$itemUnitVal = floatval($item['price']);//floatval($item['price']) * intval($item['qt']);
            $itemUnitVal = number_format($itemUnitVal,2,".","");

		 	$boleto->addItems()->withParameters($item['id'], $item['name'], intval($item['qt']), $itemUnitVal);
		}


		$boleto->setReference($this->id_purchase);

		if($this->valExtraDesconto!=0){
			// para colocar desconto é só colocar valor negativo no extraAmount
			$boleto->setExtraAmount(-$this->valExtraDesconto);
		}

		$boleto->setSender()->setName($array['name']);
		$boleto->setSender()->setEmail($array['email']);
		$boleto->setSender()->setDocument()->withParameters('CPF',$array['cpf']);


		$array['ddd'] = str_replace("(", "", $array['ddd']);
        $array['ddd'] = str_replace(")", "", $array['ddd']);
        $array['telefone'] = str_replace("-", "", $array['telefone']);

		$boleto->setSender()->setPhone()->withParameters(
		    $array['ddd'],
		    $array['telefone']
		);


		$boleto->setSender()->setHash($array['hash']);


		$ip = $_SERVER['REMOTE_ADDR'];

        if(strlen($ip) < 9){
            $ip = '127.0.0.1';
        }
		$boleto->setSender()->setIp($ip);


		if($this->frete > 0){
			$boleto->setShipping()->setCost()->withParameters($this->frete);
		}
			$boleto->setShipping()->setAddress()->withParameters(
			    $array['rua'],
			    $array['numero'],
			    $array['bairro'],
			    $array['cep'],
			    $array['cidade'],
			    $array['estado'],
			    'BRA',
			    $array['complemento']
			);
		

		$boleto->setNotificationUrl(BASE_URL."boleto/notification");
		unset($_SESSION['op_insert']);
		try {

		    //Get the crendentials and register the boleto payment
		    $result = $boleto->register(
		        \PagSeguro\Configuration\Configure::getAccountCredentials()
		    );
		    // You can use methods like getCode() to get the transaction code and getPaymentLink() for the Payment's URL

		    return array("operation"=>"success","message"=>$result->getPaymentLink());


		} catch (Exception $e) {

			$this->purchases->delPurchaseFail($this->id_purchase);

		   
		    return array("operation"=>"fail","message"=>$e->getMessage());
		}


	}

	public function index(){

		if(!$this->user->isLogged()){
			header("Location: ".BASE_URL."login?boleto=redirect#redirect");
			exit;
		}

		$this->id_user=$_SESSION['ccUser'];

		$dados = array();
        $store = new Store();
        $users = new Users();

        $dados = $store->getTemplateData();
        $dados['searchTerm'] = '';
        $dados['category'] = '';
        $dados['error'] = '';

        $list = $this->cart->getList();
        
        $this->auxBoleto($list);

        $dados['total'] = $this->total;
        $dados['totDiscount'] = $this->totDiscount;


        if( !empty($_POST['nome']) && !empty($_POST['cpf']) && !empty($_POST['ddd']) &&
        	!empty($_POST['telefone']) && !empty($_POST['email']) && !empty($_POST['cep']) &&
        	!empty($_POST['rua']) && !empty($_POST['numero']) && !empty($_POST['bairro']) &&
        	!empty($_POST['cidade']) && !empty($_POST['estado']) ){

	        $name = addslashes($_POST['nome']); 
	        $this->cpf = addslashes($_POST['cpf']);
	        $cpf = addslashes($_POST['cpf']);
	        $ddd = addslashes($_POST['ddd']); 
	        $telefone = addslashes($_POST['telefone']); 
	        $email = addslashes($_POST['email']); 
	        $cep = addslashes($_POST['cep']); 
	        $rua = addslashes($_POST['rua']); 
	        $numero = addslashes($_POST['numero']); 
	        $complemento = addslashes($_POST['complemento']); 
	        $bairro = addslashes($_POST['bairro']); 
	        $cidade = addslashes($_POST['cidade']); 
	        $estado = addslashes($_POST['estado']);
	        $hash = addslashes($_POST['hash']); 

	        $array = array("name"=>$name, "cpf"=>$cpf, "ddd"=>$ddd, "telefone"=>$telefone,
	    			 "email"=>$email, "cep"=>$cep, "rua"=>$rua, "numero"=>$numero,
	    			 "complemento"=> $complemento, "bairro"=>$bairro, "cidade"=>$cidade,
	    			 "estado"=>$estado,"hash"=>$hash,"list"=>$list);
	        
	        if($this->user->qtdBoletosDay($this->id_user)){
	        	$dados['result']=$this->boletoPagseguro($array);
	    	}else{
	    		$dados['maxBoletosDay'] = "Você só pode gerar 15 boletos ao dia caso queira aumentar esse número fale com o suporte do site.";
	    	}
	    }

        if(!empty($dados['result']['message']) && $dados['result']['operation']=='success'){

        	$this->user->oneLessBoleto($this->id_user);

        	$this->purchases->updateBilletUrl($this->id_purchase,$dados['result']['message']);       	
        	unset($_SESSION['cart']);

			$this->loadTemplate('boleto_obrigado',$dados);

    	}else{

        	$this->loadTemplate('cart_boleto',$dados);
    	}

	}

/*	public function indexGerenciaNet(){
		$dados = array();
        $store = new Store();
        $users = new Users();
        $cart = new Cart();
        $this->purchases = new Purchases();
        

        $dados = $store->getTemplateData();
        $dados['searchTerm'] = '';
        $dados['category'] = '';
        $dados['error'] = '';

        if(isset($_POST['nome']) && !empty($_POST['nome'])){

	        $name = addslashes($_POST['nome']); 
	        $cpf = addslashes($_POST['cpf']); 
	        $telefone = addslashes($_POST['telefone']); 
	        $email = addslashes($_POST['email']); 
	        $pass = addslashes($_POST['pass']); 
	        $cep = addslashes($_POST['cep']); 
	        $rua = addslashes($_POST['rua']); 
	        $numero = addslashes($_POST['numero']); 
	        $complemento = addslashes($_POST['complemento']); 
	        $bairro = addslashes($_POST['bairro']); 
	        $cidade = addslashes($_POST['cidade']); 
	        $estado = addslashes($_POST['estado']); 

	        if($users->emailExists($email)){
            	$uid = $users->validate($email,$pass);

	            if(empty($uid)){
	            	$dados['error'] = 'E-mail e/ou senha não conferem.';
	            }

	        }else{
	            $uid = $users->createUser($email,$pass);
	        }

	        if(!empty($uid)){

	        	$list = $cart->getList();
	        	$frete = 0;
	        	$total = 0;

	        	foreach($list as $item){
		            $total += (floatval($item['price']) * intval($item['qt']));
		        }

	        	if(!empty($_SESSION['shipping'])){
		            $shipping = $_SESSION['shipping'];

		            if(isset($shipping['price'])){
		                $frete = floatval(str_replace(',','.',$shipping['price']));
		            }else{
		                $frete = 0;
		            }

		            $total += $frete;
		        }

		        $this->id_purchase = $this->purchases->createPurchase($uid,$total,'mp');

        		foreach($list as $item){
	            	$this->purchases->addItem($this->id_purchase,$item['id'],$item['qt'],$item['price']);
	        	}

	        	global $config;

	        	// Start Integrations Boleto
	        	$options=array(
	        		'client_id' => $config['gerencianet_clientid'],
	        		'client_secret' => $config['gerencianet_clientesecret'],
	        		'sandbox' => $config['gerencianet_sandbox']
	        	);

	        	$items=array();
	        	foreach($list as $item){
	        		$items[] = array(
	        			'name' => $item['name'],
	        			'amount' => $item['qt'],
	        			'value' => ($item['price']*100)
	        		);
	        	}

	        	$metadata = array(
	        		'custom_id' => $this->id_purchase,
	        		'notification_url' => BASE_URL.'boleto/notificacao'
	        	);

	        	$shipping = array(
	        		array(
	        			'name' => 'FRETE',
	        			'value' => ($frete * 100)
	        		)
	        	);


	        	$body = array(
	        		'metadata' => $metadata,
	        		'items' => $items,
	        		'shippings' => $shipping
	        	);

	        	try{	

	        		$api = new \Gerencianet\Gerencianet($options);
	        		$charge = $api->createCharge(array(), $body);

	        		if($charge['code']=='200'){
	        			$charge_id = $charge['data']['charge_id'];

	        			$params = array(
	        				'id' => $charge_id
	        			);

	        			$cpf = str_replace(".","",$cpf);
	        			$cpf = str_replace("-","",$cpf);

	        			$telefone =  str_replace("(","",$telefone);
	        			$telefone =  str_replace(")","",$telefone);
	        			$telefone =  str_replace("-","",$telefone);
	        			$telefone =  str_replace(" ","",$telefone);

	        			$customer = array(
	        				'name' => $name,
	        				'cpf' => $cpf,
	        				'phone_number' => $telefone

	        			);

	        			$bankingBillet = array(
	        				'expire_at' => date('Y-m-d',strtotime('+7 days')),
	        				'customer' => $customer

	        			);

	        			$payment = array(
	        				'banking_billet' => $bankingBillet
	        			);

	        			$body = array(
	        				'payment' => $payment
	        			);

	        			try{
	        				$charge = $api->payCharge($params,$body);

	        				if($charge['code'] == '200'){

	        					$link = $charge['data']['link'];

	        					$this->purchases->updateBilletUrl($this->id_purchase,$link);
	        					unset($_SESSION['cart']);

	        					$dados['link'] = $link;

	        				}

	        			}catch(Exception $e){
	        				echo "ERRO: ";
			        		print_r($e->getMessage());
			        		exit;
	        			}


	        		}

	        	}catch(Exception $e){
	        		echo "ERRO: ";
	        		print_r($e->getMessage());
	        		exit;
	        	}


	        }


    	}

    	if(!empty($link)){
			$this->loadTemplate('boleto_obrigado',$dados);
    	}else{
        	$this->loadTemplate('cart_boleto',$dados);
    	}
	} */

	public function notification(){

		$this->purchases = new Purchases();

        try{

            if(\PagSeguro\Helpers\Xhr::hasPost()){

                $r = \PagSeguro\Services\Transactions\Notification::check(
                    \PagSeguro\Configuration\Configure::getAccountCredentials()
                );

                $ref = $r->getReference();
                $status = $r->getStatus();
                /* VER SE EU VOU FAZER FUNÇÕES DE CADA STATUS
                
                1 = Aguardando Pagamento
                2 = Em análise (Antifraude)
                3 = Paga
                4 = Disponível (para lojista fazer saque depende do periodo de antecipação)
                5 = Em disputa (comprador manda e-mail pro pagseguro alegando que não recebeu produto)
                6 = Devolvida (ganhou a disputa, dinheiro devolvido pro comprador)
                7 = Cancelada
                8 = Debitado (ele recebeu dinheiro de fato depois da disputa)
                9 = Retenção Temporária = Chargeback

                            \/
                */
				if($status != 10){         
                	$this->purchases->setPaid($ref,$status);
                }

            }

        }catch(Exception $e){

        }


	}

	public function notificacao(){
		
		global $config;

		$options=array(
	        'client_id' => $config['gerencianet_clientid'],
	        'client_secret' => $config['gerencianet_clientesecret'],
	        'sandbox' => $config['gerencianet_sandbox']
	    );

		$params = array(
			'token' => $token
		);

		try{

			$api = new \Gerencianet\Gerencianet($options);
			$c = $api->getNotification($params,array());

			$ultimo = end($c['data']);

			$custom_id= $ultimo['custom_id'];

			$status = $ultimo['status']['current'];

			if($status == 'paid'){

				$this->purchases= new Purchases();
				$this->purchases->setPaid($custom_id);
			}

		}catch(Exception $e){
			echo "ERRO: ";
    		print_r($e->getMessage());
    		exit;
		}


	}




}