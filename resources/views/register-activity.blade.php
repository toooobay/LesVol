<!DOCTYPE html>
<html lang="id">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LesVol - Register Activity</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>

<body>
<nav class="{{ request()->is('home') ? 'transparent-nav' : 'solid-nav' }}">
    <a class="nav-brand" href="/home">
        <img src="{{ asset('images/Logo_LesVol.png') }}" alt="LesVol Logo" class="brand-logo">
    </a>
    <div class="nav-links">
      <a href="/home" class="{{ request()->is('home') ? 'active' : '' }}">Home</a>      
      <a href="/my-activities" class="{{ request()->is(
          'my-activities', 
          'activity*', 
          'upload-activity', 
          'done-activity', 
          'banned-activities', 
          'proposed-activities', 
          'register-activity/*', 
          'see-details*', 
          'options/*', 
          'participants'
      ) ? 'active' : '' }}">My Activities</a>

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

        <div class="dropdown-menu" id="nav-dropdown"
          style="right: 0; left: auto; background: var(--white); min-width: 180px; padding: 3px 0; margin-top: 12px">

          <div id="state-logged-in">
            <a href="/profile" class="dropdown-item {{ request()->is('profile*', '*portfolio*', 'edit-profile') ? 'active' : '' }}"
              style="font-weight: 700; text-align: center; padding: 15px 20px; border-bottom: 1px solid rgba(139, 26, 26, 0.15)">
              View Profile
            </a>

            @if (!$isSeeker)
            <a href="/be-a-seeker" class="dropdown-item {{ request()->is('be-a-seeker') ? 'active' : '' }}"
              style="font-weight: 700; text-align: center; padding: 15px 20px; border-bottom: 1px solid rgba(139, 26, 26, 0.15)">
              Be a Seeker!
            </a>
            @endif

            <a href="/login" class="dropdown-item"
              style="font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 10px; padding: 15px 20px; border-bottom: 1px solid rgba(139, 26, 26, 0.15)">
              Log Out
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="url(#dropdownGradient)" stroke-width="2">
                <defs>
                  <linearGradient id="dropdownGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" stop-color="var(--red)" />
                    <stop offset="100%" stop-color="var(--red-light)" />
                  </linearGradient>
                </defs>
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9" />
              </svg>
            </a>

            <form action="{{ route('user.delete', session('user')?->id ?? 0) }}" method="POST" style="display: block; margin: 0;">
              @csrf
              @method('DELETE')
              <a href="#" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete your account? This action cannot be undone.')) { this.closest('form').submit(); }" class="dropdown-item" style="font-weight: 700; text-align: center; padding: 15px 20px; display: block;">
                Delete Account
              </a>
            </form>
            @if(session('error'))
            <div id="error-toast" style="position: fixed; top: 20px; right: 20px; background: rgba(254, 226, 226, 0.95); border: 1.5px solid #fca5a5; color: #991b1b; padding: 16px 24px; border-radius: 16px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); z-index: 99999; display: flex; align-items: center; gap: 14px; font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-weight: 600; font-size: 14px; min-width: 320px; max-width: 450px; animation: slideInToast 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;">
              <div style="background: #ef4444; color: #ffffff; border-radius: 50%; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.4);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="12" cy="12" r="10"></circle>
                  <line x1="12" y1="8" x2="12" y2="12"></line>
                  <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
              </div>
              <div style="flex-grow: 1; line-height: 1.4;">
                <div style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: #ef4444; margin-bottom: 2px; font-weight: 800;">Deletion Blocked</div>
                <div>{{ session('error') }}</div>
              </div>
              <button onclick="document.getElementById('error-toast').remove()" style="background: none; border: none; color: #991b1b; cursor: pointer; font-size: 22px; font-weight: 500; margin-left: 8px; padding: 0 4px; display: flex; align-items: center; justify-content: center; transition: opacity 0.2s; opacity: 0.7;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.7'">&times;</button>
            </div>
            <style>
            @keyframes slideInToast {
              from { transform: translateY(-20px) scale(0.95); opacity: 0; }
              to { transform: translateY(0) scale(1); opacity: 1; }
            }
            </style>
            @endif
          </div>

          <div id="state-logged-out" style="display: none;">
            <a href="/login" class="dropdown-item"
              style="font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 10px; padding: 15px 20px;">
              Log In
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="url(#dropdownGradient)" stroke-width="2">
                <defs>
                  <linearGradient id="dropdownGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" stop-color="var(--red)" />
                    <stop offset="100%" stop-color="var(--red-light)" />
                  </linearGradient>
                </defs>
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9" />
              </svg>
            </a>
            <a href="/register" class="dropdown-item"
              style="font-weight: 700; text-align: center; padding: 15px 20px;">Sign Up</a>
          </div>
        </div>
      </div>
    </div>
