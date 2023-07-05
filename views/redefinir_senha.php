<link href="<?php echo BASE_URL; ?>assets/css/login1.css" rel="stylesheet"> 

<div class="container">
  <div class="row">
    <div class="col-md-4"></div>

    <div class="col-md-4">
      <?php if(!empty($success)): ?>
        <div class="alert alert-success" role="alert"><?php echo $success; ?></div>
      <?php endif; ?>

      <?php if(!empty($passEquals)): ?>
        <div class="alert alert-danger" role="alert"><?php echo $passEquals; ?></div>
      <?php endif; ?>
      <div class="logbox">
        <form class="signup" method="post">
          <h1>Redefina sua senha</h1><br>
          <div>
            <input name="password" type="password" placeholder="Digite sua nova senha" class="input pass" required/>
            <input name="password2" type="password" placeholder="Confirme sua nova senha" class="input pass" required> 
          </div>
          <input type="submit" value="Trocar de senha" class="inputButton"/>
        </form>
      </div><br>

    </div>

    <div class="col-md-4"></div>
  </div>
</div>