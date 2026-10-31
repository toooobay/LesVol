function toggleDropdown(id) {
    const targetId = id || 'nav-dropdown';
    const targetMenu = document.getElementById(targetId);

    document.querySelectorAll('.dropdown-menu').forEach(menu => {
        if (menu !== targetMenu) {
            menu.classList.remove('open');
        }
    });

    if (targetMenu) {
        targetMenu.classList.toggle('open');
    }
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.dropdown-wrapper')) {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.classList.remove('open');
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.querySelector('nav');

    if (navbar) {
        window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
        });
    }
});

document.addEventListener("DOMContentLoaded", function() {
  const animatedElements = document.querySelectorAll('.fade-in-up');

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('show');
        
        observer.unobserve(entry.target); 
      }
    });
  }, {
    threshold: 0.15
  });

  animatedElements.forEach(el => observer.observe(el));
});

function submitWithCsrf(action, method) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = action;

    const fields = {
        _token: document.querySelector('meta[name="csrf-token"]').content,
    };

    if (method) {
        fields._method = method;
    }

    Object.entries(fields).forEach(([name, value]) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = value;
        form.appendChild(input);
    });

    document.body.appendChild(form);
    form.submit();
}

// Intercept logout and show confirmation
document.addEventListener('click', function(e) {
    const logoutBtn = e.target.closest('a');
    if (logoutBtn && logoutBtn.textContent.trim().toLowerCase().includes('log out')) {
        if (!confirm('Apakah Anda yakin ingin keluar?')) {
            e.preventDefault();
        } else {
            e.preventDefault();
            submitWithCsrf('/logout');
        }
    }
});
