<?php
class productController extends controller {

	private $user;

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        
        header("Location: ".BASE_URL);
    }



    public function open($id){
        if(!isset($_SESSION['csrf_token'])){
            $_SESSION['csrf_token'] = md5(time().rand(0,9999));
        }

        $store = new Store();
        $products = new Products();
        $categories = new Categories();
        $rates = new Rates();

        $dados = $store->getTemplateData();

        
        $info = $products->getProductInfo($id);
        if(count($info) > 0){

            if( !empty($_POST['title_rate']) && !empty($_POST['text_rate']) 
                && !empty($_POST['star_rate']) ){

                $title_rate = $_POST['title_rate'];
                $text_rate = $_POST['text_rate'];
                $star_rate = $_POST['star_rate'];

                if(!empty($_SESSION['ccUser']) && $_POST['csrf_token'] == $_SESSION['csrf_token'] ){
                  
                    $rates->insert($id,$_SESSION['ccUser'],$title_rate,$text_rate,$star_rate);
                }else{
                
                    $dados['login_comment'] = "Você precisa estar logado no site para pode comentar";
                }
            }
                
            

            $dados['product_info'] = $info;
            $dados['product_images'] = $products->getImagesByProductId($id);
            $dados['product_options'] = $products->getOptionsByProductId($id);
            $dados['product_rates'] = $products->getRates($id,5);

            $dados['searchTerm'] = '';
            $dados['category'] = '';

            $dados['banner'] = true;

            $this->loadTemplate('product', $dados);
        }else{

            header("Location: ".BASE_URL);
        }


    }



}