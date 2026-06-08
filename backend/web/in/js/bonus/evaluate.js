$(document).ready(function () {
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });
    $('.checked_param').iCheck('check');

    $('.employee_mark').on('click',function(e) {
        e.preventDefault();
        var eid = $(this).data('eid');
        $('.evaluate-modal-title').text('').text($('tr#'+eid+' td.full_name').text());
        $('.evaluate_eid').val(eid);
    });
    $(".changeRadio").on('ifChanged', function (e) {
        var total = 0;
        var percent_total = 0;
        $('.changeRadio:checked').each(function () {
            var current_val = parseInt(this.value);
            total += parseInt(this.value);
            if(this.value == 1)  percent_total+=0;
            if(this.value == 2)  percent_total+=parseInt(15);
            if(this.value == 3)  percent_total+=parseInt(20);
            if(this.value == 4)  percent_total+=parseInt(30);
        });
        $('.total_mark').text(total);

        $('.total_percent').text(percent_total +'%');
    });
    $(".changeRadioMain").on('ifChanged', function (e) {
        var total = 0;
        var percent_total = 0;
        $('.changeRadioMain:checked').each(function () {
            var current_val = parseInt(this.value);
            total += parseInt(this.value);
            if(this.value == 1)  percent_total+=0;
            if(this.value == 2)  percent_total+=parseInt(30);
            if(this.value == 3)  percent_total+=parseInt(40);
            if(this.value == 4)  percent_total+=parseInt(50);
        });
        $('.total_mark').text(total);
        $('.total_percent').text(percent_total +'%');
    });


    $('.bd-example-modal-lg, .bd-example-modal-main').on('hidden.bs.modal', function () {
        $('.changeRadio').iCheck('uncheck');
        $('.changeRadioMain').iCheck('uncheck');
    });

});