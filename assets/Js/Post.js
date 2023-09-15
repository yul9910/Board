
$(document).ready(function() {
    function CreatePost() {


        var title = $("#title").val();
        var content = $("#content").val();
        var is_secret = $("#is_secret").prop("checked") ? 'Y' : 'N'; // 체크하는 함수래요..
        let data = {
            action: 'post',
            title: title,
            content: content,
            is_secret: is_secret
        };

        $.ajax({
            type: "POST",
            url: "../Controllers/BoardController.php",
            data: data,
            dataType: "json",
            success: function(response) {
                console.log(response);
                if (response.status == "success") {
                    window.location.href = response.redirect;
                } else {
                    console.log("Failed condition.")
                    alert("글 작성 실패!");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("에러 발생: " + textStatus + "!!!");
            }
        });
    }

    $("#submitPostBtn").click(function(){
        CreatePost();
    });
});
