const navbar = document.getElementById("navbar");
const navbarLogo = document.getElementById("navbarLogo");

window.addEventListener("scroll", function () {
    if (window.scrollY > 80) {
        navbar.classList.add("scrolled");
        navbarLogo.src = navbarLogo.dataset.red;
    } else {
        navbar.classList.remove("scrolled");
        navbarLogo.src = navbarLogo.dataset.white;
    }
});

document.addEventListener("DOMContentLoaded", function() {
  const animatedElements = document.querySelectorAll('.fade-in-up');

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('show');
      } else {
        entry.target.classList.remove('show');
      }
    });
  }, {
    threshold: 0.15 
  });

  animatedElements.forEach(el => observer.observe(el));
});