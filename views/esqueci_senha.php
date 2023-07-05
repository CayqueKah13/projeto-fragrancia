<link href="<?php echo BASE_URL; ?>assets/css/login1.css" rel="stylesheet"> 
<script src='https://www.google.com/recaptcha/api.js'></script>

<div class="container">
  <div class="row">
    <div class="col-md-4"></div>

    <div class="col-md-4">

      <?php 
      if(!empty($response_email)): 

              if($response_email=="ok"):             ?>
          <div class="alert alert-info">
            <strong>Foi enviado um e-mail!</strong> Acesse seu e-mail e clique no link para redefinir sua senha
          </div>
        <?php endif; 

            if($response_email=="not"):
        ?>
        <div class="alert alert-info">
          <strong>Erro</strong> ao enviar e-mail
        </div>
      <?php endif; 

      endif; ?>

      <?php if(!empty($dont_exist)): ?>
        <div class="alert alert-info">
          <?php echo $dont_exist; ?>
        </div>
      <?php endif; ?>

      <?php if(!empty($errorRecaptcha)): ?>
        <div class="alert alert-warning" role="alert">
          <strong>
            <?php echo $errorRecaptcha; ?>
          </strong>
        </div>
      <?php endif; ?>

      <div class="logbox">
        <form class="signup" method="post">
          <h1>Recupere sua senha<br><br>
            <small>Digite seu e-mail para que possamos redefinir sua senha</small></h1><br>

          <div>
            <input name="email" type="email" placeholder="E-mail" class="input pass" required/>
          </div><br>

          <div class="g-recaptcha"  style="width: 302px;
          margin: auto;" data-sitekey="6LeDkV0UAAAAAJ3EEWm-nJzLgI2jOyOSq8CqHz6r"></div>


          <input type="submit" value="Enviar Mensagem" class="inputButton"/>
        </form>
      </div><br>

    </div>

    <div class="col-md-4"></div>
  </div>
</div>