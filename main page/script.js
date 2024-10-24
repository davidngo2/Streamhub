function toggleDropdown() {
    document.getElementById("profileDropdown").classList.toggle("hidden");
}

// Slideshow Functionality
let slideIndex = 0;
const slides = document.querySelectorAll(".slide");
const dots = document.querySelectorAll(".dot");

function showSlide(index) {
    slides.forEach((slide, i) => {
        slide.classList.toggle("active", i === index);
        dots[i].classList.toggle("bg-indigo-600", i === index);
    });
}

function nextSlide() {
    slideIndex = (slideIndex + 1) % slides.length;
    showSlide(slideIndex);
}

function prevSlide() {
    slideIndex = (slideIndex - 1 + slides.length) % slides.length;
    showSlide(slideIndex);
}

document.getElementById("next").addEventListener("click", nextSlide);
document.getElementById("prev").addEventListener("click", prevSlide);
dots.forEach((dot, i) =>
    dot.addEventListener("click", () => showSlide((slideIndex = i)))
);

setInterval(nextSlide, 10000); // Auto slideshow
