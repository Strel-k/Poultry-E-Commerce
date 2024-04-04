function incrementQuantity() {
    var quantityInput = document.getElementById('total_quantity');
    var currentValue = parseInt(quantityInput.value);
    quantityInput.value = currentValue + 1;
    updateTotalPrice();
}

function decrementQuantity() {
    var quantityInput = document.getElementById('total_quantity');
    var currentValue = parseInt(quantityInput.value);
    if (currentValue > 1) {
        quantityInput.value = currentValue - 1;
        updateTotalPrice();
    }
}

function updateTotalPrice() {
    var quantityInput = document.getElementById('total_quantity');
    var totalPriceInput = document.getElementById('total_price');  // Change this line
    var productPriceInput = document.getElementById('price');
    var quantity = parseInt(quantityInput.value);
    var productPrice = parseFloat(productPriceInput.value);
    var totalPrice = quantity * productPrice;
    totalPriceInput.value = totalPrice.toFixed(2);        
}
    