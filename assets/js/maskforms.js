$('.cpf').mask('000.000.000-00', {reverse: true});
$('.tel').mask('00000-0000', {reverse: true});
$('#cep').mask('00000-000', {reverse: true});
$('#cartao_date').mask('00/00/0000');

 
new Card({
    form: document.querySelector('#form'),
    container: '.card-wrapper',
    debug:true
 });
   
$('#cartao_numero, #cartao_titular, #cartao_cvv, #cartao_mes, #cartao_ano').on('focus',function(){
    $('.card-wrapper').css('display','block');
});

$('#cartao_numero, #cartao_titular, #cartao_cvv, #cartao_mes, #cartao_ano').on('blur',function(){
    $('.card-wrapper').css('display','none');
});

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});