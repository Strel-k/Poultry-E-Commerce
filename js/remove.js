document.addEventListener('DOMContentLoaded', function() {
    const removeButtons = document.querySelectorAll('.remove-product-btn');

    removeButtons.forEach(button => {
        button.addEventListener('click', function() {
            if (confirm('Are you sure you want to remove this product?')) {
                const productId = button.getAttribute('data-product-id');
                removeProduct(productId);
            }
        });
    });

    function removeProduct(productId) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'script/remove-product.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const container = document.querySelector('[data-product-id="' + productId + '"]').closest('.checkout-container');
                    container.remove();
                } else {
                    console.error('Error:', xhr.responseText);
                }
            }
        };
        xhr.send('product_id=' + productId);
    }
});
