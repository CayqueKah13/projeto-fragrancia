<?php
class psckttransparenteController extends controller {

	private $user;
    private $storeObrigado="";

    public function __construct() {
        parent::__construct();

        $this->user = new Users();
    }

    public function index() {

        if(!$this->user->isLogged()){
            header("Location: ".BASE_URL."login?card=redirect#redirect");
            exit;
        }

        $dados = array();
        $store = new Store();
        $products = new Products();
        $cart = new Cart();

        $dados = $store->getTemplateData();
        $dados['searchTerm'] = '';
        $dados['category'] = '';

        $list = $cart->getList();
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

        $dados['total'] = number_format($total,2,".","");

        try{
            $sessionCode = \PagSeguro\Services\Session::create(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );
            $dados['sessionCode'] = $sessionCode->getResult();
        }catch(Exception $e){
            echo "ERRO: ".$e->getMessage();
            exit;
        }

        $this->loadTemplate('cart_psckttransparente', $dados);
    }

    public function checkout(){

        if(!$this->user->isLogged()){
            header("Location: ".BASE_URL."login?card=redirect#redirect");
            exit;
        }

        $users = new Users();
        $cart = new Cart();
        $purchases = new Purchases();

        $id = addslashes($_POST['id']);
        $name = addslashes($_POST['name']);
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
        $cartao_titular = addslashes($_POST['cartao_titular']);
        $cartao_numero = addslashes($_POST['cartao_numero']);
        $cvv = addslashes($_POST['cvv']);
        $v_mes = addslashes($_POST['v_mes']);
        $v_ano = addslashes($_POST['v_ano']);
        $cartao_token = addslashes($_POST['cartao_token']);
        $parc = explode(';',$_POST['parc']);

        $cartao_cpf = addslashes($_POST['cartao_cpf']);
        $cartao_ddd = addslashes($_POST['cartao_ddd']);
        $cartao_tel = addslashes($_POST['cartao_tel']);
        $cartao_date = addslashes($_POST['cartao_date']);

        $uid = $_SESSION['ccUser'];

        $list = $cart->getList();
        $total = 0;

        foreach($list as $item){
            $total += (floatval($item['price']) * intval($item['qt']));
        }


        $withStore = "";

        if(!empty($_SESSION['shipping'])){
            $shipping = $_SESSION['shipping'];

            if(isset($shipping['price'])){
                $frete = floatval(str_replace(',','.',$shipping['price']));
            }else{
                $frete = 0;
            }

            $total += $frete; 
        }else{
            $stores_available = $cart->getStoreAvailable();
            
            $withStore = $_SESSION['op_insert'];
            
            $frete = 0;
        }

        
        $parcPurch=number_format($parc[1],2,".","");
        $parcPurch = $parcPurch * intval($parc[0]);
        $parcPurch = number_format($parcPurch,2,".","");

        //verifica se valor enviado no input é verdadeiro
        $totalAmount=floatval($parc[2]);

        $vWMore = $parcPurch + 2;
        $vWSub = $parcPurch - 2;

        if( !($vWMore > $totalAmount && $vWSub < $totalAmount) ){
            $totalAmount = $parcPurch;
        }
       
        $id_purchase = $purchases->createPurchase($uid,$totalAmount,$frete,$withStore,'psckttransparente',$cpf);

        foreach($list as $item){
            $purchases->addItem($id_purchase,$item['id'],$item['qt'],$item['price']);
        }

        global $config;

        $creditCard = new \PagSeguro\Domains\Requests\DirectPayment\CreditCard();
        $creditCard->setReceiverEmail($config['pagseguro_seller']);
        $creditCard->setReference($id_purchase);
        $creditCard->setCurrency("BRL");

        $itemUnitVal=0;
        foreach($list as $item){

            $itemUnitVal = floatval($item['price']);//floatval($item['price']) * intval($item['qt']);
            $itemUnitVal = number_format($itemUnitVal,2,".","");

            $creditCard->addItems()->withParameters($item['id'],$item['name'],intval($item['qt']),$itemUnitVal);


        }
        

        $creditCard->setSender()->setName($name);
        $creditCard->setSender()->setEmail($email);
        $creditCard->setSender()->setDocument()->withParameters('CPF',$cpf);

        //$ddd = substr($telefone,0,2);
        //$telefone = substr($telefone,2);

        $ddd = str_replace("(", "", $ddd);
        $ddd = str_replace(")", "", $ddd);
        $telefone = str_replace("-", "", $telefone);

        $creditCard->setSender()->setPhone()->withParameters(
            $ddd,
            $telefone);

        $creditCard->setSender()->setHash($id);

        $ip = $_SERVER['REMOTE_ADDR'];

        if(strlen($ip) < 9){
            $ip = '127.0.0.1';
        }

        $creditCard->setSender()->setIp($ip);

        $creditCard->setShipping()->setAddress()->withParameters(
            $rua,
            $numero,
            $bairro,
            $cep,
            $cidade,
            $estado,
            'BRA',
            $complemento
        );
        if($frete > 0){
            $creditCard->setShipping()->setCost()->withParameters($frete);

            // codigo do sedex abaixo
            $creditCard->setShipping()->setType()->withParameters(3);
        }

        $creditCard->setBilling()->setAddress()->withParameters(
            $rua,
            $numero,
            $bairro,
            $cep,
            $cidade,
            $estado,
            'BRA',
            $complemento
        );

        $creditCard->setToken($cartao_token);

        $parc1=number_format($parc[1],2,".","");     

        // TERCEIRO PARAMETRO ABAIXO INDICA ATE QUE PARCELA FICARA SEM JUROS
        $creditCard->setInstallment()->withParameters($parc[0],$parc1,10);
        $creditCard->setHolder()->setName($cartao_titular);
        $creditCard->setHolder()->setDocument()->withParameters('CPF',$cartao_cpf);

        $creditCard->setHolder()->setBirthdate($cartao_date);

        $cartao_ddd = str_replace("(", "", $cartao_ddd);
        $cartao_ddd = str_replace(")", "", $cartao_ddd);
        $cartao_tel = str_replace("-", "", $cartao_tel);
        $creditCard->setHolder()->setPhone()->withParameters(
            $cartao_ddd,
            $cartao_tel
        ); 

        $creditCard->setMode('DEFAULT');

        $creditCard->setNotificationUrl(BASE_URL."psckttransparente/notification");
        unset($_SESSION['op_insert']);
        try{
       
            $result = $creditCard->register(\PagSeguro\Configuration\Configure::getAccountCredentials());        
              
            /* caso \/ precise usar as funçoes get do pagseguro tem um exemplo abaixo
            echo $result->getGrossAmount(); */

            echo json_encode($result);
            exit;

        }catch(Exception $e){

            $purchases->delPurchaseFail($id_purchase);

            echo json_encode(array('error'=>true, 'msg'=>$e->getMessage()));
            exit;
        }


    }



    public function obrigado(){
        unset($_SESSION['cart']);

        $dados = array();

        $store = new Store();
        $dados = $store->getTemplateData();


        $this->loadTemplate("psckttransparente_obrigado",$dados);
    }


    public function notification(){
        $purchases = new Purchases();

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
                    $purchases->setPaid($ref,$status);
                }

            }

        }catch(Exception $e){

        }

    }

 


}