$(function(){
    if(typeof maxslider != 'undefined'){
      $( "#slider-range" ).slider({
        range: true,
        min: 0,
        max: maxslider,
        values: [ $('#slider0').val(), $('#slider1').val() ],
        slide: function( event, ui ) {
          $( "#amount" ).val( "R$" + ui.values[ 0 ] + " - R$" + ui.values[ 1 ] );
        },
        change: function(event,ui){
          $('#slider'+ui.handleIndex).val(ui.value);
           $('.filterarea form').submit();
        }

      });
    }

    $( "#amount" ).val( "R$" + $( "#slider-range" ).slider( "values", 0 ) +
      " - R$" + $( "#slider-range" ).slider( "values", 1 ) );


    $('.filterarea').find('input').on('change',function(){

      $('.filterarea form').submit();

    });


    $('.addtocartform button').on('click',function(e){
        e.preventDefault();

        var qt = parseInt($('.addtocart_qt').val());
        var action = $(this).attr('data-action');


        if(action == 'decrease'){

            if(qt-1 >=1){
              qt = qt-1;
            }
        }else if(action == 'increase'){
            qt = qt+1;
        }

        $('.addtocart_qt').val(qt);
        $('input[name=qt_product]').val(qt);
    });

    $('.photo_item').on('click',function(){
      
      var url = $(this).find('img').attr('src');
      $('.mainphoto').find('img').attr('src',url);
    });


    
    if($(window).width() > 670){
      
      $('#collapseExample').addClass('panel-collapse collapse in');
      $('#collapseExample').attr('aria-expanded','true');
    } 



});

/* valida se tem a quantidade em estoque para poder ser adicionada ao carrinho view 
    form view product.php
*/
function validarQt(qt,qtInCart){

  if(qt==''){
     qt = 0;
  }
  
  var qtInCart = parseInt(qtInCart);
  var qt = parseInt(qt);
  var qt_product = parseInt($('#qt_product').val());

  var soma = qtInCart + qt_product;
  if( qt >= soma){
    return true;
  }else{
    alert("Não temos essa quantidade em estoque, desse produto temos "+qt+" unidades e você tem "+ qtInCart+" unidades desse item no carrinho.");
    return false;
  }

}

$('#selectNewz').on('change', function(){

   if( $('option:selected', this).attr('data-lpe') == 'ok' ){
          $('#saleSuperior').val('1');
          console.log('sim');
   }else{
          $('#saleSuperior').val('0');
          console.log('nao');
   } 

});
