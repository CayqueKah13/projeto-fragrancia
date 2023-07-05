<h1>Obrigado pela compra!</h1><br>
<h4>Veja na aba Minhas compras o código da compra.</h4>
<?php if(!empty($result['message']) && $result['operation']=='success'): ?>
	<div style="margin-left: 67px; width: 100px;">
		<a href="<?php echo $result['message']; ?>" target="_blank" style="text-align: center;" class="thumbnail">Visualize
		    <img src="<?php echo BASE_URL; ?>assets/images/miniboleto.png">
		</a>
	</div>
<?php endif; ?>

Visualize seu boleto clicando na imagem acima.