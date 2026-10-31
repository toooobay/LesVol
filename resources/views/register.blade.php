<!DOCTYPE html>
<html lang="id">


<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LesVol - Register</title>
  <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>


<body>


  <nav class="{{ request()->is('home') ? 'transparent-nav' : 'solid-nav' }}">
    <a class="nav-brand" href="/home">
      <img src="{{ asset('images/Logo_LesVol.png') }}" alt="LesVol Logo" class="brand-logo">
    </a>
    <div class="nav-links">
      <a href="/login">Login</a>


      <div class="dropdown-wrapper">
        <div class="nav-avatar" onclick="toggleDropdown('nav-dropdown')" id="avatar-trigger">
          @if(session('user')?->profile_picture_path)
            <img src="{{ asset('storage/' . session('user')->profile_picture_path) }}"
                 alt="Profile"
                 style="width:32px; height:32px; border-radius:50%; object-fit:cover; display:block;">
          @else
            <svg width="20" height="20" viewBox="0 0 24 24">
              <defs>
                  <linearGradient id="myRedGradient" x1="92%" y1="76%" x2="8%" y2="24%">
                      <stop offset="0%" stop-color="var(--red)" />
                      <stop offset="100%" stop-color="var(--red-light)" />
                  </linearGradient>
              </defs>
              <circle cx="12" cy="8" r="4" fill="url(#myRedGradient)" />
              <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" fill="url(#myRedGradient)" />
            </svg>
          @endif
        </div>


        <div class="dropdown-menu" id="nav-dropdown" style="right: 0; left: auto; background: var(--white); min-width: 180px; padding: 3px 0; margin-top: 12px">

        <div id="state-logged-out">
          <a href="/login" class="dropdown-item" style="font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 10px; padding: 15px 20px; border-bottom: 1px solid rgba(139, 26, 26, 0.15)">
            Log In
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="url(#dropdownGradient)" stroke-width="2">
                <defs>
                  <linearGradient id="dropdownGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" stop-color="var(--red)" />
                    <stop offset="100%" stop-color="var(--red-light)" />
                  </linearGradient>
                </defs>
                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h4M10 17l5-5-5-5M13 12H3"/>
            </svg>
          </a>
          <a href="/register" class="dropdown-item" style="font-weight: 700; text-align: center; padding: 15px 20px;">Sign Up</a>
        </div>


      </div>
      </div>
    </div>
  </nav>


  <div class="auth-container fade-in-up" style="padding: 32px 24px; align-items:flex-start;">
    <div class="auth-card" style="max-width: 680px; padding: 40px;">
      <div class="auth-title">Become a Volunteer!</div>
      <div class="auth-subtitle">One step a way to make real change.</div>


      <form method="POST" action="/user-register">
        @csrf


        <div class="form-group">
          <label for="volunteer_type">Volunteer Type</label>
          <input id="volunteer_type" name="volunteer_type"
            class="form-input @error('volunteer_type') is-invalid @enderror" type="text" placeholder="Type"
            value="{{ old('volunteer_type') }}">
          @error('volunteer_type')
          <span class="error-message" style="color: var(--red-btn); font-size: 12px;">{{ $message }}</span>
          @enderror
        </div>

          <div class="form-group">
            <label for="name">Name</label>
            <input id="name" name="name" class="form-input @error('name') is-invalid @enderror" type="text"
              placeholder="Name" value="{{ old('name') }}">
            @error('name')
            <span class="error-message" style="color: var(--red-btn); font-size: 12px;">{{ $message }}</span>
            @enderror
          </div>


        <div class="form-row">
          <div class="form-group">
            <label for="email">Email Address</label>
            <input id="email" name="email" class="form-input @error('email') is-invalid @enderror" type="email"
              placeholder="Email Address" value="{{ old('email') }}">
            @error('email')
            <span class="error-message" style="color: var(--red-btn); font-size: 12px;">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label for="phone">Phone Number</label>
            <input id="phone" name="phone" class="form-input @error('phone') is-invalid @enderror" type="tel"
              placeholder="Phone Number" value="{{ old('phone') }}">
            @error('phone')
            <span class="error-message" style="color: var(--red-btn); font-size: 12px;">{{ $message }}</span>
            @enderror
          </div>
        </div>


        <div class="form-row-3">
          <div class="form-group">
            <label for="dob">Date of Birth</label>
            <input id="dob" name="dob" class="form-input @error('dob') is-invalid @enderror" type="date"
              placeholder="Date of Birth" value="{{ old('dob') }}">
            @error('dob')
            <span class="error-message" style="color: var(--red-btn); font-size: 12px;">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label for="occupation">Occupation</label>
            <input id="occupation" name="occupation" class="form-input @error('occupation') is-invalid @enderror"
              type="text" placeholder="Occupation" value="{{ old('occupation') }}">
            @error('occupation')
            <span class="error-message" style="color: var(--red-btn); font-size: 12px;">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label for="pob">Domicile</label>
            <input id="domicile" name="domicile" class="form-input @error('domicile') is-invalid @enderror" type="text"
              placeholder="Domicile" value="{{ old('domicile') }}">
            @error('domicile')
            <span class="error-message" style="color: var(--red-btn); font-size: 12px;">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="password">Password</label>
            <input id="password" name="password" class="form-input @error('password') is-invalid @enderror"
              type="password" placeholder="Type Password Here">
            @error('password')
            <span class="error-message" style="color: var(--red-btn); font-size: 12px;">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" name="password_confirmation" class="form-input" type="password"
              placeholder="Type Password Here">
          </div>
        </div>


        <div class="checkbox-row">
          <input type="checkbox" id="terms" name="terms" value="1" {{ old('terms') ? 'checked' : '' }}>
          <label for="terms">I agree to LesVol's <a href="#">Terms of Service</a> and <a href="#">Privacy
              Policy</a></label>
        </div>
        @error('terms')
        <span class="error-message"
          style="color: var(--red-btn); font-size: 12px; display: block; margin-top: -8px; margin-bottom: 8px;">{{
          $message }}</span>
        @enderror


        <button type="submit" class="btn btn-primary btn-full" style="margin-top:8px;">Create Account</button>
      </form>


      <div style="text-align:center; margin-top:16px; font-size:13px; color:var(--gray);">
        Already have an account? <a href="/login" style="color:var(--red-btn); font-weight:600;">Log in</a>
      </div>
    </div>
  </div>


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


</body>
<script src="{{asset('js/dropdown_login.js')}}"></script>


</html>

