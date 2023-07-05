<?php

class loginController extends controller{

        public function __construct() {
            parent::__construct();
        }

        public function index(){

          $dados = array();

          $store = new Store();
          $u = new Users();
          $cart = new Cart();

          $dados = $store->getTemplateData();
          $dados['searchTerm'] = '';
          $dados['category'] = '';
          $dados['error'] = '';

          if( !empty($_POST['email']) && !empty($_POST['password']) ){

        
            $email = $_POST['email'];
            $pass = $_POST['password'];

            $response=$u->doLogin($email,$pass);

              if($response['success']){

                if(!empty($_GET['boleto']) && $_GET['boleto']=='redirect'){
                
                    header("Location: ".BASE_URL."boleto");
                    exit;

                }else if(!empty($_GET['card']) && $_GET['card']=='redirect'){
               

                    header("Location: ".BASE_URL."psckttransparente");
                    exit;

                }else{

                    header("Location: ".BASE_URL);
                    exit;
                }

              }else{
                  $dados['error'] = $response['msg'];
              }


          }
       

          $this->loadTemplate("login",$dados);

        }

        public function sign(){

            $dados = array();

            $store = new Store();
            $u = new Users();
            $cart = new Cart();
            $mailer = new Emails();

            $dados = $store->getTemplateData();
            $dados['searchTerm'] = '';
            $dados['category'] = '';
            $dados['error'] = '';


           if( !empty($_POST['name']) && !empty($_POST['password']) && !empty($_POST['email']) &&
               !empty($_POST['password2']) ){
                
                $name = $_POST['name'];
                $password = $_POST['password'];
                $password2 = $_POST['password2'];
                $email = $_POST['email'];


                if($password == $password2){

                    if(!$u->emailExists($email)){

                        $captcha = addslashes($_POST['g-recaptcha-response']);
                        if(!empty($captcha) && isset($captcha)){

                             $secret_key_cap = '6LeDkV0UAAAAACloB5-WODnyFE7N17QKlONy0nuC';
                             $ip = $_SERVER['REMOTE_ADDR'];

                             // No futuro fazer a linha debaixo ser requisitada com cURL.
                             $var = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret_key_cap&response=$captcha&remoteip=$ip");
                             $respi=json_decode($var,true);

                             if($respi){
                                global $config;

                                $hash=md5(time()."*e5387d*e4d#355#@##d_E84e6");

                                $u->createUser($name,$email,$password,$hash);

                                $assunto = "Clique no link para confirma seu cadastro conosco!";

                                $options = array(              
                                    "address_email" => $email,
                                    "name_company"=> $config['name_company'],
                                    "subject"=> $assunto,
                                    "nome"=> $name,
                                    "url" => BASE_URL."login/confirm?cad=".$hash
                                );

                               
                                $mailer->signConfirm($options);
                                $page_resend = BASE_URL."login/resend";
                                $dados['cadSucess']="Sua conta foi criada com sucesso!<br><br>";
                                /* $dados['cadSucess']="Sua conta foi criada com sucesso!,<br><br> Foi enviado um e-mail para que você confirme seu cadastro, caso não encontre a mensagem verifique na caixa de spam,<br><br>Caso queira receber novamente a confirmação de e-mail <a href=".$page_resend.">Clique Aqui</a>."; */
                             }


                        }else{
                             $dados['reCaptcha'] = "Por favor clique no -> Não sou um robô";
                        }


                    }else{
                        $dados['emailExists'] = "Este e-mail já esta cadastrado em nosso site por favor escolha outro";
                    }

                }else{

                    $dados['passNot'] = "As senhas digitas não conferem, elas devem ser iguais";    
                }

           }

           $this->loadTemplate("cadastro",$dados);

        }

      public function confirm(){
        $dados = array();
        $store = new Store();
        $u = new Users();
        $cart = new Cart();

        $dados = $store->getTemplateData();
        $dados['searchTerm'] = '';
        $dados['category'] = '';
        $dados['error'] = '';

        if(!empty($_GET['cad'])){
      
            if($u->confirmEmail($_GET['cad'])){
              $dados['response'] = array("error"=>false, "msg"=>"Sua Conta foi confirmada com sucesso! <br>agora você já consegue logar em nosso site");
            }else{
              $dados['response'] = array("error"=>true, "msg"=>"Erro ao confirmar conta");
            }

        }


        $this->loadTemplate("confirmar_email",$dados);

      } 


