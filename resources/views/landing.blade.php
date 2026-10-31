<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Introducing LesVol</title>
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

    <header class="navbar" id="navbar">
    <div class="logo">
        <img 
            src="images/logo_lesvol_white.png" 
            data-white="images/logo_lesvol_white.png"
            data-red="images/Logo_LesVol.png"
            alt="LesVol Logo"
            id="navbarLogo"
        >
    </div>

    <nav class="nav-links">
        <a href="#about">About Us</a>
        <a href="#mission">Our Mission</a>
    </nav>

    <div class="nav-buttons">
        <a href="\login" class="btn-login">Log In</a>
        <a href="\register" class="btn-signup">Sign Up</a>
    </div>
</header>
    <main>
        
    </main>
    <section class="hero">
        <video class="motion-bg" autoplay muted loop playsinline>
            <source src="images/Motion_graphic.mp4" type="video/mp4">
        </video>

        <div class="hero-overlay"></div>

        <div class="hero-content fade-in-up">
            <div class="hero-text">
                <h1>
                    <span class="hero-title-light">Small Actions,</span><br>
                    <span class="hero-title-bold">Big Impact.</span></h1>
                <p>We help you help others.</p>
                <a href="\register" class="start-btn">Start Now <span>➜</span></a>
            </div>

            <div class="hero-image-frame">
                <div class="photo-frame">
                    <img src="https://keepsmyrnabeautiful.com/wp-content/uploads/2024/04/IMG_1647-scaled.jpg" alt="Volunteer Event">
                </div>
            </div>
        </div>
    </section>

    <section class="about-section" id="about">
        <div class="section-header fade-in-up">
            <h2>About Us</h2>
            <p>
                LesVol is a volunteer discovery platform that connects passionate individuals with
                meaningful social activities and community programs. Through LesVol, users can
                easily explore volunteer opportunities that match their interests, skills, and
                availability. This platform also helps organizations reach more volunteers and build
                stronger community impact.
            </p>
        </div>

        <div class="carousel-wrapper fade-in-up">
            <div class="carousel-track">
                <img src="https://www.wastatepta.org/wp-content/uploads/2016/11/Senior-volunteer-helping-African-American-man-register-for-marathon-000065245281_Medium.jpg" alt="Volunteer Activity">
                <img src="https://www.tgccpa.com/wp-content/uploads/2025/04/AdobeStock_1132162675-scaled.jpeg" alt="Volunteer Activity">
                <img src="https://www.rosekennedygreenway.org/wp-content/uploads/2019/09/IMG_0933-1-scaled.jpg" alt="Volunteer Activity">
                <img src="https://cdn.prod.website-files.com/67b23d86ff5d772197443965/69ec81acccf7d761ba6ccbd7_Volunteer%20(Mobile)%201.png" alt="Volunteer Activity">

                <img src="https://www.wastatepta.org/wp-content/uploads/2016/11/Senior-volunteer-helping-African-American-man-register-for-marathon-000065245281_Medium.jpg" alt="Volunteer Activity">
                <img src="https://www.tgccpa.com/wp-content/uploads/2025/04/AdobeStock_1132162675-scaled.jpeg" alt="Volunteer Activity">
                <img src="https://www.rosekennedygreenway.org/wp-content/uploads/2019/09/IMG_0933-1-scaled.jpg" alt="Volunteer Activity">
                <img src="https://cdn.prod.website-files.com/67b23d86ff5d772197443965/69ec81acccf7d761ba6ccbd7_Volunteer%20(Mobile)%201.png" alt="Volunteer Activity">
            </div>
        </div>

        <p class="event-caption fade-in-up">
            Explore moments from volunteer events and community activities that have been successfully carried out.
        </p>
    </section>

    <section class="mission-section" id="mission">
        <div class="section-header fade-in-up">
            <h2>Our Mission</h2>
        </div>

        <div class="mission-cards fade-in-up">
            <div class="mission-card">
                <div class="icon-circle">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                </div>
                <h3>Make volunteering easier</h3>
                <p>
                    LesVol helps users find volunteer activities more simply without needing to search manually from many different sources.
                </p>
            </div>

            <div class="mission-card">
                <div class="icon-circle">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <h3>Make volunteering more accessible</h3>
                <p>
                    LesVol allows users to discover activities that match their interests, availability, and location.
                </p>
            </div>

            <div class="mission-card">
                <div class="icon-circle">
                    <i class="fa-solid fa-lightbulb"></i>
                </div>
                <h3>Make volunteering more impactful</h3>
                <p>
                    LesVol connects volunteers with meaningful social activities so their participation can create positive value for the community.
                </p>
            </div>
        </div>
    </section>

  <footer>
  <div class="footer-grid">
    <div class="footer-column-left">
      <img src="{{ asset('images/Logo_LesVol.png') }}" alt="LesVol Logo" class="footer-logo">
    </div>

    <div class="footer-column-middle">
      <div class="footer-text-block">
        <h4>About Us</h4>
        <p>LesVol is a volunteer discovery platform that connects passionate individuals with meaningful social activities and community programs.</p>
      </div>
      
      <div class="footer-text-block">
        <h4>Our Mission</h4>
        <p>Our mission is to make volunteering easier, more accessible, and more impactful by helping users find activities that match their interests, availability, and location.</p>
      </div>
    </div>

    <div class="footer-column-right">
      <h4>Contact Us</h4>
      <div class="footer-contact">
        <span>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l2.27-2.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
          </svg>
          +6212 6767 6767
        </span>
        <span>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 4h16c1.1 0 2 .9 2 2v14c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
            <polyline points="22,6 12,13 2,6"/>
          </svg>
          cs@lesvol.co.id
        </span>
      </div>
    </div>
  </div>

  <hr class="footer-divider">

  <div class="footer-bottom">
    <div class="footer-copyright">
      &copy; {{ date('Y') }} LesVol. All rights reserved.
    </div>
    
    <div class="footer-socials">
      <a href="https://instagram.com" target="_blank" class="social-icon" aria-label="Instagram">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
      </a>
      <a href="https://x.com" target="_blank" class="social-icon" aria-label="X">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4l11.733 16h4.267l-11.733 -16z M4 20l6.768 -6.768 M20 4l-6.768 6.768"/></svg>
      </a>
      <a href="https://tiktok.com" target="_blank" class="social-icon" aria-label="TikTok">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path></svg>
      </a>
      <a href="https://facebook.com" target="_blank" class="social-icon" aria-label="Facebook">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
      </a>
    </div>
  </div>
