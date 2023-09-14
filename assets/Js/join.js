function check_input() {
    function check_input()
    {
        if (!$("#id").val()) {
            alert("아이디를 입력하세요!");
            $("#id").focus();
            return;
        }

        if (!$("#pass").val()) {
            alert("비밀번호를 입력하세요!");
            $("#pass").val().focus();
            return;
        }

        if (!$("#pass_confirm").val()) {
            alert("비밀번호확인을 입력하세요!");
            $("#pass_confirm").focus();
            return;
        }

        if (!$("#name").val()) {
            alert("이름을 입력하세요!");
            $("#name").focus();
            return;
        }

        if (!$("#phone").val()) {
            alert("전화번호를 입력하세요!");
            $("#phone").focus();
            return;
        }

        if (!$("#email").val()) {
            alert("이메일 주소를 입력하세요!");
            $("#email").focus();
            return;
        }

        if ( $("#pass").val() !=
            $("#pass_confirm").val()) {
            alert("비밀번호가 일치하지 않습니다.\n다시 입력해 주세요!");
            $("#pass").focus();
            $("#pass").select();
            return;
        }

        document.join.submit();
    }
}

function reset_form() {
    function reset_form() {
        document.join.id.value = "";
        document.join.pass.value = "";
        document.join.pass_confirm.value = "";
        document.join.name.value = "";
        document.join.gender.value = "";
        document.join.phone.value = "";
        document.join.email.value = "";
        document.join.id.focus();
        return;
    }
}
