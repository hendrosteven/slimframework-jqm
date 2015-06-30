var serviceURL = "http://localhost/hotel/index.php/";
var hotels;


$('#main').bind('pageinit', function (event) {
    getHotelList();
});

$('#refreshBtn').click(function () {
    getHotelList();
});

//ambil daftar hotel
function getHotelList() {
    $.getJSON(serviceURL + 'hotels', function (data) {
        $('#hotelList li').remove();
        hotels = data.items;
        $.mobile.showPageLoadingMsg(true); // load spinner
        $.each(hotels, function (index, hotel) {
            $('#hotelList').append('<li><a href="hoteldetail.html?id=' + hotel.id + '" data-transition="slide">' +
                    '<img src="' + hotel.img + '"/>' +
                    '<h4>' + hotel.nama + '</h4>' +
                    '<p>' + hotel.email + '</p></a></li>');
        });
        $('#hotelList').listview('refresh');
        $.mobile.hidePageLoadingMsg(); // hide spinner
    });
}

//baca data hotel diserver saat page detail ditampilkan
$('#detailPage').live('pagebeforeshow', function (event) {
    var id = getUrlVars()["id"];
    $.getJSON(serviceURL + 'hotels/get/' + id, displayHotel);
});

//mengambil parameter dari url
function getUrlVars() {
    var vars = [], hash;
    var hashes = window.location.href
            .slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

//tampilkan data
function displayHotel(data) {
    $.mobile.showPageLoadingMsg(true);
    var hotel = data.item;
    $('#hotelImg').attr('src', hotel.img);
    $('#name').text(hotel.nama);
    $('#address').text(hotel.alamat);
    $('#detailList li').remove();
    $('#detailList').append('<li data-icon="false"><a href="mailto:' + hotel.email + '"><h3>Email</h3>' +
            '<p>' + hotel.email + '</p></a></li>');
    $('#detailList').append('<li data-icon="false"><a href="tel:' + hotel.telp + '"><h3>Call</h3>' +
            '<p>' + hotel.telp + '</p></a></li>');
    $('#detailList').listview('refresh');
    $('#editBtn').attr('href', '#');
    $.mobile.hidePageLoadingMsg();
}



