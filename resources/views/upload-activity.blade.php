<!DOCTYPE html>
<html lang="id">
<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>LesVol - Upload Activity</title>
<link rel="stylesheet" href="{{ asset('css/main.css') }}">


<style>
  .form-input.input-error {
    border: 2px solid #dc2626 !important;
    background: #fff5f5;
  }


  .field-error {
    display: none;
    color: #dc2626;
    font-size: 13px;
    margin-top: 6px;
    font-weight: 500;
  }
</style>
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


<div style="flex:1; padding: 5px 32px; margin-top: 20px;">
  <div class="activities-toolbar-simple">
    <div class="activity-page-tabs">
      <a href="/my-activities" class="activity-page-tab">Joined</a>


      @if ($isSeeker)
        <a href="/proposed-activities" class="activity-page-tab">Proposed</a>
      @endif


      <a href="/done-activity?type=joined" class="activity-page-tab">Done</a>
      <a href="/banned-activities" class="activity-page-tab">Banned</a>


      @if ($isSeeker)
        <a href="/upload-activity" class="activity-page-tab activity-page-tab-upload active">Upload</a>
      @endif
    </div>
  </div>
    
  <div class="activities-grid" id="proposed-grid"></div>
</div>


<form id="upload-activity-form" action="{{ route('activity.upload') }}" method="POST" enctype="multipart/form-data">
  @csrf


  @if ($errors->any())
    <div style="background: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 15px; border-radius: 8px; margin: 20px 32px;">
      <ul style="margin: 0; padding-left: 20px;">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif


  <div style="padding:0px 32px; margin-bottom: 30px">
    <div class="upload-form">
      <div class="upload-layout">
        <div>
          <input
            type="file"
            id="img-input"
            name="image"
            accept=".jpg,.jpeg,.png,image/jpeg,image/png"
            style="display:none;"
          >


          <div class="upload-img-box" onclick="document.getElementById('img-input').click()">
            <span>Upload Images Here</span>
          </div>


          <p id="image-error" class="field-error">
            Image must be JPG, JPEG, or PNG format.
          </p>
        </div>


        <div>
          <div class="form-group">
            <label>Activity Name</label>
            <input class="form-input" type="text" name="activity_name" placeholder="Type Activity Name Here" required>
          </div>


          <div class="form-group">
            <label>Location</label>
            <input class="form-input" type="text" name="location" placeholder="Select Location" required>
          </div>


          <div style="display: flex; gap: 20px;">
            <div class="form-group" style="flex: 1;">
              <label>Activity Date</label>
              <input class="form-input" type="date" id="activity-date" name="activity_date" required>
              <p id="activity-date-error" class="field-error">Activity date must be after today.</p>
            </div>


            <div class="form-group" style="flex: 1;">
              <label>Activity Time</label>
              <input class="form-input" type="time" name="activity_time" required>
            </div>
          </div>


          <div class="form-group">
            <label>Slot</label>
            <input class="form-input" type="number" name="slot" min="1" placeholder="Number of volunteers needed" required>
          </div>


          <div style="display: flex; gap: 20px;">
            <div class="form-group" style="flex: 1;">
              <label>Open Registration Date</label>
              <input class="form-input" type="date" id="open-reg-date" name="open_reg_date" required>
            </div>


            <div class="form-group" style="flex: 1;">
              <label>Close Registration Date</label>
              <input class="form-input" type="date" id="close-reg-date" name="close_reg_date" required>
              <p id="close-reg-date-error" class="field-error">
                Close registration date must be after open registration date and before activity date.
              </p>
            </div>
          </div>


          <div class="form-group">
            <label>Requirements</label>
            <textarea class="form-input @error('requirements') input-error @enderror"
                        name="requirements"
                        style="min-height:80px;"
                        placeholder="What are the requirements?"
                        required>{{ old('requirements') }}</textarea>
              @error('requirements')
                <p class="field-error" style="display:block;">{{ $message }}</p>
              @enderror
          </div>


          <div class="form-group">
            <label>Description</label>
            <textarea class="form-input @error('description') input-error @enderror"
                      name="description"
                      style="min-height:120px;"
                      placeholder="Describe your activity"
                      required>{{ old('description') }}</textarea>
            @error('description')
              <p class="field-error" style="display:block;">{{ $message }}</p>
            @enderror
          </div>


          <div class="upload-actions">
            <button type="submit" class="btn btn-dark" style="border-radius:8px; padding:12px 24px;">Submit Activity</button>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="modal-overlay" id="modal-upload-proposal">
    <div class="modal" style="text-align:center; max-width:440px;">
      <button type="button" class="modal-close" onclick="closeModal('modal-upload-proposal')">✕</button>
      <h3 style="font-family:'DM Serif Display',serif; font-size:20px; margin-bottom:20px;">Upload Proposal</h3>
      <div style="font-size:64px; color:#ccc; margin-bottom:12px; line-height:1;">⬆</div>
      <p style="font-size:13px; color:var(--gray); margin-bottom:24px;">Select a file to upload (PDF, max 10MB)</p>
      <input type="file" id="proposal-input" name="proposal" accept=".pdf" style="display:none;" onchange="handleProposal(event)">
      <button type="button" class="btn btn-dark" style="border-radius:12px; padding:12px 40px;" onclick="document.getElementById('proposal-input').click()">Upload</button>
    </div>
  </div>
