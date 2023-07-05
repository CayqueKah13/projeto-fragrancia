<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<?php if(!empty($response) && !$response['error']): ?>
			<div class="alert alert-success" role="alert"><strong><?php echo $response['msg']; ?></strong></div>
		<?php endif; ?>

		<?php if(!empty($response) && $response['error']): ?>
			<div class="alert alert-warning" role="alert"><strong><?php echo $response['msg']; ?></strong></div>
		<?php endif; ?>	
	</div>
</div>