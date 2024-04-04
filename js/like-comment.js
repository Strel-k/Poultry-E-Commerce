document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.like-btn').forEach(item => {
        item.addEventListener('click', event => {
            const commentId = item.getAttribute('data-comment-id'); // Get the comment ID from the button attribute
            likeComment(commentId);
        });
    });
});

function likeComment(commentId, userId) {
    fetch('script/like-comment.php', {
        method: 'POST',
        body: JSON.stringify({ comment_id: commentId, user_id: userId }), // Include user_id in the request body
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        const likeBtn = document.querySelector('.like-btn[data-comment-id="' + commentId + '"]');
        if (likeBtn) {
            likeBtn.classList.toggle('liked');
            if (data.success && data.total_likes !== undefined) {
                likeBtn.textContent = data.total_likes + (data.total_likes !== 1 ? ' Likes' : ' Like');
            } else {
                console.error('Invalid response from server:', data);
            }
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}
