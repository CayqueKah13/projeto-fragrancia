<h1>Pagamento via Boleto</h1><br>

<?php if(!empty($result['message']) && $result['operation']=='fail'): ?>
	<div class="alert alert-warning" role="alert">
		<?php echo $result['message']; ?>
	</div>
<?php endif; ?>


<?php if(!empty($maxBoletosDay)): ?>
	<div class="alert alert-warning" role="alert">
		<?php echo $maxBoletosDay; ?>
	</div>
<?php endif; ?>

<div style="display:none;" id="preload">         
    <div id="statuspre">
        <img class="img-gif-center" src="<?php echo BASE_URL ?>assets/images/bargif.gif">
        <br><br><p style="text-align: center; font-size:12pt;">Aguarde enquanto o sistema<br> &ensp; emite o boleto de pagamento ...</p>      
    </div>
</div>	

<div class="panel panel-default">
	<div class="panel-heading">Estamos quase lá, agora é só preencher os dados</div>
	<div  class="panel-body">

		<?php if(isset($totDiscount) && !empty($totDiscount)): ?>
			<blockquote class="payment-form">
				Valor da Compra: <strong> R$ <?php echo number_format($total,2,',','.'); ?></strong><br><br>
				Taxa Emissão do boleto: <strong>R$ 1,00</strong>

				<br><br>
				<span style="font-size: 14pt;" class="label label-success">Total: R$ <?php echo number_format($totDiscount+1,2,',','.'); ?></span>
			</blockquote>
		<?php endif; ?>

		<div class="row">

			<form method="POST" id="formSubmit">
			<div class="col-md-4">
				<h3>Dados Pessoais</h3>
				<div class="payment-form">
					<strong>Seu Nome:</strong><br>
					<input type="text" name="nome" class="form-control com" required><br><br> 

					<strong>CPF:</strong><br>
					<input type="text" name="cpf" class="form-control com cpf" required><br><br> 

					<strong>E-mail:</strong><br>
					<input type="text" name="email" class="form-control com" required><br><br> 

					<strong>DDD:</strong>
					<strong style="margin-left: 10px;">Telefone:</strong><br>
					<input type="text" maxlength="2" name="ddd" style="width: 30px;" required>
					<input type="text" name="telefone" class="tel" style="width: 133px;" required><br><br> 

				</div>
			</div>

			
			<div class="col-md-4">
				<?php if(!empty($_SESSION['shipping'])): ?>
					<h3>Endereço de entrega</h3>
				<?php else: ?>
					<h3>Endereço</h3>
				<?php endif; ?>	
				<div class="payment-form">

					<strong>CEP:</strong><br>
					<input type="text" id="cep" name="cep" class="form-control com" required><br><br>

					<strong>Cidade:</strong><br>
					<input type="text" id="cidade" name="cidade" class="form-control com" required><br><br>
					
					<strong>Estado:</strong><br>
					<select id="estado" name="estado" class="form-control com" required>
					    <option value="">Selecione</option>
					    <option value="AC">Acre</option>
					    <option value="AL">Alagoas</option>
					    <option value="AP">Amapá</option>
					    <option value="AM">Amazonas</option>
					    <option value="BA">Bahia</option>
					    <option value="CE">Ceará</option>
					    <option value="DF">Distrito Federal</option>
					    <option value="ES">Espirito Santo</option>
					    <option value="GO">Goiás</option>
					    <option value="MA">Maranhão</option>
					    <option value="MS">Mato Grosso do Sul</option>
					    <option value="MT">Mato Grosso</option>
					    <option value="MG">Minas Gerais</option>
					    <option value="PA">Pará</option>
					    <option value="PB">Paraíba</option>
					    <option value="PR">Paraná</option>
					    <option value="PE">Pernambuco</option>
					    <option value="PI">Piauí</option>
					    <option value="RJ">Rio de Janeiro</option>
					    <option value="RN">Rio Grande do Norte</option>
					    <option value="RS">Rio Grande do Sul</option>
					    <option value="RO">Rondônia</option>
					    <option value="RR">Roraima</option>
					    <option value="SC">Santa Catarina</option>
					    <option value="SP">São Paulo</option>
					    <option value="SE">Sergipe</option>
					    <option value="TO">Tocantins</option>
					</select><br>

					<strong>Bairro:</strong><br>
					<input type="text" id="bairro" name="bairro" class="form-control com" required><br><br>  

				</div>
			</div>
	
			<div class="col-md-4">
				<div class="payment-form complement-form">

					<strong>Rua:</strong><br>
					<input type="text" id="rua" name="rua" class="form-control com" required><br><br>

					<strong>Número:</strong><br>
					<input type="text" name="numero" class="form-control com" required><br><br> 

					<strong>Complemento:</strong><br>
					<input type="text" name="complemento" class="form-control com"><br><br>

					<input type="hidden" name="hash">

					<input type="submit" class="efetuarCompra button" value="Finalizar Compra"> 
				</div>
			</div>

			</form>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/cep1.js"></script>

<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/jquery.mask.min.js"></script>

<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/maskformsboleto.js"></script>

<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>

<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/pagseguroboleto.js"></script>
