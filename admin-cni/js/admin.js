$(function() {	
	//Close alert
    $('.page-alert .close').click(function(e) {
        e.preventDefault();
        $(this).closest('.page-alert').fadeOut();
    });

    $('.page-alert').delay(5000).fadeOut();

    //tooltip
    $(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	});

    //accordion jquery-ui
    $("#accordion").accordion({
        active: true,
        heightStyle: "content",
        collapsible:true
    });

});

function ongkir(id) {
    var ongkir = $("#ongkir"+id).val();

    if (ongkir == "") {
        sweetAlert("Ongkir harus diisi!", "", "warning");
    }else{
        $.ajax({
            url: '../admin-cni/proses-ajax.php',
            type: 'POST',
            dataType: 'html',
            data: 'no='+id+'&ongkir='+ongkir,
            beforeSend: function(){
                swal({
                    title: "Sedang Memuat...",
                    text: "",
                    imageUrl: "../images/ajaxloader.gif"
                });
            },
            success: function(hasil){
                swal({
                    title: hasil,
                    text: "",
                    type: "success",
                    showCancelButton: false,
                    confirmButtonColor: "#86CCEB",
                    confirmButtonText: "Ok",
                    closeOnConfirm: false
                    },
                    function(){
                        window.location = '?adm=order';
                    });
            }
        });
    }
}

function status(id) {
    var status = $("#status"+id).val();

    $.ajax({
        url: '../admin-cni/proses-ajax.php',
        type: 'POST',
        dataType: 'html',
        data: 'nmr='+id+'&status='+status,
        beforeSend: function(){
            swal({
                title: "Sedang Memuat...",
                text: "",
                imageUrl: "../images/ajaxloader.gif"
            });
        },
        success: function(hasil){
            swal({
                title: hasil,
                text: "",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#86CCEB",
                confirmButtonText: "Ok",
                closeOnConfirm: false
                },
                function(){
                    window.location = '?adm=order';
                });
        }
    });
}

function resi(id) {
    var no_resi = $("#resi"+id).val();

    if (no_resi == "") {
        sweetAlert("No. Resi harus diisi!", "", "warning");
    }else{
        $.ajax({
            url: '../admin-cni/proses-ajax.php',
            type: 'POST',
            dataType: 'html',
            data: 'id='+id+'&noresi='+no_resi,
            beforeSend: function(){
                swal({
                    title: "Sedang Memuat...",
                    text: "",
                    imageUrl: "../images/ajaxloader.gif"
                });
            },
            success: function(hasil){
                swal({
                    title: hasil,
                    text: "",
                    type: "success",
                    showCancelButton: false,
                    confirmButtonColor: "#86CCEB",
                    confirmButtonText: "Ok",
                    closeOnConfirm: false
                    },
                    function(){
                        window.location = '?adm=order';
                    });
            }
        });
    }
}

//hapus attribut disabled pd tombol save
function removeDisabled(id) {
    $.ajax({
        url: '../admin-cni/proses-ajax.php',
        type: 'POST',
        dataType: 'html',
        data: 'rmv=button&id_rmv='+id,
        success: function(hasil) {
            $("#remove"+id).html(hasil);
        }
    });
}
