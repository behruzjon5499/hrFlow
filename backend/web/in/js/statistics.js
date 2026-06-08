$(document).ready(function () {
    $('.statistics__innertab-link li').on('click', function () {
        $('.statistics__innertab-link li').removeClass('active');
        $(this).addClass('active');
        $('.statistics__innertab-item').removeClass('open');
        $('.statistics__innertab-item').eq($(this).index()).addClass('open');
    });


    var path = document.location.pathname;
    if (path.includes('statistics/deposit') || path.includes('statistics/credit') || path.includes('statistics/plastic') || path.includes('statistics/transfer') || path.includes('statistics/communal') || path.includes('statistics/income')) {

        $('#side-menu li a[href="/statistics/default/index"]').parent().addClass('active');
        $('#side-menu li a[href="/statistics/default/index"]').next().addClass('in');
    }
    if (path.includes('bonusjuridic/default')) {
        console.log('dsdsdfdf');
        $('#side-menu li a[href="/bonusjuridic/default/index"]').parent().addClass('active');
        $('#side-menu li a[href="/bonusjuridic/default/index"]').parents('.collapse').addClass('in');
        $('#side-menu li a[href="/bonusjuridic/default/index"]').parents('li').addClass('active');
    }
});

function tab(id) {
    $('.statistics__tab-link li').removeClass('active');
    $('.statistics__tab-link li').eq(id).addClass('active');
    $('.statistics__tab-item').removeClass('open');
    $('.statistics__tab-item').eq(id).addClass('open');
}

function tab1(id) {
    $('.statistics__tab-link.tab1 li').removeClass('active');
    $('.statistics__tab-link.tab1 li').eq(id).addClass('active');
    $('.statistics__tab-item.tab1').removeClass('open');
    $('.statistics__tab-item.tab1').eq(id).addClass('open');
}

function tab2(id) {
    $('.statistics__tab-link.tab2 li').removeClass('active');
    $('.statistics__tab-link.tab2 li').eq(id).addClass('active');
    $('.statistics__tab-item.tab2').removeClass('open');
    $('.statistics__tab-item.tab2').eq(id).addClass('open');
}

function tab3(id) {
    $('.statistics__tab-link.tab3 li').removeClass('active');
    $('.statistics__tab-link.tab3 li').eq(id).addClass('active');
    $('.statistics__tab-item.tab3').removeClass('open');
    $('.statistics__tab-item.tab3').eq(id).addClass('open');
}

function sort(index) {
    $('.fa').removeClass('active');
    var data = [];
    var obj = {region: '', sum: 0, quantity: 0};
    $('.statistics__table tbody tr').each(function () {
        obj.region = $(this).find('td:nth-child(1)').html();
        obj.sum = parseInt($(this).find('td:nth-child(2)').html().replace(/\s/g, ""));
        obj.quantity = parseInt($(this).find('td:nth-child(3)').html().replace(/\s/g, ""));
        data.push(obj);
        obj = {region: '', sum: 0, quantity: 0};
    });

    function sort_by_key_up(array, key) {
        return array.sort(function (a, b) {
            var x = a[key];
            var y = b[key];
            return ((x > y) ? -1 : ((x < y) ? 1 : 0));
        });
    }

    function sort_by_key_down(array, key) {
        return array.sort(function (a, b) {
            var x = a[key];
            var y = b[key];
            return ((x < y) ? -1 : ((x > y) ? 1 : 0));
        });
    }

    if (index == 1 || index == 2) {
        data = JSON.parse(localStorage.getItem("initdata"));
        $('.fa-sort-alpha-asc').addClass('active');
    } else if (index == 3 || index == 4) {
        if (index == 3) {
            data = sort_by_key_down(data, 'sum');
            $('thead tr th:nth-child(2) .fa-sort-numeric-asc').addClass('active');
        } else {
            $('thead tr th:nth-child(2) .fa-sort-numeric-desc').addClass('active');
            data = sort_by_key_up(data, 'sum');
        }
    } else if (index == 5 || index == 6) {
        if (index == 5) {
            data = sort_by_key_down(data, 'quantity');
            $('thead tr th:nth-child(3) .fa-sort-numeric-asc').addClass('active');
        } else {
            data = sort_by_key_up(data, 'quantity');
            $('thead tr th:nth-child(3) .fa-sort-numeric-desc').addClass('active');
        }

    }
    var html = ``;
    for (var i = 0; i < data.length; i++) {
        html += `<tr>
                                <td>${data[i].region}</td>
                                <td>${numberWithCommas(data[i].sum)}</td>
                                <td>${numberWithCommas(data[i].quantity)}</td>
                            </tr>`
    }
    $('.table tbody').html(html);
}


