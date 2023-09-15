// jQuery 라이브러리를 사용하기 때문에, 해당 라이브러리가 이미 HTML 파일에서 로드되어있어야 합니다.
$(document).ready(function() {
function Login() {

    // 아이디와 비밀번호 값을 가져옵니다.
    var id = $("#id").val();
    var password = $("#password").val();

    $.ajax({
        type: "POST",
        url: "../Controllers/UserController.php",
        data: {
            action: 'login',
            id: id,
            password: password
        },
        dataType: "json",
        success: function(response) {
            console.log(response);
            if (response.status == "success") {
                window.location.href = response.redirect;
            } else {
                console.log("Failed condition.")
                alert("로그인 실패!");
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert("에러 발생: " + textStatus + "!!!");
        }
    });
}

    $("#logBtn").click(function(){
        Login();
    });
});
