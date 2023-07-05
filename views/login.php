<link href="<?php echo BASE_URL; ?>assets/css/login1.css" rel="stylesheet"> 

<?php if(isset($_GET['boleto']) && !empty($_GET['boleto']) && $_GET['boleto']=='redirect'): ?>

  <div class="alert alert-info alert-position" role="alert">
    <strong>Estamos quase lá</strong>, para que você possa adquirir algum de nossos produtos pelo site é preciso que você esteja logado.
  </div>
<?php endif; ?>

<?php if(isset($_GET['card']) && !empty($_GET['card']) && $_GET['card']=='redirect'): ?>
  <div id="redirect"  class="alert alert-info alert-position" role="alert">
    <strong>Estamos quase lá</strong>, para que você possa adquirir algum de nossos produtos pelo site é preciso que você esteja logado.
  </div>
<?php endif; ?>

<?php if(isset($error) && !empty($error)): ?>
    <div class="alert alert-warning alert-position" role="alert">
      <strong>
      <?php echo $error; ?>  
      </strong>
    </div>
<?php endif; ?>

<div class="container">
  <div class="row">
    <div class="col-md-4"></div>

    <div class="col-md-4">

      <div class="logbox">
        <form class="signup" method="post">
          <h1>Faça o seu login</h1>

          <div>
            <input name="email" type="email" placeholder="Digite seu e-mail" class="input pass" required/>
            <input name="password" type="password" placeholder="Digite sua senha" required="required" class="input pass"/>
          </div>

          <input type="submit" value="Entrar" class="inputButton"/>
          <div class="text-center">
            <a href="<?php echo BASE_URL; ?>login/sign">Crie sua conta</a>
          </div>
        </form>
      </div>
      <br>
      <a style="float:right;" href="<?php echo BASE_URL; ?>login/forgot">Esqueci minha senha</a>

    </div>

    <div class="col-md-4"></div>
  </div>
</div>