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

    // 수정 버튼 클릭 이벤트 (이벤트 리스너)
    $(document).on("click", ".comment-edit-btn", function() {
        var commentId = $(this).data('comment-id');
        EditComment(this, commentId);
    });

    // 저장 버튼 클릭 이벤트
    $(document).on("click", ".comment-save-btn", function() {
        var commentId = $(this).data("comment-id");
        var newContent = $(this).siblings(".edit-textarea").val();
        SaveEditedComment(commentId, newContent);
    });

    // 삭제 버튼 클릭 이벤트
    $(document).on("click", ".comment-delete-btn", function() {
        var commentId = $(this).data('comment-id');
        DeleteComment(commentId);
    });

});

function CreateComment(content) {
    let data = {
        action: 'comment',
        post_idx: postIdx,
        content: content,
        group_idx: 1 // 일단이렇게 하고 관리자 할 때 바꾸자ㅠ
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

function EditComment(commentBtnElement, commentId) {
    // 클릭된 버튼의 가장 가까운 부모 요소 중 .comment-item 클래스를 가진 요소를 찾고, 그 요소 내의 <p> 태그의 텍스트를 가져옴
    var currentContent = $(commentBtnElement).closest('.comment-item').find('p').text();

    var textareaHtml = '<textarea class="edit-textarea">' + currentContent + '</textarea>';
    //replaceWith()는 선택한 요소를 다른 것으로 바꿈(텍스트 입력할 수 있는 란)
    $(commentBtnElement).closest('.comment-item').find('p').replaceWith(textareaHtml);

    var saveButtonHtml = '<button class="comment-save-btn" data-comment-id="' + commentId + '">저장</button>';
    $(commentBtnElement).after(saveButtonHtml); //버튼 바뀜
    $(commentBtnElement).hide(); // 버튼 사라짐
}

function SaveEditedComment(commentId, newContent) {
    $.ajax({
        type: "POST",
        url: "../Controllers/BoardController.php",
        dataType: "json",
        data: {
            action: "edit_comment",
            comment_idx: commentId,
            content: newContent
        },

        success: function(response) {

            if (response.status === 'success') {
                var commentItem = $("button[data-comment-id=" + commentId + "]").closest('.comment-item');
                commentItem.find("textarea.edit-textarea").replaceWith('<p>' + newContent + '</p>');
                commentItem.find(".comment-save-btn").remove();
                commentItem.find(".comment-edit-btn").show();
            } else {
                alert("댓글 수정에 실패했습니다.");
            }
        },

        error: function() {
            alert("서버 에러로 인해 댓글 수정에 실패했습니다.");
        }
    });
}

function DeleteComment(commentId) {
    let confirmDelete = confirm("정말로 이 댓글을 삭제하시겠습니까?");
    if (confirmDelete) {
        $.ajax({
            type: "POST",
            url: "../Controllers/BoardController.php",
            dataType: "json",
            data: {
                action: "delete_comment",
                comment_idx: commentId
            },
            success: function(response) {
                if (response.status === 'success') {
                    $("button[data-comment-id=" + commentId + "]").closest('.comment-item').remove();
                    alert("댓글이 삭제되었습니다.");
                } else {
                    alert("댓글 삭제에 실패했습니다.");
                }
            },
            error: function() {
                alert("서버 에러로 인해 댓글 삭제에 실패했습니다.");
            }
        });
    }
}
