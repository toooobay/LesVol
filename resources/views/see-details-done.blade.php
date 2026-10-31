<!DOCTYPE html>
<html lang="id">
<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>LesVol - Activity Details</title>
<link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
<body>


@php
  $currentVolunteer = $volunteer ?? null;


  if (!$currentVolunteer && session('user')) {
    $currentVolunteer = \App\Models\Volunteer::where('activity_id', $activity->id)
      ->where('user_id', session('user')->id)
      ->first();
  }


  $isBanned = $currentVolunteer && $currentVolunteer->is_banned;
  $hasProof = $currentVolunteer && $currentVolunteer->file_att_path;
@endphp


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


<div style="flex:1; padding: 24px 32px; max-width:900px; margin:0 auto; width:100%;">
  <a class="back-btn" href="{{ $backUrl ?? url()->previous() }}" style="margin-bottom:20px; display:inline-flex;">
    <div class="back-icon">◀</div> Back
  </a>


  <div class="activity-detail-card" style="margin-top:16px;">
    <div style="
      height:220px;
      background-color:#d9d9d9;
      @if(!empty($activity->image_path))
        background-image: url('{{ asset('storage/' . $activity->image_path) }}');
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat;
      @endif
    "></div>


    <div class="activity-detail-body">
      <div class="detail-header">
        <div>
          <div class="detail-title">{{ $activity->activity_name }}</div>


          <div class="detail-author">
            <div style="margin-top: 10px; display: flex; align-items: center; gap: 10px;">
              <div class="author-avatar">
                @if($activity->seeker && $activity->seeker->user && $activity->seeker->user->profile_picture_path)
                  <img src="{{ asset('storage/' . $activity->seeker->user->profile_picture_path) }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                @else
                  <svg width="18" height="18" fill="none" stroke="#888" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                  </svg>
                @endif
              </div>


              <div>
                <div style="font-weight:700; font-size:14px;">
                  {{ $activity->seeker->user->name ?? 'Nama Pembuat' }}
                </div>
              </div>
            </div>
          </div>
        </div>


        @if($isBanned)
          <span class="accepted-badge" style="background:#b91c1c;">Banned</span>
        @else
          <span class="accepted-badge">Done</span>
        @endif
      </div>


      <hr class="detail-divider">


      <div style="font-weight:700; margin-bottom:12px;">Details:</div>


      <div class="detail-info-grid" style="margin-bottom:16px;">
        <div class="detail-info-item">
          <label>Location:</label>
          <span>{{ $activity->location }}</span>
        </div>


        <div class="detail-info-item">
          <label>Open Registration:</label>
          <span>{{ \Carbon\Carbon::parse($activity->open_reg_date)->format('d/m/Y') }}</span>
        </div>


        <div class="detail-info-item">
          <label>Status:</label>
          <span>
            @if($isBanned)
              Banned
            @elseif($isJoined)
              Joined
            @else
              Not Joined
            @endif
          </span>
        </div>


        <div class="detail-info-item">
          <label>Date:</label>
          <span>{{ \Carbon\Carbon::parse($activity->activity_date)->format('d/m/Y') }}</span>
        </div>


        <div class="detail-info-item">
          <label>Close Registration:</label>
          <span>{{ \Carbon\Carbon::parse($activity->close_reg_date)->format('d/m/Y') }}</span>
        </div>


        <div class="detail-info-item">
          <label>Quota:</label>
          <span>{{ $activity->slot }} volunteer(s)</span>
        </div>
      </div>


      <hr class="detail-divider">


      <div style="font-weight:700; margin-bottom:10px;">Description:</div>
      <p style="font-size:14px; color:#4b5563; line-height:1.7; margin-bottom:28px;">
        {{ $activity->description }}
      </p>


      @if(!empty($activity->requirements))
        <div style="font-weight:700; margin-bottom:10px;">Requirements:</div>
        <p style="font-size:14px; color:#4b5563; line-height:1.7; margin-bottom:28px;">
          {{ $activity->requirements }}
        </p>
      @endif


      {{-- UNIQUE IDENTIFIER: DONE DETAILS ATTENDANCE ACTION AREA --}}
      @if($isBanned)
        <div style="text-align:center; margin-top: 24px;">
          <div style="
            background:#fee2e2;
            color:#b91c1c;
            border:1px solid #fca5a5;
            padding:12px 16px;
            border-radius:10px;
            font-size:14px;
            font-weight:600;
            margin-bottom:12px;
            text-align:center;
          ">
            You cannot upload because you're banned.
          </div>


          <button
            type="button"
            disabled
            class="btn-danger"
            style="
              background:#d1d5db;
              color:#6b7280;
              cursor:not-allowed;
              opacity:0.8;
              border:none;
              padding: 12px 60px;
              font-size: 16px;
            "
          >
            Upload Attendance Disabled
          </button>
        </div>


      @elseif($hasProof)
        <div style="margin-top: 20px; background: #f9fafb; padding: 20px; border-radius: 12px; border: 1px dashed #d1d5db; margin-bottom: 20px;">
          <div style="font-weight:700; margin-bottom:12px; display: flex; align-items: center; gap: 8px;">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Attendance Proof
          </div>


          <div style="margin-bottom: 12px;">
            <img src="{{ asset('storage/' . $currentVolunteer->file_att_path) }}" style="width: 100%; max-height: 300px; object-fit: cover; border-radius: 8px;">
          </div>


          <div style="color: #059669; font-size: 14px; font-weight: 600; display: flex; align-items: center; gap: 4px;">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M5 13l4 4L19 7"/>
            </svg>
            Proof uploaded successfully
          </div>
        </div>


      @elseif($isJoined)
        <div style="text-align:center; margin-top: 24px;">
          <button class="btn-danger" type="button" onclick="openModal('modal-activity-details'); return false;">
            Upload Attendance
          </button>
        </div>


      @else
        <div style="text-align:center; margin-top: 24px;">
          <div class="accepted-badge" style="display:inline-block; padding:14px 36px; border-radius:999px; font-size:16px;">
            ✓ Done
          </div>
        </div>
      @endif
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


