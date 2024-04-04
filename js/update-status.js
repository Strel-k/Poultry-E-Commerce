document.addEventListener("DOMContentLoaded", function() {
    var dropdownItems = document.querySelectorAll('.dropdown-item');
    var dropdownToggleList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));

    dropdownItems.forEach(function(item) {
        item.addEventListener('click', function() {
            var orderId = item.closest('tr').querySelector('.orderId').innerText;
            var newStatus = item.innerText;
            updateStatus(orderId, newStatus);
        });
    });

    function updateStatus(orderId, newStatus) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "script/update-status.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Update UI or handle response
                console.log(xhr.responseText);
                // Optionally, update the status in the UI without reloading the page
                // For example, find the corresponding status element and update its text
                var statusElement = document.getElementById('status_' + orderId);
                if (statusElement) {
                    statusElement.innerText = newStatus;
                }
            }
        };
        xhr.send("orderId=" + orderId + "&newStatus=" + newStatus);
    }

    window.addEventListener('click', function(event) {
        dropdownToggleList.forEach(function(dropdownToggle) {
            var dropdownMenu = dropdownToggle.nextElementSibling;
            if (!dropdownToggle.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.remove('show');
            }
        });
    });
});
