$(function(){

	$('.efetuarCompra').on('click', function(){

		var id = PagSeguroDirectPayment.getSenderHash();

		var name = $('input[name=nome]').val();
		var cpf = $('input[name=cpf]').val();

		var ddd = $('input[name=ddd').val();
		var telefone = $('input[name=telefone]').val();

        var email = $('input[name=email]').val();

        var cep = $('input[name=cep]').val();
        var rua = $('input[name=rua]').val();
		var numero = $('input[name=numero]').val();
        var complemento = $('input[name=complemento]').val();
        var bairro = $('input[name=bairro]').val();
        var cidade = $('input[name=cidade]').val();
        var estado = $('select[name=estado]').val();

        var cartao_titular = $('input[name=cartao_titular]').val();
        var cartao_numero = $('input[name=cartao_numero]').val();
		var cvv = $('input[name=cartao_cvv]').val();
		var v_mes = $('select[name=cartao_mes]').val();
		var v_ano = $('select[name=cartao_ano]').val();

		var parc = $('select[name=parc]').val();

		var cartao_cpf = $('input[name=cartao_cpf]').val();
		var cartao_ddd = $('input[name=cartao_ddd]').val();
		var cartao_tel = $('input[name=cartao_tel]').val();
		var cartao_date = $('input[name=cartao_date]').val() 

		var validateEmpty = { "Nome":name, "CPF":cpf, "DDD":ddd, "Telefone":telefone, 
		"Email":email, "Cep":cep, "Rua":rua, "Numero":numero, "Bairro":bairro, "Cidade":cidade,
		 "Estado":estado, "Titular do Cartão":cartao_titular, "CPF":cartao_cpf,
		 "Numero do cartao":cartao_numero, "CVV":cvv, "Mês de validade do cartão":v_mes, 
		 "Ano de validade do cartão":v_ano, "Parcelas":parc, "Data de nascimento":cartao_date,
		 "DDD Titular cartão":cartao_ddd, "Telefone Titular Cartão":cartao_tel };

		var compare = isEmpty(validateEmpty);

		if (compare.length == 0) {

			$('#preload').fadeIn();
			
			cartao_numero = cartao_numero.replace( /\s/g, '' );

			PagSeguroDirectPayment.createCardToken({

				cardNumber:cartao_numero,
				brand:window.cardBrand,
				cvv:cvv,
				expirationMonth:v_mes,
				expirationYear:v_ano,
				success:function(r){
					// Pega token para finalizar compra
					window.cardToken = r.card.token;

					//Enviando informações via AJAX
                    $.ajax({
                        url: BASE_URL + 'psckttransparente/checkout',
                        type: 'POST',
                        data: {
                            id:id,
							name:name,
							cpf:cpf,
							ddd:ddd,
							telefone:telefone,
							email:email,
							rua:rua,
							numero:numero,
							complemento:complemento,	
							bairro:bairro,
							cidade:cidade,
							estado:estado,
							cartao_titular:cartao_titular,
							cartao_cpf:cartao_cpf,
							cartao_numero:cartao_numero,
							parc:parc,
							cvv:cvv,
							v_mes:v_mes,
							v_ano:v_ano,
							cartao_token:window.cardToken,   
							cep:cep,
							cartao_ddd:cartao_ddd,
							cartao_tel:cartao_tel,
							cartao_date:cartao_date
                        },
                        dataType: 'json',
                        success: function (json) {
                            if(json.error == true) {

                            	$('#preload').fadeOut();
                            	$('html, body').animate({scrollTop:200}, 'slow'); 
                            	$('#showErroPag').css('display','block');
                                $('#errorPagSeg').html(json.msg);
                            }else{
                            	
                            	window.location.href=BASE_URL+"psckttransparente/obrigado";
                            }
                        },
                        error: function (json) {
                        	$('#preload').fadeOut();
                            alert(json);
                        }
                    });



				},

				error:function(r){
					$('#preload').fadeOut();
					$('html, body').animate({scrollTop:200}, 'slow'); 
                	$('#showErroPag').css('display','block');
                    $('#errorPagSeg').html(JSON.stringify(r.errors));
                    console.log(r);
				},

				complete:function(){

				}

			});

		} else {
			alert("Falta preencher os seguintes dados: "+compare.join([separador = ', '])+".");
		}

	});



	$('input[name=cartao_numero]').on('keyup', function(e){

		var cardNotEsp = $(this).val().replace(" ","");

		if (cardNotEsp.length > 5) {/*Quando chegar em seis digitos*/

			PagSeguroDirectPayment.getBrand({
				cardBin: cardNotEsp,
				success:function(r){

					window.cardBrand = r.brand.name;
					var cvvLimit = r.brand.cvvSize;
					$('input[name=cartao_cvv]').attr('maxlength', cvvLimit);

					PagSeguroDirectPayment.getInstallments({

						amount:$('input[name=total]').val(),
						maxInstallmentNoInterest:10, //<- APARTIR DESSE NUMERO COMEÇA AS PARC COM JUROS
						brand:window.cardBran,
						success:function(r){

							if (r.error == false ) {
								var parc = r.installments[window.cardBrand];
								var html = '';
								
								for(var i in parc){

									var optionValue = parc[i].quantity+';'+parc[i].installmentAmount+';'+parc[i].totalAmount+';';
									
									if (parc[i].interestFree == true) {
										
										optionValue += 'true';
										html +='<option value="'+optionValue+'">'+parc[i].quantity+'x de R$ '+parc[i].installmentAmount+' (Sem juros) </option>';

									} else {
										optionValue += 'false';
										html +='<option value="'+optionValue+'">'+parc[i].quantity+'x de R$ '+parc[i].installmentAmount+'</option>';

									}

								}

								$('select[name=parc]').html(html);
							}

						},

						error:function(r){
							console.log(r);
						},

						complete:function(){}

					}); 


				},
				error:function(r){
					console.log(r);
				},
				complete: function(r){}
			});
		}


	});
});

function isEmpty(obj){

	var compare = [];

	for(var prop in obj) {
        if(obj[prop] =="" || obj[prop]=="undefined" || obj[prop] == null){
            compare.push(prop);
        }
    }

    return compare;
	
}