</nav>

    <div style="flex:1; padding: 32px; max-width:900px; margin-left: 25%; width:100%;">
        <a class="back-btn" href="/home" style="margin-bottom:20px; display:inline-flex;">
            <div class="back-icon">◀</div> Back
        </a>

        <div style="background:white; border-radius:20px; box-shadow:var(--card-shadow); padding:36px; width:100%; max-width:700px;">
            <div class="auth-title">Register</div>
            <div class="auth-subtitle">Start making a change!</div>

            <div class="register-activity-image activity-img-contain"
                style="background-image: url('{{ asset('storage/' . $activity->image_path) }}');">
            </div>

            <div class="reg-activity-name">{{ $activity->activity_name }}</div>

            <div class="reg-activity-meta"
                style="display: flex; align-items: center; justify-content: center; gap: 15px; margin-top: 8px;">
                <span style="display: flex; align-items: center; gap: 6px; color: var(--gray);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    {{ $activity->location }}
                </span>

                <span style="display: flex; align-items: center; gap: 6px; color: var(--gray);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    {{ $activity->activity_date }}
                </span>
            </div>
            <div style="
    margin-top: 18px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 12px;
">
    <div style="
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #d9d9d9;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    ">
        @if($activity->seeker && $activity->seeker->user && $activity->seeker->user->profile_picture_path)
            <img src="{{ asset('storage/' . $activity->seeker->user->profile_picture_path) }}"
                 alt="Organizer Profile"
                 style="width:100%; height:100%; object-fit:cover;">
        @else
            <svg width="22" height="22" fill="none" stroke="#777" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="8" r="4"/>
                <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
            </svg>
        @endif
    </div>

    <div style="
        font-size: 15px;
        color: var(--red);
        font-weight: 800;
    ">
        {{ $activity->seeker->user->name ?? 'Unknown Organizer' }}
    </div>