      public function forgot(){
        /* FORGOT MY PSSWORD */

        $dados = array();

        $store = new Store();
        $u = new Users();
        $mailer = new Emails();

        $dados = $store->getTemplateData();
        $dados['searchTerm'] = '';
        $dados['category'] = '';
        $dados['error'] = '';

        if(isset($_POST['email']) && !empty($_POST['email'])){

          $email = addslashes($_POST['email']);
          $assunto="Redefinição de senha";

          $captcha = addslashes($_POST['g-recaptcha-response']);
          
          if(!empty($captcha) && isset($captcha)){

              $secret_key_cap = '6LeDkV0UAAAAACloB5-WODnyFE7N17QKlONy0nuC';
              $ip = $_SERVER['REMOTE_ADDR'];

              // No futuro fazer a linha debaixo ser requisitada com cURL.
              $var = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret_key_cap&response=$captcha&remoteip=$ip");
              $respi=json_decode($var,true);

              if($respi){

                  $response=$u->tokenForgot($email);
                  if($response['response']){

                    global $config;

                    $options = array(              
                        "address_email" => $email,
                        "name_company"=> $config['name_company'],
                        "subject"=> $assunto,
                        "nome"=> $response['nome'],
                        "url" => $response['url']
                    );

                   
                    $ok=$mailer->send($options);

                    if($ok){
                      $dados['response_email']="ok";
                    }else{
                      $dados['response_email']="not";
                    }

                  }else{
                    $dados['dont_exist']="Este e-mail não esta cadastrado em nosso site, por favor digite um e-mail cadastrado";
                  }

              }

          }else{

            $dados['errorRecaptcha'] = "Por favor clique no -> Não sou um robô";
          }


          
        }


        $this->loadTemplate("esqueci_senha",$dados);
      }

      public function reset(){
        $dados = array();

        $store = new Store();
        $u = new Users();

        $dados = $store->getTemplateData();
        $dados['searchTerm'] = '';
        $dados['category'] = '';
        $dados['error'] = '';

        if(!empty($_GET['token'])){
          $token = $_GET['token'];

          $result=$u->tokenExists($token);

          if(!empty($_POST['password']) && !empty($_POST['password2'])){

            $pass = addslashes($_POST['password']);
            $pass2 = addslashes($_POST['password2']);
   
            if($result['response']){

              $r = $u->changePassword($pass,$pass2,$result['id_user']);
              if($r){

                $u->usedTokenForgot($token);
                $dados['success'] = "Senha alterada com sucesso!";
              }else{
                $dados['passEquals'] = "As 2 senhas nos campos abaixo devem ser iguais";
              }

            }

          }

          if($result['response']){
            $this->loadTemplate("redefinir_senha",$dados);
          }else{
            $this->loadTemplate("token_invalido",$dados);
          }

        }else{
          $this->loadTemplate("token_invalido",$dados);
        }



      }


      public function change(){

        $dados = array();

        $u = new Users();

        if(!$u->isLogged()){
            header("Location: ".BASE_URL);
            exit;
        }

        $store = new Store();
        $cart = new Cart();

        $dados = $store->getTemplateData();
        $dados['searchTerm'] = '';
        $dados['category'] = '';
        $dados['error'] = '';

        if( !empty($_POST['password_current']) && !empty($_POST['password']) 
            && !empty($_POST['password2']) ){

              $id_user = $_SESSION['ccUser'];
              $password_current = $_POST['password_current'];
              $password = $_POST['password'];
              $password2 = $_POST['password2'];

              if($u->validateCurrentPass($id_user,$password_current)){

                  if($u->changePassword($password,$password2,$id_user)){
                    $dados['response'] = array("error"=>false, "msg"=>"Senha trocada com sucesso");
                  }else{
                    $dados['response'] = array("error"=>true, "msg"=>"A Nova senha deve coincidir com a confirmação");
                  }

              }else{
                  $dados['response'] = array("error"=>true, "msg"=>"Senha atual esta incorreta");
              }
        }


        $this->loadTemplate('trocar_senha',$dados);
      }


      public function resend(){
        $dados = array();
        $info = array();

        $store = new Store();
        $cart = new Cart();
        $u = new Users();
        $mailer = new Emails();

        $dados = $store->getTemplateData();
        $dados['searchTerm'] = '';
        $dados['category'] = '';
        $dados['error'] = '';

        if(!empty($_POST['email'])){

          $email = $_POST['email'];

          $captcha = addslashes($_POST['g-recaptcha-response']);
          if(!empty($captcha) && isset($captcha)){

               $secret_key_cap = '6LeDkV0UAAAAACloB5-WODnyFE7N17QKlONy0nuC';
               $ip = $_SERVER['REMOTE_ADDR'];

               // No futuro fazer a linha debaixo ser requisitada com cURL.
               $var = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret_key_cap&response=$captcha&remoteip=$ip");
               $respi=json_decode($var,true);

               if($respi){
                  global $config;

                  $info = $u->getInfoEmail($email);

                  $assunto = "Clique no link para confirma seu cadastro conosco!";

                  if(!empty($info)){
                      $options = array(              
                          "address_email" => $email,
                          "name_company"=> $config['name_company'],
                          "subject"=> $assunto,
                          "nome"=> $info['name'],
                          "url" => BASE_URL."login/confirm?cad=".
                          $info['hash_confirm_email']
                      );

                 
                    $mailer->signConfirm($options);

                    $dados['cadSuccess']="Foi enviado um e-mail para que você confirme seu cadastro, caso não encontre a mensagem verifique na caixa de spam";
                  }else{

                    $dados['emailNotFound'] = "E-mail não encontrado em nosso site";
                  }

                  
               }

          }else{

            $dados['errorRecaptcha'] = "Por favor clique no -> Não sou um robô";
          }

        }

        $this->loadTemplate("reenviar_email_confirmacao",$dados);
      }


      public function exit(){

        unset($_SESSION['ccUser']);
        header("Location: ".BASE_URL);
        exit;
      }

}