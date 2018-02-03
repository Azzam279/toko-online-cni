//root domain website
var host = $("#host").val();

$(document).ready(function(){
    
    //Close alert
    $('.page-alert .close').click(function(e) {
        e.preventDefault();
        $(this).closest('.page-alert').fadeOut();
    });

    $('.page-alert').delay(4500).fadeOut();

    //tooltip
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    });

    //navigasi fixed
    var nav = $('#cart-fixed');
    $(window).scroll(function () {
        if ($(this).scrollTop() > 115) {
            nav.fadeIn();
        } else {
            nav.fadeOut();
        }
    });

    //carousel
    var clickEvent = false;
    $('#myCarousel').carousel({
        interval:   4000    
    }).on('click', '.list-group li', function() {
            clickEvent = true;
            $('.list-group li').removeClass('active');
            $(this).addClass('active');     
    }).on('slid.bs.carousel', function(e) {
        if(!clickEvent) {
            var count = $('.list-group').children().length -1;
            var current = $('.list-group li.active');
            current.removeClass('active').next().addClass('active');
            var id = parseInt(current.data('slide-to'));
            if(count == id) {
                $('.list-group li').first().addClass('active'); 
            }
        }
        clickEvent = false;
    });
});

$(window).load(function() {
    var boxheight = $('#myCarousel .carousel-inner').innerHeight();
    var itemlength = $('#myCarousel .item').length;
    var triggerheight = Math.round(boxheight/itemlength+1);
    $('#myCarousel .list-group-item').outerHeight(triggerheight);
});

//menampilkan deskripsi produk
function readmore(id) {
    $.ajax({
        url: host+'/library/deskripsi-produk-ajax.php',
        type: 'POST',
        dataType: 'html',
        data: 'no_produk='+id,
        success: function(hasil){
            $('#id'+id).html(hasil);
        },
    });
    $('#loading'+id).html("<div id='preloader_1'><span></span><span></span><span></span><span></span><span></span></div>");
}

//menampilkan isi keranjang
function showCart() {
    $.ajax({
        url: host+'/library/keranjang-ajax.php',
        type: 'POST',
        dataType: 'html',
        data: 'id=nol',
        success: function(hasil){
            $('#cartResult').html(hasil);
        },
    });
}

//proses membeli produk
function beliProduk(id,price,stoks,name) {
    $.ajax({
        url: host+'/library/beli-produk-ajax.php',
        type: 'POST',
        dataType: 'html',
        data: 'no_produk='+id+'&harga='+price+'&stock='+stoks+'&nama='+name,
        beforeSend: function(){
            $("#waiting"+id).addClass("m-progress");
        },
        success: function(hasil){
            $("#cart-wrapper").html(hasil);
            $("#waiting"+id).removeClass("m-progress");
            //menghitung total item di keranjang  
            $.ajax({
                url: host+'/library/get-total-items-ajax.php',
                type: 'POST',
                dataType: 'html',
                data: 'no_produk2='+id,
                success: function(hasil){
                    $("#modal-heading-items").html(hasil);
                }
            });
        }
    });
}

//warning jika belum login
function warning() {
    sweetAlert("Anda harus login terlebih dahulu!", "", "warning");
}

//warning jika stok kosong/habis
$("#stok-kosong").click(function() {
    sweetAlert("Stok Produk ini sedang kosong!", "", "warning");
});