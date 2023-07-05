<?php
class purchasesController extends controller {

    private $user;

    public function __construct() {
        parent::__construct();

        $this->user = new Users();

        if(!$this->user->isLogged()){
            header("Location: ".BASE_URL);
            exit;
        }
    }

    public function index() {
        $dados = array();
        $store = new Store();
        $purchase = new Purchases();

        $dados = $store->getTemplateData();

        $dados['searchTerm'] = '';
        $dados['category'] = '';

        $dados['pag'] = array('currentpage'=>0, 'total'=>0, 'per_page'=>10);
        if(!empty($_GET['p'])){
            $dados['pag']['currentpage'] = intval($_GET['p']) - 1;
        }

        $dados['pag']['total'] = $purchase->getTotMyPurchases($_SESSION['ccUser']);

        $dados['list'] = $purchase->getMyPurchases($_SESSION['ccUser'],$dados['pag']);
        
       $this->loadTemplate("purchases",$dados);
    }


    public function ajax(){

        if(!empty($_POST['id_purchase'])){

            $p = new Purchases();

            $id_purchase=$_POST['id_purchase'];
            $id_user=$_SESSION['ccUser'];

            $data = $p->getAjaxPurchase($id_purchase,$id_user);

            echo json_encode($data);
        }
    }
   



}