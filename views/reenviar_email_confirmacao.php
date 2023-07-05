<link href="<?php echo BASE_URL; ?>assets/css/login1.css" rel="stylesheet"> 
<script src='https://www.google.com/recaptcha/api.js'></script>

<div class="container">
  <div class="row">
    <div class="col-md-4"></div>

    <div class="col-md-4">

      <?php if(!empty($cadSuccess)): ?>
        <div class="alert alert-success" role="alert">
          <strong>
            <?php echo $cadSuccess; ?>
          </strong>
        </div>
      <?php endif; ?>

      <?php if(!empty($emailNotFound)): ?>
        <div class="alert alert-warning" role="alert">
          <strong>
            <?php echo $emailNotFound; ?>
          </strong>
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
          <h1>Reenviar de e-mail<br><br>
            <small>Digite seu e-mail para receber a mensagem de confirmação de conta</small></h1><br>

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