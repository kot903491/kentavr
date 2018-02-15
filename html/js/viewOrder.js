function getTableDetail(date,tovname,un,i) {
    clrdiv();
    var str="dat="+date+"&tov="+tovname+"&un="+un;
    var id="#tableDetail"+i;
    $.ajax({
        type: "POST",
        url: "/js/viewOrder.php",
        data: str,
        success: function (html) {
            $(id).html(html);
        }
    });
}

function clrdiv() {
    for(x=0;x<20;x++){
        var xx="#tableDetail"+x;
        $(xx).html('');
    }
}

$(document).ready(function() {
    $('.tovname').on('click', function () {
        $('.click').removeClass('click');
        $(this).toggleClass('click');
    });
});