@if(!$isBanned && $isJoined && !$hasProof)
<div class="modal-overlay" id="modal-activity-details">
  <div class="modal" style="max-width:560px; border-radius: 24px;">
    <button class="modal-close" onclick="closeModal('modal-activity-details')" style="font-weight: bold; font-size: 24px; top: 20px; right: 25px;">✕</button>
   
    <div class="popup-title" style="font-size: 32px; margin-top: 10px;">Upload Attendance</div>
    <div class="popup-subtitle" style="font-size: 20px; margin-top: 8px;">{{ $activity->activity_name }}</div>
   
    <div class="popup-meta" style="display: flex; justify-content: center; gap: 15px; margin-top: 10px;">
      <span style="display: flex; align-items: center; gap: 5px;">📍 {{ $activity->location }}</span>
      <span style="display: flex; align-items: center; gap: 5px;">🗓 {{ \Carbon\Carbon::parse($activity->activity_date)->format('d/m/Y') }}</span>
    </div>


    <hr class="detail-divider" style="margin: 20px 0;">


    <div style="text-align: center; margin-bottom: 20px;">
      <p style="font-size: 14px; color: #6b7280; margin-bottom: 20px;">Upload a picture of yourself at the place of volunteer</p>
     
      <form action="{{ route('activity.upload-attendance', $activity->id) }}" method="POST" enctype="multipart/form-data" id="attendanceForm">
        @csrf


        <label for="attendance_photo" class="upload-img-box" style="background: #f3f4f6; border: none; height: 200px; flex-direction: column; gap: 15px; cursor: pointer;">
          <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
            <polyline points="17 8 12 3 7 8"></polyline>
            <line x1="12" y1="3" x2="12" y2="15"></line>
          </svg>


          <span style="color: #6b7280; font-size: 14px;" id="file-label">Select a file to upload (jpg, jpeg, png, max 2MB)</span>
          <input type="file" name="attendance_photo" id="attendance_photo" accept="image/*" style="display: none;" onchange="updateFileName(this)" required>
        </label>
      </form>
    </div>


    <div style="text-align: center; margin-top: 30px;">
      <button type="button" class="btn-danger" style="padding: 12px 60px; font-size: 16px;" onclick="showAttendanceConfirmModal()">
        Upload
      </button>
    </div>
  </div>
</div>
{{-- UNIQUE IDENTIFIER: ATTENDANCE CONFIRMATION MODAL --}}
<div class="modal-overlay" id="modal-attendance-confirm">
  <div class="modal" style="max-width:520px; border-radius: 24px; text-align:center;">
    <button type="button" class="modal-close" onclick="closeModal('modal-attendance-confirm')" style="font-weight: bold; font-size: 24px; top: 20px; right: 25px;">✕</button>

    <div class="popup-title" style="font-size: 28px; margin-top: 10px;">Confirm Attendance Photo</div>

    <p style="font-size: 14px; color: #6b7280; margin: 12px 0 20px;">
      Are you sure this is correct? You cannot edit once you submit.
    </p>

    <div style="background:#f3f4f6; border-radius:16px; padding:12px; margin-bottom:22px;">
      <img id="attendance-confirm-preview"
           src=""
           alt="Attendance preview"
           style="width:100%; max-height:280px; object-fit:contain; border-radius:12px; display:none;">
    </div>

    <div style="display:flex; justify-content:center; gap:12px; flex-wrap:wrap;">
      <button type="button"
              class="btn-gray"
              onclick="closeModal('modal-attendance-confirm')"
              style="cursor:pointer; color:#6b7280;">
        Cancel
      </button>

      <button type="button"
              class="btn-danger"
              onclick="submitAttendanceForm()">
        Yes, Upload
      </button>
    </div>
  </div>
</div>
@endif

<script>
function openModal(id) {
  const modal = document.getElementById(id);
  if (modal) {
    modal.classList.add('open');
  }
}

function closeModal(id) {
  const modal = document.getElementById(id);
  if (modal) {
    modal.classList.remove('open');
  }
}

document.querySelectorAll('.modal-overlay').forEach(el => {
  el.addEventListener('click', e => {
    if (e.target === el) {
      el.classList.remove('open');
    }
  });
});

function updateFileName(input) {
  const label = document.getElementById('file-label');

  if (input.files && input.files[0]) {
    label.textContent = input.files[0].name;
    label.style.color = 'var(--red)';
    label.style.fontWeight = '700';
  }
}

function showAttendanceConfirmModal() {
  const input = document.getElementById('attendance_photo');
  const preview = document.getElementById('attendance-confirm-preview');

  if (!input || !input.files || !input.files[0]) {
    alert('Please select an attendance photo first.');
    return;
  }

  const file = input.files[0];

  if (!file.type.startsWith('image/')) {
    alert('Please upload a valid image file.');
    return;
  }

  const reader = new FileReader();

  reader.onload = function (event) {
    preview.src = event.target.result;
    preview.style.display = 'block';

    closeModal('modal-activity-details');
    openModal('modal-attendance-confirm');
  };

  reader.readAsDataURL(file);
}

function submitAttendanceForm() {
  const form = document.getElementById('attendanceForm');

  if (form) {
    form.submit();
  }
}
</script>


<script src="{{asset('js/dropdown_login.js')}}"></script>
</body>
</html>

