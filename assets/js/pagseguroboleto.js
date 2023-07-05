$(function(){

	$('.efetuarCompra').on('click', function(){
		
		var id = PagSeguroDirectPayment.getSenderHash();
		$('input[name=hash]').val(id);
	});


	$('#formSubmit').on('submit', function(){
		$('#preload').fadeIn();
	});

});