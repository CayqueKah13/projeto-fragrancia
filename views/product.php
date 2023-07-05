<div class="row"><a href="<?php echo BASE_URL; ?>" class="btn btn-default" style="margin-top:-6px; float: right;">Voltar na loja</a>	
	<div class="col-sm-5 panel-photo" >
		<div class="mainphoto">
			<img src="<?php echo BASE_URL; ?>media/products/<?php echo $product_images[0]['url']; ?>">
		</div>
		<div class="gallery">
			<?php foreach($product_images as $img): ?>
				<div class="photo_item">
					<img src="<?php echo BASE_URL; ?>media/products/<?php echo $img['url']; ?>">	
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="col-sm-7 p-detail-mg">
		<h2><?php echo $product_info['name']; ?></h2>
		<small><?php echo $product_info['brand_name']; ?></small><br>
		<?php if($product_info['rating'] != '0'): ?>
			<?php for($q=0;$q<intval($product_info['rating']);$q++): ?>
				<img src="<?php echo BASE_URL; ?>assets/images/star.png" border="0" height="15">
			<?php endfor; ?>
		<?php endif; ?>
		<hr>
		<p><?php echo utf8_encode($product_info['description']); ?></p>
		<?php if($product_info['price_from'] != 0): ?>
			De: <span class="price_from">R$ <?php echo number_format($product_info['price_from'],2,',','.'); ?></span>
		<?php endif; ?>
		<br>
		Por: <span class="original_price">R$ <?php echo number_format($product_info['price'],2,',','.'); ?></span>

		<?php 
			$qtInCart = 0;

			if(isset($_SESSION['cart'][$product_info['id']]) && !empty($_SESSION['cart'][$product_info['id']])){
				
				$qtInCart = $_SESSION['cart'][$product_info['id']];
			}
		?>

		<form method="POST" onsubmit="return validarQt('<?php echo $product_info["total"]; ?>','<?php echo $qtInCart ?>')" class="addtocartform" action="<?php echo BASE_URL; ?>cart/add">
			<input type="hidden" name="id_product" value="<?php echo $product_info['id']; ?>">
			<input type="hidden" id="qt_product" name="qt_product" value="1">
			<button data-action="decrease">-</button><input type="text" name="qt" value="1" class="addtocart_qt" disabled><button data-action="increase">+</button>
			<?php if($product_info['total'] > 0): ?>
			<input class="addtocart_submit" type="submit" value="<?php $this->lang->get('ADD_TO_CART'); ?>">
			<?php else: ?>
			<input style="background-color: grey; border-color: grey;" class="addtocart_submit" type="button" value="Produto Indisponível" disabled>
			<?php endif; ?>
		</form>
	</div>
</div>

<hr style="height: 3px; background-color: lightgrey;">

<div class="row">
	<div class="col-sm-6">
		<h3><?php $this->lang->get('PRODUCT_SPECIFICATIONS'); ?></h3><br>
		<?php 
		if(!empty($product_options )){
			  foreach($product_options as $po): ?>
				<strong><?php echo $po['name']; ?></strong>: <?php echo $po['value']; ?><br>
		<?php endforeach; 
		}	?>
	</div>
	<div class="col-sm-6">
		<h3><?php $this->lang->get('PRODUCT_REVIEWS'); ?></h3><br>
		<?php foreach($product_rates as $rate): ?>
			<blockquote style="font-size:10pt;">
			<strong><?php echo $rate['user_name']; ?></strong> - 
			<?php for($q=0;$q<intval($rate['points']);$q++): ?>
				<img src="<?php echo BASE_URL; ?>assets/images/star.png" border="0" height="15">
			<?php endfor; ?>
			<br>
			
			"<?php echo $rate['comment']; ?>"
			</blockquote>
			
		<?php endforeach; ?>
	</div>
</div>
<hr><br>
<div class="row">

	<div class="col-md-6">
		<h3>Veja mais alguns de nossos produtos</h3><br>

		<div class="widget">
  			<div class="widget_body">
  				<?php foreach($widget_sale as $widget_item): ?>
					<div class="widget_item">
						<a href="<?php echo BASE_URL; ?>product/open/<?php echo $widget_item['id']; ?>">
							<div style="float:left; border: none;" class="widget_photo">
								<img style="border: none;" src="<?php echo BASE_URL; ?>media/products/<?php echo $widget_item['images'][0]['url']; ?>">
							</div>
							<div style="float:right;" class="widget_info">
								<div class="widget_productname"><?php echo $widget_item['name']; ?></div>
								<div class="widget_price">
									<?php if($widget_item['price_from']!=0): ?>
									<span><strike>R$ <?php echo number_format($widget_item['price_from'],2,',','.'); ?></strike></span> 
									<?php endif; ?>
									R$ <?php echo number_format($widget_item['price'],2,',','.'); ?>
								</div>
							</div>
							
							<div style="clear:both;"></div>
						</a>
					</div>
				<?php endforeach; ?>
  			</div>	
  		</div>
	</div>

	<div class="col-md-4"><br>
		<?php if(!empty($login_comment)): ?>
		<div class="alert alert-info"><strong><?php echo $login_comment; ?></strong></div>
		<?php endif; ?>
		<div style="margin-left: -6px;" class="panel panel-default">
		  <div style="background-color: white;" class="panel-heading"><strong>Deixe sua opinião sobre este produto</strong></div>
		  <div class="panel-body">
		  	<form method="POST">

			    <div class="form-group">
				<label style="font-weight: 500;" for="title_rate">Título da opinião</label>
					<input type="text" class="form-control" name="title_rate" id="title_rate" required>
				</div>

				<div class="form-group">
					<label style="font-weight: 500;" for="text_rate">Opinião geral sobre o produto</label>
					<textarea maxlength="200" rows="4" class="form-control" name="text_rate" id="text_rate" required></textarea>
				</div>

				<div class="form-group">
					<label style="font-weight: 500;">Quantas estrelas para este produto?</label>
					<select name="star_rate" class="form-control" required>
						<option></option>
						<option value="-1">Nenhuma estrela</option>
						<option value="1">Uma estrela</option>
						<option value="2">Duas estrelas</option>
						<option value="3">Três estrelas</option>
						<option value="4">Quatro estrelas</option>
						<option value="5">Cinco estrelas</option>
					</select>
				</div>

				<input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

				<input type="submit" class="btn btn-default" value="Enviar">
			</form>
		  </div>
		</div>

	</div>

</div>