function sortOne(index) {
    $('.fa').removeClass('active');
    var data = [];
    var obj = {region: '', quantity: 0};
    $('.statistics__table tbody tr').each(function () {
        obj.region = $(this).find('td:nth-child(1)').html();
        obj.quantity = parseInt($(this).find('td:nth-child(2)').html().replace(/\s/g, ""));
        data.push(obj);
        obj = {region: '', sum: 0, quantity: 0};
    });

    function sort_by_key_up(array, key) {
        return array.sort(function (a, b) {
            var x = a[key];
            var y = b[key];
            return ((x > y) ? -1 : ((x < y) ? 1 : 0));
        });
    }

    function sort_by_key_down(array, key) {
        return array.sort(function (a, b) {
            var x = a[key];
            var y = b[key];
            return ((x < y) ? -1 : ((x > y) ? 1 : 0));
        });
    }


    if (index == 1) {
        $('thead tr th:nth-child(2) .fa-sort-numeric-asc').addClass('active');
        data = sort_by_key_down(data, 'quantity');
    } else {
        $('thead tr th:nth-child(2) .fa-sort-numeric-desc').addClass('active');
        data = sort_by_key_up(data, 'quantity');
    }


    var html = ``;
    for (var i = 0; i < data.length; i++) {
        html += `<tr>
                                <td>${data[i].region}</td>
                                <td>${numberWithCommas(data[i].quantity)}</td>
                            </tr>`
    }
    $('.table tbody').html(html);
    // alert('tets')
}

function sortTransferSend(index) {
    $('.fa').removeClass('active');
    var data = [];
    var obj = {region: '', sum: 0, quantity: 0};
    $('.statistics__table.send tbody tr').each(function () {
        obj.region = $(this).find('td:nth-child(1)').html();
        obj.sum = parseInt($(this).find('td:nth-child(2)').html().replace(/\s/g, ""));
        obj.quantity = parseInt($(this).find('td:nth-child(3)').html().replace(/\s/g, ""));
        data.push(obj);
        obj = {region: '', sum: 0, quantity: 0};
    });

    function sort_by_key_up(array, key) {
        return array.sort(function (a, b) {
            var x = a[key];
            var y = b[key];
            return ((x > y) ? -1 : ((x < y) ? 1 : 0));
        });
    }

    function sort_by_key_down(array, key) {
        return array.sort(function (a, b) {
            var x = a[key];
            var y = b[key];
            return ((x < y) ? -1 : ((x > y) ? 1 : 0));
        });
    }

    if (index == 1 || index == 2) {
        if (index == 1) {
            data = sort_by_key_down(data, 'sum');
            $('.statistics__table.send thead tr th:nth-child(2) .fa-sort-numeric-asc').addClass('active');
        } else {
            $('.statistics__table.send thead tr th:nth-child(2) .fa-sort-numeric-desc').addClass('active');
            data = sort_by_key_up(data, 'sum');
        }
    } else if (index == 3 || index == 4) {
        if (index == 3) {
            data = sort_by_key_down(data, 'quantity');
            $('.statistics__table.send thead tr th:nth-child(3) .fa-sort-numeric-asc').addClass('active');
        } else {
            data = sort_by_key_up(data, 'quantity');
            $('.statistics__table.send thead tr th:nth-child(3) .fa-sort-numeric-desc').addClass('active');
        }

    }
    var html = ``;
    for (var i = 0; i < data.length; i++) {
        html += `<tr>
                                <td>${data[i].region}</td>
                                <td>${numberWithCommas(data[i].sum)}</td>
                                <td>${numberWithCommas(data[i].quantity)}</td>
                            </tr>`
    }
    $('.statistics__table.send tbody').html(html);
}


