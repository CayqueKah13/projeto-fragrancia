<table class="row">
        <tr>
          <td class="wrapper last">

            <table class="twelve columns">
              <tr>
                <td>

                  <h1>Bem-vindo(a) <?php echo $_POST['nome']; ?> a nossa loja online <?php echo $_POST['company']; ?></h1>
                  <p class="lead">Confirme seu cadastro conosco</p>
                </td>
                <td class="expander"></td>
              </tr>
            </table>

          </td>
        </tr>
      </table>
<br>
      <table class="row">
        <tr>
          <td class="wrapper last">

            <table class="twelve columns">
              <tr>
                <td>

                  <h3>Dados de cadastro</h3><hr>

                </td>
                <td class="expander"></td>
              </tr>
            </table>

            <table class="twelve columns">
                <td>
                    <p>
                        Seu login é <strong><?php echo $_POST['email']; ?></strong>
                    </p>
                    <p>
                        Para confirmar seu cadastro em nosso site clique no link abaixo confirmar cadastro.
                    </p>
                </td>
                <td class="expander"></td>
            </table>

          </td>
        </tr>
      </table>


      <table class="row">
        <tr>
          <td class="wrapper offset-by-four last">

            <table class="five columns">
              <tr>
                <td>

                  <table class="button large-button success radius">
                    <tr>
                      <td>
                          <a href="<?php echo $_POST['url']; ?>">Confirmar cadastro</a>
                      </td>
                    </tr>
                  </table>

                </td>
                <td class="expander"></td>
              </tr>
            </table>

          </td>
        </tr>
      </table>

      <br><br>
      <table class="row footer">
        <tr>
          <td class="wrapper">

            <table class="six columns">
              <tr>
                <td class="left-text-pad">
                
                  <strong>Não responda este e-mail, ele foi enviado automaticamente pelo sistema.</strong>

                <td class="expander"></td>
              </tr>
            </table>

          </td>
         
        </tr>
</table>