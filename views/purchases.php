<h1>Minhas compras</h1><br>

<div class="table-responsive">
  <table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>Código da compra</th>
      <th>Data</th>
      <th>Pagamento</th>
      <th>Status</th>
     <th>Total</th>
     <th>Ver Detalhes</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($list as $item): ?>
    <tr style="cursor: pointer;" class="header-level">
      <td><?php echo $item['id']; ?></td>
      <td><?php echo date("d/m/Y",strtotime($item['purchase_date']." - 3 hours")); ?></td>
      <td><?php echo ($item['payment_type']=='psckttransparente')?'Cartão de crédito':'Boleto bancário'; ?></td>
      <td>
      <?php
      switch($item['payment_status']){
        case "1":
        echo "<span class='label label-default' style='font-size:9pt;'>Aguardando Pagamento</span>";
        break;

        case "2":
        echo "<span class='label label-default' style='font-size:9pt;'>Em análise</span>";
        break;

        case "3":
        echo "<span class='label label-success'>Pago</span>";
        break;

        case "4":
        echo "<span class='label label-default' style='font-size:9pt;'>Disponível</span>";
        break;

        case "5":
        echo "<span class='label label-default' style='font-size:9pt;'>Em disputa</span>";
        break;

        case "6":
        echo "<span class='label label-default' style='font-size:9pt;'>Disputa Devolvida</span>";
        break;

        case "7":
        echo "<span class='label label-danger' style='font-size:9pt;'>Cancelada</span>";
        break;

        case "8":
        echo "<span class='label label-default' style='font-size:9pt;'>Disputa Debitado</span>";
        break;

        case "9":
        echo "<span class='label label-danger' style='font-size:9pt;'>Chargeback</span>";
        break;
      }
       
      ?>
        
      </td>
      <td>R$ <?php echo number_format($item['total_amount'],2,",","."); ?></td>
      <td>Clique aqui<img style="float:right;" src="<?php echo BASE_URL; ?>assets/images/dropdown-purchases.png"></td>
    </tr>
    <tr class="sub-level">
      <td style="color:black; background-color:white; text-align: center; display: none; margin-left: 40px;" colspan="6">
        

      </td>
     
    </tr>
   
  <?php endforeach; ?>

  

  </tbody>
  </table>
</div>


<?php 
$total_pages = ceil($pag['total']/$pag['per_page']);
?>
<?php for($q=0;$q<$total_pages;$q++): ?>
	<a href="<?php $items['p'] = ($q+1);
		echo BASE_URL.'purchases?p='.$items['p'];
	 ?>">
		<?php echo ($q==$pag['currentpage'])?'<strong>['.($q+1).']</strong>':'[ '.($q+1).' ]'; ?>
</a>
<?php endfor; ?>

<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/mypurchases2.js"></script>