$('.cpf').mask('000.000.000-00', {reverse: true});
$('#cep').mask('00000-000', {reverse: true});
$('.tel').mask('00000-0000');

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});