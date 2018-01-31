function addProv(i) {
    if (i===undefined)
    {
        i=1;
    }
    else
    {
        i++;
    }
    if (i<10)
    {
        var capt="<h3 onclick='addProv(" + (i) + ");'>+ Добавить еще товар к заявке</h3>"
    }
    else
    {
        var capt="<h3>Нельзя больше добавить товар</h3>";
    }
        var str = "i=" + i;
        var id = "#nom" + i;
        $.ajax({
            type: "POST",
            url: "/js/addProv.php",
            data: str,
            success: function (html) {
                $(id).html(html);
                $("#addProv").html(capt);
            }
        })



}