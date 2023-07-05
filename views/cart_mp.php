<h1>Checkout Mercado Pago</h1>

<?php if(!empty($error)): ?>
	<div class="warn">
		<?php echo $error; ?>
	</div>
<?php endif; ?>

<h3>Dados Pessoais</h3>

<form method="POST">
	<strong>Nome:</strong><br>
	<input type="text" name="nome" value="Bonierky Lacerda"><br><br>

	<strong>CPF:</strong><br>
	<input type="text" name="cpf" value="46981323800"><br><br>

	<strong>Telefone:</strong><br>
	<input type="text" name="telefone" value="8399999999"><br><br>

	<strong>E-mail:</strong><br>
	<input type="text" name="email" value="teste@mp.com.br"><br><br>

	<strong>Senha:</strong><br>
	<input type="text" name="pass" value="123"><br><br>

	<h3>Informações de Endereço</h3>

	<strong>Titular do cartão:</strong><br>
	<input type="text" name="cartao_titular" value="Bruno Lucio"><br><br>

	<strong>CPF do Titular do cartão:</strong><br>
	<input type="text" name="cartao_cpf" value="46981323800"><br><br>

	<strong>CEP:</strong><br>
	<input type="text" name="cep" value="58410340"><br><br>

	<strong>Rua:</strong><br>
	<input type="text" name="rua" value="Rua Bla"><br><br>

	<strong>Número:</strong><br>
	<input type="text" name="numero" value="1400"><br><br>

	<strong>Complemento:</strong><br>
	<input type="text" name="complemento"><br><br>

	<strong>Bairro:</strong><br>
	<input type="text" name="bairro" value="cat"><br><br>

	<strong>Cidade:</strong><br>
	<input type="text" name="cidade" value="sp"><br><br>

	<strong>Estado:</strong><br>
	<input type="text" name="estado" value="SP"><br><br>


	<input type="submit" class="efetuarCompra button" value="Efetuar Compra">
</form>