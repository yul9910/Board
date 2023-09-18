$(document).ready(function(){

    function unregister() {
        $.ajax({
            type: "POST",
            url: "../Controllers/UserController.php",
            data: {
                action: 'unregister',
            },
            dataType: "json",
            success: function (response) {

                // 서버에서 응답이 올바르게 처리되었는지 확인 (예: response.status == 'success')
                if (response.status == 'success') {
                    window.location.href = '../Views/Login.php';  // 로그아웃 성공 후 로그인 페이지로 리디렉션
                } else {
                    alert('회원탈퇴 실패');
                }
            },
            error: function () {
                alert('서버 오류 발생');
            }
        });
    }

    $("#unregBtn").click(function(event){
        event.preventDefault(); // 기본 a태그의 동작을 막고 실행!

        // 탈퇴 확인 메시지
        var result = confirm("정말로 탈퇴하시겠습니까?!!");

        if(result) {
            unregister();
        }
    });
});
