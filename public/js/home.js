const grid = document.getElementById('home-grid');

function doLogin() {
    const email = document.getElementById('email').value;
    const pass = document.getElementById('password').value;
    if (!email || !pass) {
    document.getElementById('error-msg').style.display = 'block';
    return;
    }
    window.location.href = '/home';
}
let currentHeroSlide = 0;
let heroInterval = null;

function showHeroSlide(index) {
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.carousel-dot');

    if (!slides.length) return;

    if (index >= slides.length) {
        currentHeroSlide = 0;
    } else if (index < 0) {
        currentHeroSlide = slides.length - 1;
    } else {
        currentHeroSlide = index;
    }

    slides.forEach((slide, i) => {
        slide.classList.toggle('active', i === currentHeroSlide);
    });

    dots.forEach((dot, i) => {
        dot.classList.toggle('active', i === currentHeroSlide);
    });
}

function changeHeroSlide(direction) {
    showHeroSlide(currentHeroSlide + direction);
    resetHeroInterval();
}

function goToHeroSlide(index) {
    showHeroSlide(index);
    resetHeroInterval();
}

function resetHeroInterval() {
    clearInterval(heroInterval);

    heroInterval = setInterval(() => {
        showHeroSlide(currentHeroSlide + 1);
    }, 3000);
}

document.addEventListener('DOMContentLoaded', function () {
    showHeroSlide(0);
    resetHeroInterval();
});
