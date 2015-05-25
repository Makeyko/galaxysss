

$(document).ready(function() {
    var date0 = new Date(2012,12 - 1,21);
    var date80 = new Date(2025,1 - 1,1);
    var dateNow = new Date();
    var timeOC = date80.getTime() - date0.getTime();
    var timeOB = dateNow.getTime() - date0.getTime();
    var current = (timeOB/timeOC) * 80;
    var increment = (1/(timeOC/1000)) * 80 * (1/25);
    function IOSadd() {
        var Dec = parseInt(current);
        var Ost = current - Dec;
        var pow = 100000000;

        // узнаю сколько знаков в pow
        var j = 1;
        do {
            j++;
        } while(Math.pow(10, j) < pow);
        Ost = Ost * pow;
        Ost = parseInt(Ost);
        current += increment;
        if (Ost < pow) {
            // узнаю сколько знаков в Ost
            var i = 1;
            do {
                if ((Math.pow(10, i)) < Ost) {
                    i++;
                } else {
                    break;
                }
            } while(Math.pow(10, i) < pow);
            if (i < j) {
                // количество цифр меньше
                var zero = '';
                for(var t=1;t<= j-i;t++) {
                    zero = '0' + zero;
                }
                Ost = zero + Ost;
            }
        }

        $('#iosDec').html(Dec);
        $('#iosOst').html(Ost);
    }
    window.setInterval(IOSadd, 1000/25);
});
