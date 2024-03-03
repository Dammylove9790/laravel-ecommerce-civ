let mainImage = document.querySelector("#mainImage");
let smallImages = document.querySelectorAll(".smallImages");

function smallImage(element) {
    mainImage.src = element.src;
    checkActiveImage();
}

function checkActiveImage() {
    for (let i = 0; i < smallImages.length; i++) {
        if (mainImage.src === smallImages[i].src) {
            smallImages[i].style.border = "2px solid green";
        } else {
            smallImages[i].style.border = "none";
        }
    }
}

smallImages[0].style.border = "2px solid green";
