
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

    function editPost(postIdx) {
        var title = $("#title").val();
        var content = $("#content").val();
        var is_secret = $("#is_secret").prop("checked") ? 'Y' : 'N';
        let data = {
            action: 'edit', // 'edit'로 액션을 변경
            post_idx: postIdx, // 수정할 게시글의 idx를 추가
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
                    alert("게시글 수정 성공!");
                    window.location.href = response.redirect; // 수정 후 리다이렉트 할 URL
                } else {
                    console.log("Failed condition.")
                    alert("게시글 수정 실패!");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("에러 발생: " + textStatus + "!!!");
            }
        });
    }

    $("#submitPostBtn").click(function() {
        const postIdx = $("#post_idx").val();

        // If postIdx exists, it means we are editing a post. Else, we are creating a new post.
        if (postIdx) {
            editPost(postIdx); // Call the editPost function if post_idx is available.
        } else {
            CreatePost(); // Call your function to create a new post.
        }
    });
});
