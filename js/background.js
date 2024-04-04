const backgroundImages = ["img/Content-Background.jpg", "img/Content-Background2.jpg","img/Content-Background3.jpg"]; // Add more images if needed
let currentImageIndex = 0;

document.getElementById('left-arrow').addEventListener('click', function() {
    currentImageIndex = (currentImageIndex - 1 + backgroundImages.length) % backgroundImages.length;
    updateBackgroundImage();
});

document.getElementById('right-arrow').addEventListener('click', function() {
    currentImageIndex = (currentImageIndex + 1) % backgroundImages.length;
    updateBackgroundImage();
});

function updateBackgroundImage() {
    const backgroundImage = document.querySelector('.background-image');
    backgroundImage.src = backgroundImages[currentImageIndex];
}