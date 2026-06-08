$(document).ready(function() {
    $('.passport-number').mask('SS YYYYYYY', {'translation': {S: {pattern: /[A-Za-z]/},Y: {pattern: /[0-9]/}}});
    $('.phone-number').mask('S(YYY)-YY-YYY-YY-YY', {'translation': {S: {pattern: /[A-Za-z+]/},Y: {pattern: /[0-9]/}}});
    $('.phone-number-create').mask('(YY)-YYY-YY-YY', {'translation': {S: {pattern: /[A-Za-z+]/},Y: {pattern: /[0-9]/}}});

    $('.request-timer').each(function(){
        request_timer($(this),$(this).data('year'),$(this).data('month'),$(this).data('day'),$(this).data('hour'),$(this).data('minute'),$(this).data('seconds'),$(this).data('expire'));
    });

});