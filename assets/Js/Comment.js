var postIdx; // 전역 변수로 선언

$(document).ready(function() {
    postIdx = $("#post_idx").val(); // 값을 할당합니다.

    $("#comment-submit-btn").click(function(){
        var commentContent = $("#comment-textarea").val();

        // 댓글 내용이 비어 있지 않을 때만 실행
        if (commentContent) {
            CreateComment(commentContent);
        } else {
            alert("댓글 내용을 입력하세요.");
        }
    });
});

function CreateComment(content) {
    let data = {
        action: 'comment',
        post_idx: postIdx,
        content: content,
        group_idx: 1 //일단 이렇게 하고 나중에 관리자 모드 할 때 바꿔보자ㅠ
    };

    $.ajax({
        type: "POST",
        url: "../Controllers/BoardController.php",
        data: data,
        dataType: "json",
        success: function(response) {
            console.log(response);
            if (response.status == "success") {
                location.reload();
            } else {
                alert("댓글 작성 실패!");
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert("에러 발생: " + textStatus);
        }
    });
}
