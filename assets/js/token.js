$( document ).ready(function() {
    $("form").each(function () {
        var formm=$(this);
        var a=formm.attr("name");
        $.ajax({
            url: "assets/ajax/token.php",
            type: "POST",
            data: {form_name : a},
            dataType: "html",
            'success' : function(data) {
                var input='<input type="hidden" id="'+a+'_token" name="token" value="'+data+'">';
                formm.append(input);
            }
        });

    })
});