function sortTransferRecieve(index) {
    $('.fa').removeClass('active');
    var data = [];
    var obj = {region: '', sum: 0, quantity: 0};
    $('.statistics__table.recieve tbody tr').each(function () {
        obj.region = $(this).find('td:nth-child(1)').html();
        obj.sum = parseInt($(this).find('td:nth-child(2)').html().replace(/\s/g, ""));
        obj.quantity = parseInt($(this).find('td:nth-child(3)').html().replace(/\s/g, ""));
        data.push(obj);
        obj = {region: '', sum: 0, quantity: 0};
    });

    function sort_by_key_up(array, key) {
        return array.sort(function (a, b) {
            var x = a[key];
            var y = b[key];
            return ((x > y) ? -1 : ((x < y) ? 1 : 0));
        });
    }

    function sort_by_key_down(array, key) {
        return array.sort(function (a, b) {
            var x = a[key];
            var y = b[key];
            return ((x < y) ? -1 : ((x > y) ? 1 : 0));
        });
    }

    if (index == 1 || index == 2) {
        if (index == 1) {
            data = sort_by_key_down(data, 'sum');
            $('.statistics__table.recieve thead tr th:nth-child(2) .fa-sort-numeric-asc').addClass('active');
        } else {
            $('.statistics__table.recieve thead tr th:nth-child(2) .fa-sort-numeric-desc').addClass('active');
            data = sort_by_key_up(data, 'sum');
        }
    } else if (index == 3 || index == 4) {
        if (index == 3) {
            data = sort_by_key_down(data, 'quantity');
            $('.statistics__table.recieve thead tr th:nth-child(3) .fa-sort-numeric-asc').addClass('active');
        } else {
            data = sort_by_key_up(data, 'quantity');
            $('.statistics__table.recieve thead tr th:nth-child(3) .fa-sort-numeric-desc').addClass('active');
        }

    }
    var html = ``;
    for (var i = 0; i < data.length; i++) {
        html += `<tr>
                                <td>${data[i].region}</td>
                                <td>${numberWithCommas(data[i].sum)}</td>
                                <td>${numberWithCommas(data[i].quantity)}</td>
                            </tr>`
    }
    $('.statistics__table.recieve tbody').html(html);
}


function sort1(index) {
    // alert('test');
    $('.fa').removeClass('active');
    var data = [];
    var obj = {region: '', sum: 0, quantity: 0};
    $('.tab1.statistics__table tbody tr').each(function () {
        obj.region = $(this).find('td:nth-child(1)').html();
        obj.sum = parseInt($(this).find('td:nth-child(2)').html().replace(/\s/g, ""));
        obj.quantity = parseInt($(this).find('td:nth-child(3)').html().replace(/\s/g, ""));
        data.push(obj);
        obj = {region: '', sum: 0, quantity: 0};
    });

    function sort_by_key_up(array, key) {
        return array.sort(function (a, b) {
            var x = a[key];
            var y = b[key];
            return ((x > y) ? -1 : ((x < y) ? 1 : 0));
        });
    }

    function sort_by_key_down(array, key) {
        return array.sort(function (a, b) {
            var x = a[key];
            var y = b[key];
            return ((x < y) ? -1 : ((x > y) ? 1 : 0));
        });
    }

    if (index == 3 || index == 4) {
        if (index == 3) {
            data = sort_by_key_down(data, 'sum');
            $('.tab1.statistics__table thead tr th:nth-child(2) .fa-sort-numeric-asc').addClass('active');
        } else {
            $('.tab1.statistics__table thead tr th:nth-child(2) .fa-sort-numeric-desc').addClass('active');
            data = sort_by_key_up(data, 'sum');
        }
    } else if (index == 5 || index == 6) {
        if (index == 5) {
            data = sort_by_key_down(data, 'quantity');
            $('.tab1.statistics__table thead tr th:nth-child(3) .fa-sort-numeric-asc').addClass('active');
        } else {
            data = sort_by_key_up(data, 'quantity');
            $('.tab1.statistics__table thead tr th:nth-child(3) .fa-sort-numeric-desc').addClass('active');
        }

    }
    var html = ``;
    for (var i = 0; i < data.length; i++) {
        html += `<tr>
                                <td>${data[i].region}</td>
                                <td>${numberWithCommas(data[i].sum)}</td>
                                <td>${numberWithCommas(data[i].quantity)}</td>
                            </tr>`
    }
    $('.tab1.statistics__table tbody').html(html);
}

