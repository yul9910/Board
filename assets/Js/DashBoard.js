function redirectToDashboard() {
    window.location.href = "DashBoard.php";
}

$(document).ready(function() {


    function deletePost(post_idx) {
        // AJAX를 사용하여 게시글 삭제 로직 구현
        // 사용 예: post_idx를 사용하여 해당 게시글을 삭제합니다.
    }


    $("#delBtn").click(function(){
        const postIdx = $(this).data("post-idx"); // 버튼의 data-post-idx 속성에서 post_idx 값을 가져옵니다.
        deletePost(postIdx);
    });
});
