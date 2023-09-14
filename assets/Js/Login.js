// jQuery 라이브러리를 사용하기 때문에, 해당 라이브러리가 이미 HTML 파일에서 로드되어있어야 합니다.

function check_input() {
    // 입력 검증은 여기에 필요한 경우 추가할 수 있습니다.

    // 아이디와 비밀번호 값을 가져옵니다.
    var id = $("#id").val();
    var password = $("#password").val();

    $.ajax({
        type: "POST",
        url: "../Controllers/UserController.php",
        data: {
            id: id,
            password: password
        },
        dataType: "json",
        success: function(response) {
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

function reset_form() {
    $("#id").val("");
    $("#password").val("");
}

$(document).ready(function() {
    $('form[name="join"]').on('submit', function(e) {
        e.preventDefault();  // 폼의 기본 동작(페이지 이동)을 방지
        check_input();      // 폼 제출 시 check_input 함수를 호출
    });
});
