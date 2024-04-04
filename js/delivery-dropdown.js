document.addEventListener("DOMContentLoaded", function() {
    var dropdownToggleList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
    dropdownToggleList.forEach(function(dropdownToggle) {
        dropdownToggle.addEventListener('click', function() {
            var dropdownMenu = dropdownToggle.nextElementSibling;
            if (dropdownMenu.classList.contains('show')) {
                dropdownMenu.classList.remove('show');
            } else {
                dropdownMenu.classList.add('show');
            }
        });
    });

    window.addEventListener('click', function(event) {
        dropdownToggleList.forEach(function(dropdownToggle) {
            var dropdownMenu = dropdownToggle.nextElementSibling;
            if (!dropdownToggle.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.remove('show');
            }
        });
    });
});