</div>
            <form action="{{ route('activity.register', $activity->id) }}" method="POST" style="margin-top:28px;">
                @csrf

                @if (session('error'))
                    <div
                        style="background: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 12px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-size: 14px;">
                        {{ session('error') }}
                    </div>
                @endif

                <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 0 0 22px;">

               <div style="margin-bottom: 22px;">
                <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 18px; color: #000;">Details:</h3>

                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px 34px;">
                    <div>
                        <p style="font-size: 13px; font-weight: 700; color: #000; margin-bottom: 4px;">Location:</p>
                        <p style="font-size: 14px; font-weight: 400; color: #000;">{{ $activity->location }}</p>
                    </div>

                    <div>
                        <p style="font-size: 13px; font-weight: 700; color: #000; margin-bottom: 4px;">Open Registration:</p>
                        <p style="font-size: 14px; font-weight: 400; color: #000;">
                            {{ \Carbon\Carbon::parse($activity->open_reg_date)->format('d/m/Y') }}
                        </p>
                    </div>

                    <div>
                        <p style="font-size: 13px; font-weight: 700; color: #000; margin-bottom: 4px;">Status:</p>
                        <p style="font-size: 14px; font-weight: 400; color: #000;">Not Registered</p>
                    </div>

                    <div>
                        <p style="font-size: 13px; font-weight: 700; color: #000; margin-bottom: 4px;">Date:</p>
                        <p style="font-size: 14px; font-weight: 400; color: #000;">
                            {{ \Carbon\Carbon::parse($activity->activity_date)->format('d/m/Y') }}
                        </p>
                    </div>

                    <div>
                        <p style="font-size: 13px; font-weight: 700; color: #000; margin-bottom: 4px;">Close Registration:</p>
                        <p style="font-size: 14px; font-weight: 400; color: #000;">
                            {{ \Carbon\Carbon::parse($activity->close_reg_date)->format('d/m/Y') }}
                        </p>
                    </div>

                    <div>
                        <p style="font-size: 13px; font-weight: 700; color: #000; margin-bottom: 4px;">Quota:</p>
                        <p style="font-size: 14px; font-weight: 400; color: #000;">{{ $activity->slot }} volunteer(s)</p>
                    </div>
                </div>
            </div>

            <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 0 0 22px;">

              <div style="margin-bottom: 22px;">
                  <p style="font-size: 13px; font-weight: 700; color: #000; margin-bottom: 6px;">
                      Description:
                  </p>

                  <p style="font-size: 14px; font-weight: 400; color: #000; line-height: 1.7; margin: 0;">
                      {{ $activity->description }}
                  </p>
              </div>

              <div style="margin-bottom: 28px;">
                  <p style="font-size: 13px; font-weight: 700; color: #000; margin-bottom: 6px;">
                      Requirements:
                  </p>

                  <p style="font-size: 14px; font-weight: 400; color: #000; line-height: 1.7; margin: 0;">
                      {{ $activity->requirements }}
                  </p>
              </div>

              <div style="
                    background: #fff7ed;
                    border: 1px solid #fdba74;
                    color: #9a3412;
                    padding: 12px 16px;
                    border-radius: 10px;
                    font-size: 13px;
                    line-height: 1.6;
                    margin-bottom: 18px;
                ">
                    Your name, phone number, and email are automatically taken from your profile. To update this information, please go to Edit Profile before registering.
                </div>

                <div class="form-group">
                    <label>Name</label>
                    <input class="form-input" type="text" placeholder="Type Name Here" value="{{ $user->name }}" disabled>
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <input class="form-input" type="tel" placeholder="Type Phone Number Here" value="{{ $user->phone }}" disabled>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input class="form-input" type="email" placeholder="Type Email Here" value="{{ $user->email }}" disabled>
                </div>

                <div class="checkbox-row">
                    <input type="checkbox" id="tos-reg" required>
                    <label for="tos-reg">
                      I've read the
                      <span style="color: var(--red); font-weight: 600;">Details</span>
                      and
                      <span style="color: var(--red); font-weight: 600;">Available</span>
                      for this activity
                  </label>
                </div>

                <div style="text-align:center; margin-top:16px;">
                    <button type="submit" class="btn btn-primary btn-lg" style="padding:14px 60px;">Register</button>
                </div>
            </form>
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

    <div class="modal-overlay" id="modal-register-success">
        <div class="modal" style="text-align:center; max-width:420px; padding:40px 32px;">
            <button class="modal-close" onclick="closeModal('modal-register-success')">✕</button>

            <h2 class="popup-title">Success!</h2>

            <div
                style="width:80px; height:80px; border-radius:50%; border:5px solid #22c55e; display:flex; align-items:center; justify-content:center; margin:0 auto 20px; margin-top: 15px; color:#22c55e; font-size:36px;">
                ✓
            </div>

            <p class="popup-subtitle">You are successfully registered!</p>

            <div style="margin-top: 24px;">
                <a href="/my-activities" class="btn btn-primary btn-lg"
                    style="width: 100%; text-align: center; text-decoration: none;">
                    Go to My Activities →
                </a>
            </div>
        </div>
    </div>

    {{-- <div class="modal-overlay" id="modal-activity-details">
        <div class="modal" style="max-width:560px; max-height:80vh; overflow-y:auto;">
            <button class="modal-close" onclick="closeModal('modal-activity-details')">✕</button>

            <div class="popup-title">Activity Details</div>
            <div class="popup-subtitle">{{ $activity->activity_name }}</div>

            <div class="popup-meta"
                style="display: flex; align-items: center; justify-content: center; gap: 20px; margin-bottom: 16px;">
                <span style="display: flex; align-items: center; gap: 6px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    {{ $activity->location }}
                </span>

                <span style="display: flex; align-items: center; gap: 6px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    {{ \Carbon\Carbon::parse($activity->activity_date)->format('d/m/Y') }}
                </span>
            </div> --}}

            <div class="popup-reminder">
                {{ $activity->requirements }}
            </div>

            <p style="font-size:13px; color:#4b5563; line-height:1.7; margin-bottom:12px;">
                {{ $activity->description }}
            </p>
        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.add('open');
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('open');
        }

        document.querySelectorAll('.modal-overlay').forEach(el => {
            el.addEventListener('click', e => {
                if (e.target === el) el.classList.remove('open');
            });
        });

        @if (session('success'))
            document.addEventListener('DOMContentLoaded', function() {
                openModal('modal-register-success');
            });
        @endif
    </script>

    <script src="{{ asset('js/dropdown_login.js') }}"></script>
</body>

</html>