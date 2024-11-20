let slideIndex = 0;
const slides = document.querySelectorAll(".slide");
const dots = document.querySelectorAll(".dot");

function showSlide(index) {
    slides.forEach((slide, i) => {
        // Reset all classes first
        slide.classList.remove('active', 'prev', 'next');
        
        // If it's the current slide, make it 'active'
        if (i === index) {
            slide.classList.add('active');
        } 
        // Handle previous and next slides for animation
        else if (i === (index - 1 + slides.length) % slides.length) {
            slide.classList.add('prev'); // Previous slide (to the left)
        } else if (i === (index + 1) % slides.length) {
            slide.classList.add('next'); // Next slide (to the right)
        }
    });

    dots.forEach((dot, i) => {
        dot.classList.toggle("bg-indigo-600", i === index);
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

// Add event listeners for next/prev buttons
document.getElementById("next").addEventListener("click", nextSlide);
document.getElementById("prev").addEventListener("click", prevSlide);

// Add event listeners for dots
dots.forEach((dot, i) =>
    dot.addEventListener("click", () => showSlide((slideIndex = i)))
);

// Initialize first slide
showSlide(slideIndex);

// Auto slideshow
setInterval(nextSlide, 10000);



// JavaScript to handle 'action' in the response
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".favorite-icon").forEach((icon) => {
        icon.addEventListener("click", function () {
            const videoId = this.getAttribute("data-video-id");
            const isFavorited = this.classList.toggle("favorited");

            // Change icon based on favorite status
            this.src = isFavorited
                ? "../img/filled_star.jpg"
                : "../img/ster.png";

            // AJAX request to update favorite status in the database
            fetch("toggle_favorite.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ video_id: videoId }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        if (data.action === "added") {
                            console.log(
                                `Added to favorites: video ID ${videoId}`
                            );
                        } else if (data.action === "removed") {
                            console.log(
                                `Removed from favorites: video ID ${videoId}`
                            );
                        }
                    } else {
                        console.error(
                            "Error updating favorite status:",
                            data.error
                        );
                    }
                })
                .catch((error) => console.error("AJAX error:", error));
        });
    });
});








function toggleDropdown(event) {
    event.stopPropagation(); // Prevents the click event from reaching the window.onclick
    const dropdown = document.getElementById("profileDropdown");
    dropdown.classList.toggle("hidden"); // Toggle visibility
}

// Add click event listener to profile button
document
    .getElementById("profileButton")
    .addEventListener("click", toggleDropdown);

// Hide dropdown when clicking outside of it
window.onclick = function (event) {
    const dropdown = document.getElementById("profileDropdown");
    if (
        !dropdown.classList.contains("hidden") &&
        !event.target.closest("#profileButton") &&
        !event.target.closest("#profileDropdown")
    ) {
        dropdown.classList.add("hidden"); // Hide dropdown if it's visible and click is outside
    }
};
