$(document).ready(function() {
    function register(){
        var id = $("#id").val();
        var password = $("#password").val();
        var name = $("#name").val();
        let data = {
            action: 'register',
            id: id,
            password: password,
            name: name
        };

        $.ajax({
            type: "POST",
            url: "../Controllers/UserController.php",
            data: data,
            dataType: "json",
            success: function(response) {
                console.log(response);
                if (response.status == "success") {
                    window.location.href = response.redirect;
                } else {
                    console.log("Failed condition.")
                    alert("가입 실패!");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("에러 발생: " + textStatus + "!!!");
            }
        });
    }

    $("#regBtn").click(function(){
      register();
    });

});

