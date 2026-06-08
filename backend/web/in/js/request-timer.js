
   var request_timer = function(tag,year,month,day,hour,minute,seconds,plusDay) {
        var countDownDate = new Date();
        countDownDate.setFullYear(parseFloat(year), parseFloat(month) -1, parseFloat(day));
        countDownDate.setHours(hour);
        countDownDate.setMinutes(minute);
        countDownDate.setSeconds(seconds);
        countDownDate.setDate(countDownDate.getDate() + plusDay);

        countDownDate = countDownDate.getTime();
        var x = setInterval(function() {
            var now = new Date().getTime();
            var distance = countDownDate - now;
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            tag.html(days + "k " + hours + "s "+ minutes + "d " + seconds + "s ");
            if (distance < 0) {
                tag.css("color","#990000");
            }
        }, 1000);
    };