</form>


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


<script src="{{asset('js/upload_activity.js')}}"></script>
<script src="{{asset('js/dropdown_login.js')}}"></script>


<script>
  const uploadForm = document.getElementById('upload-activity-form');


  const imageInput = document.getElementById('img-input');
  const imageError = document.getElementById('image-error');
  const uploadImgBox = document.querySelector('.upload-img-box');


  const activityDate = document.getElementById('activity-date');
  const openRegDate = document.getElementById('open-reg-date');
  const closeRegDate = document.getElementById('close-reg-date');


  const activityDateError = document.getElementById('activity-date-error');
  const closeRegDateError = document.getElementById('close-reg-date-error');


  function getTodayString() {
    const today = new Date();
    return today.toISOString().split('T')[0];
  }


  function getTomorrowString() {
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    return tomorrow.toISOString().split('T')[0];
  }


  function setError(input, errorElement, message) {
    input.classList.add('input-error');
    errorElement.textContent = message;
    errorElement.style.display = 'block';
  }


  function clearError(input, errorElement) {
    input.classList.remove('input-error');
    errorElement.style.display = 'none';
  }


  function validateImage(event) {
    const file = imageInput.files[0];


    imageError.style.display = 'none';
    uploadImgBox.classList.remove('input-error');


    if (!file) {
      return true;
    }


    const allowedTypes = ['image/jpeg', 'image/png'];
    const maxSize = 2 * 1024 * 1024;


    if (!allowedTypes.includes(file.type)) {
      imageError.textContent = 'Image must be JPG, JPEG, or PNG format.';
      imageError.style.display = 'block';
      uploadImgBox.classList.add('input-error');
      imageInput.value = '';
      return false;
    }


    if (file.size > maxSize) {
      imageError.textContent = 'Image size must not be larger than 2MB.';
      imageError.style.display = 'block';
      uploadImgBox.classList.add('input-error');
      imageInput.value = '';
      return false;
    }


    if (typeof previewImage === 'function' && event) {
      previewImage(event);
    }


    return true;
  }


  function validateDates() {
    let valid = true;
    const today = getTodayString();


    clearError(activityDate, activityDateError);
    clearError(closeRegDate, closeRegDateError);


    activityDate.min = getTomorrowString();


    if (activityDate.value) {
      closeRegDate.max = activityDate.value;
    } else {
      closeRegDate.removeAttribute('max');
    }


    if (openRegDate.value) {
      closeRegDate.min = openRegDate.value;
    } else {
      closeRegDate.removeAttribute('min');
    }


    if (activityDate.value && activityDate.value <= today) {
      setError(activityDate, activityDateError, 'Activity date must be after today.');
      valid = false;
    }


    if (openRegDate.value && activityDate.value && openRegDate.value >= activityDate.value) {
      setError(activityDate, activityDateError, 'Activity date must be after open registration date.');
      valid = false;
    }


    if (closeRegDate.value && openRegDate.value && closeRegDate.value <= openRegDate.value) {
      setError(closeRegDate, closeRegDateError, 'Close registration date must be after open registration date.');
      valid = false;
    }


    if (closeRegDate.value && activityDate.value && closeRegDate.value >= activityDate.value) {
      setError(closeRegDate, closeRegDateError, 'Close registration date must be before activity date.');
      valid = false;
    }


    return valid;
  }


  imageInput.addEventListener('change', validateImage);
  activityDate.addEventListener('change', validateDates);
  openRegDate.addEventListener('change', validateDates);
  closeRegDate.addEventListener('change', validateDates);


  document.addEventListener('DOMContentLoaded', function () {
    activityDate.min = getTomorrowString();
    validateDates();
  });


  uploadForm.addEventListener('submit', function (event) {
    const imageValid = validateImage();
    const datesValid = validateDates();


    if (!imageValid || !datesValid) {
      event.preventDefault();
    }
  });
</script>
</body>
</html>

