<table class="row">
        <tr>
          <td class="wrapper last">

            <table class="twelve columns">
              <tr>
                <td>

                  <h1>Olá, <?php echo $_POST['nome']; ?></h1>
                  <p class="lead">Você solicitou a redefinição de senha para seu acesso ao site da Fast Wine Bebidas e Serviços.</p>
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

                  <h3>Dados do cadastro</h3><hr>

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
                        Para alterar sua senha e poder acessar sua conta, clique no link abaixo Redefinir senha dentro de até 24 horas.
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
                          <a href="<?php echo $_POST['url']; ?>">Redefinir senha</a>
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

                  <strong>Caso você não tenha solicitado a redefinição de senha desconsidere este e-mail,</strong><br><br>
                  <strong>Não responda este e-mail, ele foi enviado automaticamente pelo sistema.</strong>


                <td class="expander"></td>
              </tr>
            </table>

          </td>
         
        </tr>
</table>