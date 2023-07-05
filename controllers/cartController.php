<?php
class cartController extends controller {

	private $user;

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        $dados = array();
        $store = new Store();
        $products = new Products();
        $cart = new Cart();
        $cep = '';
        $shipping = array();

        if(!empty($_GET['cep'])){

            $cep = addslashes($_GET['cep']);
            
            $cep = str_replace("-","",$cep);
            $cep = str_replace("/","",$cep);

            $cep = intval($cep);

            $shipping = $cart->shippingCalculate($cep);
            $_SESSION['shipping'] = $shipping;
        }

        if(!empty($_SESSION['shipping'])){
            $_SESSION['shipping'] = $shipping;
        }


        if(!isset($_SESSION['cart']) || (isset($_SESSION['cart']) && count($_SESSION['cart']) == 0)){
            header("Location: ".BASE_URL);
            exit;
        }

        $dados = $store->getTemplateData();
        $dados['searchTerm'] = '';
        $dados['category'] = '';
        $dados['shipping'] = $shipping;
        $dados['list'] = $cart->getList();

        $dados['stores_available'] = $cart->getStoreAvailable();

        $this->loadTemplate('cart', $dados);
    }

    public function del($id){
        if(!empty($id)){
            unset($_SESSION['cart'][$id]);
        }

        header("Location: ".BASE_URL."cart");
        exit;
    }

    public function add(){

        if(!empty($_POST['id_product'])){
            $id = intval($_POST['id_product']);
            $qt = intval($_POST['qt_product']);

            if(!isset($_SESSION['cart'])){
                $_SESSION['cart'] = array();
            }

            if(isset($_SESSION['cart'][$id])){
                $_SESSION['cart'][$id] += $qt;
            }else{
                $_SESSION['cart'][$id] = $qt;
            }


        }

        header("Location: ".BASE_URL."cart");
        exit;

    }



    public function payment_redirect(){

        if(!empty($_POST['payment_type'])){
            $payment_type = $_POST['payment_type'];

            // retirar na loja
            if( isset($_POST['withdraw_store']) && !empty($_POST['withdraw_store']) ){
                $_SESSION['shipping'] = null;
                
                $op_insert = addslashes($_POST['op_insert']);

                if($op_insert == 'alpha'){

                    $_SESSION['op_insert'] = "Praça das Margaridas, 24 - Parque dos Camargos";
                }


            }

            switch($payment_type){
              
                case 'checkout_transparente':
                    header("Location: ".BASE_URL."psckttransparente");
                    exit;
                    break;

                case 'mp':
                    header("Location: ".BASE_URL."mp");
                    exit;
                    break;

                case 'boleto':
                    header("Location: ".BASE_URL."boleto");
                    exit;
                    break;    
            }



        }

        header("Location: ".BASE_URL."cart");
        exit;
        

    }




}