</footer>

<script src="{{ asset('js/landing.js') }}"></script>
@if(session('success'))
<div id="success-toast" style="position: fixed; top: 20px; right: 20px; background: rgba(236, 253, 245, 0.95); border: 1.5px solid #a7f3d0; color: #065f46; padding: 16px 24px; border-radius: 16px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); z-index: 99999; display: flex; align-items: center; gap: 14px; font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-weight: 600; font-size: 14px; min-width: 320px; max-width: 450px; animation: slideInToast 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;">
  <div style="background: #10b981; color: #ffffff; border-radius: 50%; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.4);">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
      <polyline points="20 6 9 17 4 12"></polyline>
    </svg>
  </div>
  <div style="flex-grow: 1; line-height: 1.4;">
    <div style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: #10b981; margin-bottom: 2px; font-weight: 800;">Success</div>
    <div>{{ session('success') }}</div>
  </div>
  <button onclick="document.getElementById('success-toast').remove()" style="background: none; border: none; color: #065f46; cursor: pointer; font-size: 22px; font-weight: 500; margin-left: 8px; padding: 0 4px; display: flex; align-items: center; justify-content: center; transition: opacity 0.2s; opacity: 0.7;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.7'">&times;</button>
</div>
<style>
@keyframes slideInToast {
  from { transform: translateY(-20px) scale(0.95); opacity: 0; }
  to { transform: translateY(0) scale(1); opacity: 1; }
}
</style>
@endif
</body>
</html>