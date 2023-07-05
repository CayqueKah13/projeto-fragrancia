$(function(){

	$('.header-level').on('click',function(){
		
	   var id_purchase = $(this).children().html();
	   var e = $(this).next('.sub-level').children();
	     
	   $.ajax({
            url: BASE_URL + 'purchases/ajax',
            type: 'POST',
            data: {
              id_purchase:id_purchase
            },
            dataType: 'json',
            success: function (json) {
  
            	$(e).html('');
            	var content = "";
                  var content2 = "";

                  if(json[0]['shipping_status'] != null && json[0]['shipping_status'].length > 35){
                        content += "<div class='alert alert-info'><strong>Você escolheu a opção de retirar o produto direto da loja:<br><br>Seu código de compra é "+json[0]['id_purchase']+" informe ele na loja, é preciso também apresentar o CPF<br><br>"+json[0]['shipping_status']+"</strong></div>"; 
                  }
                  $(e).append(content);
            	json.forEach(function(a){
            	     content2 = "<hr><strong>Produto: "+a['name']+"<br>Preço da unidade: R$ "+a['price'].replace('.',',')+
            			"<br>Quantidade: "+a['quantify']+"</strong><hr>";
            	     $(e).append(content2);
                        

            	});
                  if(json[0]['shipping_cost']!="" && json[0]['shipping_cost']!=0 && 
                        json[0]['shipping_cost']!=null){
                        $(e).append("<strong>Frete: R$ "+ json[0]['shipping_cost'].replace('.',',')+"</strong><br><br>");
            	}

                  if(json[0]['shipping_status']!="" && json[0]['shipping_status']!=null && json[0]['shipping_cost']!="" && json[0]['shipping_cost']!=0 && json[0]['shipping_cost']!=null){
                        $(e).append("<strong>Status da entrega: <span style='font-size:9pt;' class='label label-primary'>"+json[0]['shipping_status']+"</span></strong><br><br>")
                  }
            	
            },
            error: function (json) {
            	$(e).html('Nenhuma informação foi carregada')
            }
        });

	   $(e).fadeToggle();
	   
	});

});