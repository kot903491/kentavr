function getTovTable(date) {
    var str="date="+date;
    $.ajax({
        type: "POST",
        url: "/js/viewOrder.php",
        data: str,
        success: function (html) {
            $("#orderTable").html(html);
            $("#tableDetail").html("");
            $(document).ready(function() {
                $('table tr').on('click', function () {
                    $('.click').removeClass('click');
                    $(this).toggleClass('click');
                });
            });
        }
    })
}


function getTableDetail(date,tovname) {
    var str="dat="+date+"&tov="+tovname;
    $.ajax({
        type: "POST",
        url: "/js/viewOrder.php",
        data: str,
        success: function (html) {
            $("#tableDetail").html(html);
        }
    });
}


$(document).ready(function(){
    $("#tab0").click();
});