function sort2(index) {
    $('.fa').removeClass('active');
    var data = [];
    var obj = {region: '', sum: 0, quantity: 0};
    $('.tab2.statistics__table tbody tr').each(function () {
        obj.region = $(this).find('td:nth-child(1)').html();
        obj.sum = parseInt($(this).find('td:nth-child(2)').html().replace(/\s/g, ""));
        obj.quantity = parseInt($(this).find('td:nth-child(3)').html().replace(/\s/g, ""));
        data.push(obj);
        obj = {region: '', sum: 0, quantity: 0};
    });

    function sort_by_key_up(array, key) {
        return array.sort(function (a, b) {
            var x = a[key];
            var y = b[key];
            return ((x > y) ? -1 : ((x < y) ? 1 : 0));
        });
    }

    function sort_by_key_down(array, key) {
        return array.sort(function (a, b) {
            var x = a[key];
            var y = b[key];
            return ((x < y) ? -1 : ((x > y) ? 1 : 0));
        });
    }

    if (index == 3 || index == 4) {
        if (index == 3) {
            data = sort_by_key_down(data, 'sum');
            $('.tab2.statistics__table thead tr th:nth-child(2) .fa-sort-numeric-asc').addClass('active');
        } else {
            $('.tab2.statistics__table thead tr th:nth-child(2) .fa-sort-numeric-desc').addClass('active');
            data = sort_by_key_up(data, 'sum');
        }
    } else if (index == 5 || index == 6) {
        if (index == 5) {
            data = sort_by_key_down(data, 'quantity');
            $('.tab2.statistics__table thead tr th:nth-child(3) .fa-sort-numeric-asc').addClass('active');
        } else {
            data = sort_by_key_up(data, 'quantity');
            $('.tab2.statistics__table thead tr th:nth-child(3) .fa-sort-numeric-desc').addClass('active');
        }

    }
    var html = ``;
    for (var i = 0; i < data.length; i++) {
        html += `<tr>
                                <td>${data[i].region}</td>
                                <td>${numberWithCommas(data[i].sum)}</td>
                                <td>${numberWithCommas(data[i].quantity)}</td>
                            </tr>`
    }
    $('.tab2.statistics__table tbody').html(html);
}

function sort3(index) {
    $('.fa').removeClass('active');
    var data = [];
    var obj = {region: '', sum: 0, quantity: 0};
    $('.tab3 .statistics__table tbody tr').each(function () {
        obj.region = $(this).find('td:nth-child(1)').html();
        obj.sum = parseInt($(this).find('td:nth-child(2)').html().replace(/\s/g, ""));
        obj.quantity = parseInt($(this).find('td:nth-child(3)').html().replace(/\s/g, ""));
        data.push(obj);
        obj = {region: '', sum: 0, quantity: 0};
    });

    function sort_by_key_up(array, key) {
        return array.sort(function (a, b) {
            var x = a[key];
            var y = b[key];
            return ((x > y) ? -1 : ((x < y) ? 1 : 0));
        });
    }

    function sort_by_key_down(array, key) {
        return array.sort(function (a, b) {
            var x = a[key];
            var y = b[key];
            return ((x < y) ? -1 : ((x > y) ? 1 : 0));
        });
    }

    if (index == 3 || index == 4) {
        if (index == 3) {
            data = sort_by_key_down(data, 'sum');
            $('.tab3.statistics__table thead tr th:nth-child(2) .fa-sort-numeric-asc').addClass('active');
        } else {
            $('.tab3.statistics__table thead tr th:nth-child(2) .fa-sort-numeric-desc').addClass('active');
            data = sort_by_key_up(data, 'sum');
        }
    } else if (index == 5 || index == 6) {
        if (index == 5) {
            data = sort_by_key_down(data, 'quantity');
            $('.tab3.statistics__table thead tr th:nth-child(3) .fa-sort-numeric-asc').addClass('active');
        } else {
            data = sort_by_key_up(data, 'quantity');
            $('.tab3.statistics__table thead tr th:nth-child(3) .fa-sort-numeric-desc').addClass('active');
        }

    }
    var html = ``;
    for (var i = 0; i < data.length; i++) {
        html += `<tr>
                                <td>${data[i].region}</td>
                                <td>${numberWithCommas(data[i].sum)}</td>
                                <td>${numberWithCommas(data[i].quantity)}</td>
                            </tr>`
    }
    $('.tab3.statistics__table tbody').html(html);
}

function numberWithCommas(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    return parts.join(" ");
}