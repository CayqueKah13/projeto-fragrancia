<link href="<?php echo BASE_URL; ?>assets/css/cart.css" rel="stylesheet">
<h1 class="txt-cart">Carrinho de compras</h1>		
		
<a href="<?php echo BASE_URL; ?>" class="abutton" style="margin-top:-6px; float: right;">Voltar na loja</a>		

<!-- **Retirar na loja ou escolher frete** -->
<div style="margin-top: 40px; display:none;" class="row">
	<div class="col-md-6 col-md-offset-4">
		<div>
			<div style="text-align:center; width: 310px;">
				<h1>O que você prefere?</h1><br>
			</div>
			<label for="store">
			    <div class="thumbnail store-thumb">

					<input id="store" type="radio" name="choiceReceipt" value="store"><br>
					<p>Retirar produto(s) em alguma das lojas</p>
			      	<img src="<?php echo BASE_URL; ?>assets/images/store.png" alt="...">
			    </div>
			</label>

			<label for="delivery">
				<div class="thumbnail delivery-thumb">
					<input id="delivery" type="radio" name="choiceReceipt" value="delivery"><br><p>Entregar produto(s) para você</p>
					
			      	<img src="<?php echo BASE_URL; ?>assets/images/delivery.png" alt="...">
			    </div>
			</label>
	
			
		</div>

	</div>
</div>

<div style="display: none;" id="endereco_option" class="row">
	<div class="col-md-6 col-md-offset-4">
		
		<?php if(!empty($stores_available)):

			echo "<strong>Escolhendo essa Opção é necessario que você leve seu documento CPF para retirar o produto e código da compra que estara disponível em minhas compras após você efetuar o pagamento.</strong><br><br>";
				foreach($stores_available as $sa):

					echo "<div class='alert alert-info'> Do Produto <strong>".$sa['titulo']."</strong><br><br>";
					echo "Em Barueri temos ".$sa['estoque_qtd']. " unidade(s) na loja.<br> </div>";
		
				endforeach; ?>

				<strong>Você pode retirar os produtos na seguinte loja:</strong><br><br>
							
				<input type="radio" name="opStore" value="alpha" id="alpha"> <label for="alpha">Barueri</label> Endereço: Praça das Margaridas, 24 - Parque dos Camargos 
						<br>


		<?php endif; ?>
		
			
			
			


		
	</div>
</div> 


<div style="padding: 10px; margin-top: 40px;" class="table-responsive">
<table class="table table-bordered">
	<tr>
		<th>Imagem</th>
		<th>Nome</th>
		<th width="20">Qtd.</th>
		<th width="120">Preço</th>
	</tr>
	<?php $subtotal=0; ?>
	<?php foreach($list as $item): ?>
	<?php $subtotal += (floatval($item['price']) * intval($item['qt'])); ?>
	<tr>	
		<td style="padding:3px 0px 3px 0px;"><img src="<?php echo BASE_URL; ?>media/products/<?php echo $item['image']; ?>" width="80"></td>
		<td ><?php echo $item['name']; ?></td>
		<td width="20"><?php echo $item['qt']; ?></td>
		<td width="120">R$ <?php echo number_format($item['price'],2,',','.'); ?></td>
		<td><a href="<?php echo BASE_URL; ?>cart/del/<?php echo $item['id']; ?>"><img src="<?php echo BASE_URL; ?>assets/images/delete.png" width="20"></a></td>
	</tr>	
	<?php endforeach; ?>
	<tr>
		
		<td colspan="3" align="right">Sub-total: &nbsp;</td>
		<td><strong> R$ <?php echo number_format($subtotal,2,',','.'); ?></strong></td>
	</tr>

	<?php if(isset($shipping['price'])): ?>	
	<tr>
		<td colspan="3" align="right">
			Frete: &nbsp;
		</td>
		<td>
			<strong>R$ <?php echo $shipping['price']; ?></strong> (<?php echo $shipping['date']; ?> Dia<?php echo ($shipping['date']=='1')?'':'s'; ?>)

		</td>
	</tr>
	<?php endif; ?>	

	<tr> 
		<td style="border-color:white;"></td>
		<td style="border-color:white;">
			<div style="margin-top: 50px;">
				<div class="button-scroll-page">
			
					<div class="hand">
						<div class="circle">
						
					</div>
					</div>
				</div>
				<p class="white-text">Deslize para ver o total</p>
			</div>

		</td>
		<td align="right"></td>
		<td>
		 	<div id="divcep">
				<form method="GET">
					<label id="cep" style="text-align:left;">Digite seu CEP:&nbsp;</label><br>
					<input type="text" id="cep" value="<?php echo (!empty($_GET['cep']))?$_GET['cep']:''; ?>" name="cep"><br>
					<input type="submit" value="Calcular">
				</form>
			</div>
		</td>
	</tr>
	<?php
	//Coloquei essa linha a mais 
	if(isset($shipping['error']) && $shipping['error'] != "0"): ?>
		<?php if($shipping['error']==-3){ ?>	
			<script>alert("Este cep esta inválido Codigo: <?php echo $shipping['error']; ?>");</script>
		<?php }else{ ?>
			<script>alert("<?php echo $shipping['obsFim'].$shipping['error']; ?>");</script>
		<?php } ?>

	<?php endif; ?>
	<tr>
		<td colspan="3" align="right">Total: &nbsp;</td>
		<td>
			<strong> R$ <?php 
			if(isset($shipping['price'])){ 
				$frete = floatval(str_replace(',','.',$shipping['price']));
			}else{
				$frete = 0;
			}

			$total = $subtotal + $frete;
			echo number_format($total,2,',','.'); 

			?></strong>
		
		</td>
	</tr>
</table>
</div>


<form method="POST" id="store_true" onsubmit="return answer();" action="<?php echo BASE_URL; ?>cart/payment_redirect" style="display:none; float:right;">
	<select name="payment_type" required>
		<option value="">Escolha uma Opção</option>
		<option value="checkout_transparente">Cartão de Crédito</option>
		<option value="boleto">Boleto Bancário</option>
		<!-- <option value="mp">Mercado Pago</option> -->
	</select>

	<input type="hidden" name="withdraw_store" value="yes">
	<input type="hidden" id="op_insert" name="op_insert">

	<input type="submit" value="Finalizar Compra" class="button">
</form>

<?php if($frete > 0): ?>

	<form method="POST" id="store_frete" action="<?php echo BASE_URL; ?>cart/payment_redirect" style="float:right;">
		<select name="payment_type" required>
			<option value="">Escolha uma Opção</option>
			<option value="checkout_transparente">Cartão de Crédito</option>
			<option value="boleto">Boleto Bancário</option>
			<!-- <option value="mp">Mercado Pago</option> -->
		</select>

		<input type="submit" value="Finalizar Compra" class="button">
	</form>

<?php endif; ?>

<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/cart2.js"></script>
