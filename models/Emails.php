<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Emails extends model {

    private $mail;

    public function __construct(){

        $this->mail = new PHPMailer(true);
    }

    public function signConfirm($options){
         try {
            
            $this->mail->SMTPDebug = 0;                               
            $this->mail->isSMTP();                                    

            $this->mail->setLanguage('pt-br');
            $this->mail->CharSet= "utf8";

            $this->mail->Host = 'br950.hostgator.com.br';//'mail.pnegocios.com.br';                               
            $this->mail->Username = 'loja@fragranciaewine.com.br';//'teste@pnegocios.com.br';                 
            $this->mail->Password = 'iXKra]hwPgmi';//'teste123';
            $this->mail->SMTPAuth = true;                            
            $this->mail->SMTPSecure = 'ssl';                           
            $this->mail->Port = 465;                                   

            $this->mail->isHTML(true);

            $this->mail->setFrom($this->mail->Username,$options['name_company']);
            $this->mail->addAddress($options['address_email'],$options['nome']);
         
            $this->mail->Subject = $options['subject'];
                
            $url = $options['url'];    
            $this->mail->Body = $this->msgConfirm($options['address_email'],$url,$options['nome'],$options['name_company']);
           
            
            return $this->mail->send();

        }catch (Exception $e) {
            echo "Message could not be sent. Mailer Error:".$this->mail->ErrorInfo;
        }
    }

    private function msgConfirm($email,$url,$nome,$name_company){
        $postdata = http_build_query(
            array(
                'email' => $email,
                'url' => $url,
                'nome'=>$nome,
                'company'=> $name_company,
                'baseUrl' => BASE_URL
            )
        );

        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );

        $context  = stream_context_create($opts);

        $result = file_get_contents(BASE_URL."assets/template-email/styleConfirm.php", false, $context);

        return $result;
    }



    /*  E-MAIL DE RECUPERAÇÃO DE SENHA */
 	public function send($options){
                  
        try {
            
            $this->mail->SMTPDebug = 0;                               
            $this->mail->isSMTP();                                    

            $this->mail->setLanguage('br');
            $this->mail->CharSet= "utf8";

            $this->mail->Host = 'br950.hostgator.com.br';//'mail.pnegocios.com.br';                               
            $this->mail->Username = 'loja@bazarandre.com.br';//'teste@pnegocios.com.br';                 
            $this->mail->Password = 'iXKra]hwPgmi';//'teste123';
            $this->mail->SMTPAuth = true;                            
            $this->mail->SMTPSecure = 'ssl';                           
            $this->mail->Port = 465;                                   

            $this->mail->isHTML(true);

            $this->mail->setFrom($this->mail->Username,$options['name_company']);
            $this->mail->addAddress($options['address_email'],'Cliente');
         
            $this->mail->Subject = $options['subject'];
                
            $url = $options['url'];    
            $this->mail->Body = $this->msgRedefinir($options['address_email'],$url,$options['nome']);
           
            
            return $this->mail->send();


        }catch (Exception $e) {
            echo "Message could not be sent. Mailer Error:".$this->mail->ErrorInfo;
        }


    }


    public function msgRedefinir($email,$url,$nome){


        $postdata = http_build_query(
            array(
                'email' => $email,
                'url' => $url,
                'nome'=>$nome,
                'baseUrl' => BASE_URL
            )
        );

        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );

        $context  = stream_context_create($opts);

        $result = file_get_contents(BASE_URL."assets/template-email/styleForgot.php", false, $context);

        return $result;


    }


   



}
