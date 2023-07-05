$(function(){

	$("input[name='opStore']").on("change", function(){

		$("#op_insert").val($(this).val());
	});

	$('#delivery, #store').on('change',function(){
		
		if ($('#delivery').is(':checked')) {
			$('#divcep').fadeIn();
			$('#endereco_option').fadeOut();
			$('#store_true').css('display','none');

		}else{
			$('#divcep').fadeOut();
			$('#endereco_option').fadeIn();
			$('#store_true').fadeIn();
			$('#store_frete').css('display','none');
		}
	});


});


function answer(){ 
	console.log($("input[name='opStore']").prop("checked"));

	if($("#alpha").prop("checked") || $("#ss").prop("checked") || $("#sc").prop("checked")){
		return true;
	}else{
		alert("Escolha uma das opções de loja.");
		return false;
	}
}
