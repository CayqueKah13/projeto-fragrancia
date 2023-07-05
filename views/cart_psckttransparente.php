<style type="text/css">
.card-wrapper{
	display:none;
	position: fixed;
	margin-top: -30px;
	margin-left: 240px;
	z-index: 999;
}

@media only screen and (max-width: 600px) {
	.card-wrapper{
		display:none;
		position: fixed;
		margin-top: -500px;
		margin-left: 0px;
		z-index: 999;
	}
}
</style>

<div style="display:none;" id="preload">         
    <div id="statuspre">
        <img class="img-gif-center" src="<?php echo BASE_URL ?>assets/images/bargif.gif">
        <br><br><p style="text-align: center; font-size:12pt;">Aguarde enquanto o sistema<br> &ensp; processa o pagamento ...</p>      
    </div>
</div>


<div class="card-wrapper"></div>

<div   class="panel panel-default">
	<div class="panel-heading">Estamos quase lá, agora é só preencher os dados</div>
	<div class="panel-body">
	<div class="row">
		
		<div id="showErroPag" style="display: none;" class="alert alert-warning">
			<strong>Pagamento não realizado, pelo motivo abaixo:</strong>
			<div id="errorPagSeg"></div>
		</div>

		<div class="col-md-3">
			<h3 class="colours-form">Dados Pessoais</h3>
			<div class="payment-form">
				
				<strong>Nome:</strong><br>
				<input type="text" name="nome" required><br><br>

				<strong>E-mail:</strong>
				<!--<img src="<?php //echo BASE_URL; ?>assets/images/information.png" alt="information" data-toggle="tooltip" data-placement="bottom" title="E-mail de login neste site caso não tenha sera criado uma conta com essas informações."> -->
				<br>
				<input  type="email" name="email" required><br><br>

				<strong>CPF:</strong><br>
				<input type="text" class="cpf" name="cpf" required><br><br>

				<strong>DDD:</strong>
				<strong style="margin-left: 10px;">Telefone:</strong><br>
				<input type="text" maxlength="2" name="ddd" style="width: 30px;" required>
				<input type="text" class="tel" id="tel" name="telefone" style="width: 130px;" required><br><br>

			</div>
		</div>

		<div class="col-lg-3">
			<?php if(!empty($_SESSION['shipping'])): ?>
				<h3 class="colours-form">Endereço de entrega</h3>
			<?php else: ?>
				<h3 class="colours-form">Endereço</h3>
			<?php endif; ?>
			<div class="payment-form">

				<strong>CEP:</strong><br>
				<input type="text" id="cep" name="cep" required><br><br>

				<strong>Rua:</strong><br>
				<input type="text" id="rua" name="rua" required><br><br>

				<strong>Número:</strong><br>
				<input type="text" name="numero" required><br><br>

				<strong>Complemento:</strong><br>
				<input type="text" name="complemento"><br><br>

			</div>
		</div>

		<div class="col-lg-3">
			<div class="payment-form complement-form">

				<strong>Bairro:</strong><br>
				<input type="text" id="bairro" name="bairro" required><br><br>

				<strong>Cidade:</strong><br>
				<input type="text" id="cidade" name="cidade" required><br><br>

				<strong>Estado:</strong><br>
				<select id="estado" name="estado" required>
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
				</select>
			</div>
		</div>

		<div class="col-lg-3">
			<div style="margin-top: 56px;">
				<img src="<?php echo BASE_URL; ?>assets/images/banner-pagseguro.png">
			</div>
		</div>

	</div>


	<div class="row">

		<h3 class="tik-left colours-form">Informações de Pagamento</h3>

		<div class="col-md-6">
			<div id="form">
				<div class="payment-form">
					<strong>Número do cartão:</strong><br>
					<input type="text" id="cartao_numero" name="cartao_numero" required><br><br>

					<strong>Titular do cartão:</strong><br>
					<input type="text" id="cartao_titular" name="cartao_titular" required><br><br>

					<strong>Código de Segurança:</strong><br>
					<input type="text" id="cartao_cvv" name="cartao_cvv" required><br><br>
					<strong>Validade:</strong>
					<select id="cartao_mes" name="cartao_mes" required>
						<option value=""></option>
						<?php for($q=1;$q<=12;$q++): ?>
						<option><?php echo ($q<10)?'0'.$q:$q; ?></option>
						<?php endfor; ?>
					</select>
					<select name="cartao_ano" required>
						<option value=""></option>
						<?php $ano = intval(date('Y')); ?>
						<?php for($q=$ano;$q<=($ano+20);$q++): ?>
							<option><?php echo $q; ?></option>
						<?php endfor; ?>
					</select>
					<br><br>

					<strong>Parcelas:</strong><br>
					<select name="parc" required></select><br><br>

					<input type="hidden" name="total" value="<?php echo $total; ?>">
					
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="payment-form">

				<strong>CPF do Titular do cartão:</strong><br>
				<input type="text" class="cpf" name="cartao_cpf" required><br><br>

				<strong>Data de Nascimento do titular do cartão:</strong><br>
				<input type="text" id="cartao_date" name="cartao_date" required><br><br>

				<strong>DDD:</strong>
				<strong style="margin-left: 10px;">Telefone do titular do cartão:</strong><br>
				<input type="text" name="cartao_ddd" style="width: 30px;" required>
				<input type="text" class="tel" id="cartao_tel" name="cartao_tel" style="width: 130px;" required><br><br>

				<button class="efetuarCompra button">Finalizar Compra</button><br><br>
				<div class="ps-payment-processed">
					<p>Pagamento processado pelo 		
					<img src="<?php echo BASE_URL; ?>assets/images/pag-mini.png" alt="PagSeguro UOL">
					</p>
				</div>
			</div>
		</div>
	</div>
	</div>
</div>

<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/cep1.js"></script>

<!--  SCRIPTS MASKS -->
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/jquery.mask.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/card.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/maskforms.js"></script>
<!--  SCRIPTS MASKS -->

<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js "></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/psckttransparente1.js"></script>
<script type="text/javascript">
	PagSeguroDirectPayment.setSessionId("<?php echo $sessionCode; ?>");
</script>
