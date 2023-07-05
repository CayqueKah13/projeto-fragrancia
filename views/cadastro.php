
<link href="<?php echo BASE_URL; ?>assets/css/login1.css" rel="stylesheet">

<script src='https://www.google.com/recaptcha/api.js'></script>


<?php if(isset($emailExists) && !empty($emailExists)): ?>
    <div class="alert alert-danger alert-position" role="alert"><strong><?php echo $emailExists; ?></strong></div>
<?php endif; ?>

<?php if(isset($passNot) && !empty($passNot)): ?>
  <div class="alert alert-danger alert-position" role="alert"><strong><?php echo $passNot; ?></strong></div>
<?php endif; ?>

<?php if(isset($reCaptcha) && !empty($reCaptcha)): ?>
  <div class="alert alert-danger alert-position" role="alert"><strong><?php echo $reCaptcha; ?></strong></div>
<?php endif; ?>

 <?php if(isset($cadSucess) && !empty($cadSucess)): ?>
  <div class="alert alert-success alert-position" role="alert"><strong><?php echo $cadSucess; ?></strong></div>
<?php endif; ?>

<div class="container">
  <div class="row">

    <div class="col-md-4"></div>

    <div class="col-md-4">
      <div class="logbox">
        <form class="signup" method="POST">
          <h1>Crie sua conta</h1>

          <input name="name" type="text" placeholder="Qual seu nome ?" autofocus="autofocus" required="required" class="input pass"/>
          <input name="email" type="email" placeholder="Digite seu E-mail" class="input pass" required/>
          <input name="password" type="password" placeholder="Escolha uma senha" required="required" class="input pass"/>
          <input name="password2" type="password" placeholder="Confirme a sua senha" required="required" class="input pass"/>
          
          <br>
          <div class="g-recaptcha"  style="width: 302px;
          margin: auto;" data-sitekey="6LeDkV0UAAAAAJ3EEWm-nJzLgI2jOyOSq8CqHz6r"></div>

          <input type="submit" value="Cadastrar-se!" class="inputButton"/>


          <div class="text-center">
              Você já possui uma conta? <a href="<?php echo BASE_URL; ?>login" id="login_id">login</a>
          </div>
        </form>
      </div>
    </div>

    <div class="col-md-4"></div>

  </div>
</div>

