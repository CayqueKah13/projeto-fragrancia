<?php
class pagesController extends controller {

	private $user;

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        
        header("Location: ".BASE_URL);
    }

    public function privacy(){
    	$store = new Store();
        $products = new Products();
        $categories = new Categories();
        $pages = new Pages();

        $dados = $store->getTemplateData();
        $dados['searchTerm'] = '';
        $dados['category'] = '';

        $dados['list']=$pages->get(3);

        $this->loadTemplate('page', $dados);
    }

    public function terms(){
    	$store = new Store();
        $products = new Products();
        $categories = new Categories();
        $pages = new Pages();

        $dados = $store->getTemplateData();
        $dados['searchTerm'] = '';
        $dados['category'] = '';

        $dados['list']=$pages->get(4);

        $this->loadTemplate('page', $dados);
    }

    public function devolution(){
    	$store = new Store();
        $products = new Products();
        $categories = new Categories();
        $pages = new Pages();

        $dados = $store->getTemplateData();
        $dados['searchTerm'] = '';
        $dados['category'] = '';

        $dados['list']=$pages->get(5);

        $this->loadTemplate('page', $dados);
    }



    public function who(){
        $store = new Store();
        $products = new Products();
        $categories = new Categories();
        $pages = new Pages();

        $dados = $store->getTemplateData();
        $dados['searchTerm'] = '';
        $dados['category'] = '';

        $this->loadTemplate('quem_somos', $dados);
    }

    /*
    public function api(){
        
        $array = [];
        $method = strtolower($_SERVER['REQUEST_METHOD']);

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");
        header("Content-Type: application/json");

        if($method === 'post'){

            $file = $_FILES['arquivo'];
            $array['result']= $file;
     
        
            if(isset($file['tmp_name']) && !empty($file['tmp_name'])){

                //== "application/vnd.ms-excel"
                if($file['type']){

                    move_uploaded_file($file['tmp_name'],'./assets/csv/estoque.csv');


                    if(file_exists('./assets/csv/estoque.csv')){

                        $this->readInsertCsv();

                    }
                    
                }else{
                    $array['error'] = "Arquivo deve estar no formato CSV";
                }
            } 

        }else{
            $array['error'] = "Metodo nao permitido (Apenas POST)";
        }

        echo json_encode($array);
        exit;

    } */




}