$("document").ready(function($){
    
    $(window).scroll(function () {
        var nav = $('.scroll-nav');
        var menu = $('.scroll-side-menu');
        
        if ($(this).scrollTop() > 0) {
            
            nav.attr("style","width:"+nav.width()+"px; position: fixed; box-shadow: 0 0 1px 0px #2f4050;");
            menu.attr("style","width:"+menu.width()+"px; position: fixed;");
            
        } else {
            
            nav.removeAttr("style");
            menu.removeAttr("style");
        }
    });
    $.fn.datepicker.dates.en = {
        days: ["Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"],
        daysShort: ["Вск", "Пнд", "Втр", "Срд", "Чтв", "Птн", "Суб"],
        daysMin: ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
        months: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
        monthsShort: ["Янв", "Фев", "Мар", "Апр", "Май", "Июн", "Июл", "Авг", "Сен", "Окт", "Ноя", "Дек"],
        today: "Сегодня",
        clear: "Очистить",
        format: "dd.mm.yyyy",
        titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
        weekStart: 0
    };
    var todayDate = new Date().getDate();
    $('#date123').datepicker({
        minViewMode: 0,
        startDate:0
    })
});

function amount(val) {
    // console.log(val);
    var solved = $('#solved').val();
    var all = $('#issue').val();
    $('#unsolved').val(all - solved);

}