<link href="<?php echo BASE_URL; ?>assets/css/login1.css" rel="stylesheet"> 

<div class="container">
  <div class="row">
    <div class="col-md-4"></div>

    <div class="col-md-4">
      <?php if(!empty($response) && !$response['error']): ?>
        <div class="alert alert-success" role="alert"><strong><?php echo $response['msg']; ?></strong></div>

      <?php elseif(!empty($response) && $response['error']):  ?>

        <div class="alert alert-danger" role="alert"><strong><?php echo $response['msg']; ?></strong></div>      
      <?php endif; ?>

      <div class="logbox">
        <form class="signup" method="post">
          <h1>Trocar sua senha</h1><br>
          <div>

            <input name="password_current" type="password" placeholder="Digite sua senha atual" class="input pass" required/>
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