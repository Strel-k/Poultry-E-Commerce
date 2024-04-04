    function toggleEditForm(commentId) {
        var editForm = document.getElementById('editForm' + commentId);
        if (editForm.style.display === 'none') {
            editForm.style.display = 'block';
        } else {
            editForm.style.display = 'none';
        }
    }
