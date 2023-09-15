$(document).ready(function(){

    function logout() {
        $.ajax({
            type: "POST",
            url: "../Controllers/UserController.php",
            data: {
                action: 'logout',
            },
            dataType: "json",
            success: function (response) {

                // 서버에서 응답이 올바르게 처리되었는지 확인 (예: response.status == 'success')
                if (response.status == 'success') {
                    window.location.href = '../Views/Login.php';  // 로그아웃 성공 후 로그인 페이지로 리디렉션
                } else {
                    alert('로그아웃 실패');
                }
            },
            error: function () {
                alert('서버 오류 발생');
            }
        });
    }

        $("#logoutBtn").click(function(event){
            logout();
    });
});
