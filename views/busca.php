<div class="row">
<?php if(!empty($_GET['s'])): ?>
<h1>Você esta procurando por: "<?php echo $searchTerm; ?>"</h1>
<?php endif; ?>
<?php $a = 0; 
foreach($list as $product_item): ?>
	<div class="col-sm-4">

		<?php $this->loadView('product_item', $product_item); ?>
	</div>	
	<?php 
		if($a >= 2){
			$a=0;
			echo '</div><div class="row">';
		}else{
			$a++;
		}
endforeach;		
?>
</div>

<?php for($q=1;$q<=$numberOfPages;$q++): ?>
	<div class="paginationItem <?php echo ($currentPage==$q)?'pag_active':''; ?>"><a href="<?php echo BASE_URL; ?>?
		<?php  $pag_array = $_GET;
			   $pag_array['p'] = $q;
			   echo http_build_query($pag_array);
		?>"><?php echo $q; ?></a></div>
<?php endfor; ?>
