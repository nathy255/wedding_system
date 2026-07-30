@extends('layouts.app')
@section('title', 'Workspace Settings')

@section('extra_css')
<style>
.page-header { margin-bottom: 32px; }
.ph-title { font-size: 28px; font-weight: 800; color: #fff; letter-spacing: -0.5px; margin-bottom: 6px; }
.ph-sub { color: var(--text-muted); font-size: 14px; }

.settings-layout { display: grid; grid-template-columns: 240px 1fr; gap: 40px; }

/* Settings Nav */
.set-nav { display: flex; flex-direction: column; gap: 8px; }
.set-item { padding: 12px 16px; border-radius: 12px; color: var(--text-muted); font-size: 14px; font-weight: 500; text-decoration: none; display: flex; align-items: center; gap: 12px; transition: all 0.2s; cursor: pointer; }
.set-item:hover, .set-item.active { background: rgba(255,255,255,0.03); color: #fff; }
.set-item.active { background: rgba(139, 92, 246, 0.1); color: var(--brand-purple); }

/* Settings Content */
.set-content { max-width: 800px; }
.set-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 20px; padding: 32px; margin-bottom: 24px; box-shadow: 0 12px 32px rgba(0,0,0,0.2); }
.sc-title { font-size: 18px; font-weight: 700; color: #fff; margin-bottom: 8px; }
.sc-sub { font-size: 13px; color: var(--text-muted); margin-bottom: 24px; padding-bottom: 24px; border-bottom: 1px solid var(--border); }

.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.form-group { display: flex; flex-direction: column; gap: 8px; }
.fg-full { grid-column: span 2; }
label { font-size: 12px; font-weight: 500; color: var(--text-muted); }
.form-input, .form-select {
  background: rgba(0,0,0,0.15); border: 1px solid var(--border); border-radius: 10px; padding: 12px 16px; color: #fff; font-size: 13px; font-family: 'Inter', sans-serif; transition: all 0.2s; outline: none; width: 100%;
}
.form-input:focus, .form-select:focus { border-color: var(--brand-purple); box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1); }

.profile-upload { display: flex; align-items: center; gap: 24px; margin-bottom: 32px; }
.pu-avatar { width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 2px solid var(--border); }
.pu-actions { display: flex; gap: 12px; }
.btn-outline { background: transparent; border: 1px solid var(--border); color: #fff; padding: 8px 16px; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
.btn-outline:hover { background: rgba(255,255,255,0.05); }
.btn-danger { color: #EF4444; border-color: rgba(239, 68, 68, 0.3); }
.btn-danger:hover { background: rgba(239, 68, 68, 0.1); }

.btn-primary { background: linear-gradient(90deg, #A855F7, #D946EF); color: #fff; padding: 12px 24px; border-radius: 8px; font-size: 13px; font-weight: 600; border: none; cursor: pointer; box-shadow: 0 4px 14px rgba(139, 92, 246, 0.25); transition: transform 0.2s; display: inline-flex; align-items: center; justify-content: center; gap: 8px; width: fit-content; }
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(139, 92, 246, 0.35); }

.toggle-row { display: flex; justify-content: space-between; align-items: center; padding: 16px 0; border-bottom: 1px solid var(--border); }
.toggle-row:last-child { border-bottom: none; }
.tr-info { display: flex; flex-direction: column; gap: 4px; }
.tr-title { font-size: 14px; font-weight: 600; color: #fff; }
.tr-sub { font-size: 12px; color: var(--text-muted); }

/* Switch Toggle */
.switch { position: relative; display: inline-block; width: 44px; height: 24px; }
.switch input { opacity: 0; width: 0; height: 0; }
.slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(255,255,255,0.1); transition: .2s; border-radius: 24px; }
.slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background-color: white; transition: .2s; border-radius: 50%; }
input:checked + .slider { background-color: #10B981; }
input:checked + .slider:before { transform: translateX(20px); }

@media(max-width: 768px) {
  .settings-layout { grid-template-columns: 1fr; }
  .set-nav { flex-direction: row; overflow-x: auto; padding-bottom: 12px; }
  .set-item { white-space: nowrap; }
  .form-grid { grid-template-columns: 1fr; }
  .fg-full { grid-column: span 1; }
  .profile-upload { flex-direction: column; align-items: flex-start; gap: 16px; }
  .page-header { margin-bottom: 24px; }
  .ph-title { font-size: 24px; }
  .set-card { padding: 20px; }
}
</style>
@endsection

@section('content')

<div class="page-header">
  <h1 class="ph-title">Workspace Settings</h1>
  <p class="ph-sub">Manage your account, preferences, and billing information.</p>
</div>

<div class="settings-layout">
  
  <!-- Sidebar -->
  <div class="set-nav">
    <div class="set-item active" onclick="switchTab(this, 'tab-general')"><i class="fa-solid fa-user"></i> General Profile</div>
    <div class="set-item" onclick="switchTab(this, 'tab-security')"><i class="fa-solid fa-lock"></i> Security</div>
    <div class="set-item" onclick="switchTab(this, 'tab-notifications')"><i class="fa-solid fa-bell"></i> Notifications</div>
    <div class="set-item" onclick="switchTab(this, 'tab-billing')"><i class="fa-solid fa-credit-card"></i> Billing & Plans</div>
    <div class="set-item" onclick="switchTab(this, 'tab-team')"><i class="fa-solid fa-users"></i> Team Access</div>
  </div>

  <!-- Content -->
  <div class="set-content">
    
    @if(session('success'))
      <div style="background: rgba(16, 185, 129, 0.12); color: #10B981; border: 1px solid rgba(16, 185, 129, 0.2); padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 13px; font-weight: 500;">
        {{ session('success') }}
      </div>
    @endif

    <!-- GENERAL TAB -->
    <div id="tab-general" class="settings-tab">
      <form method="POST" action="{{ route('settings.update') }}">
        @csrf
        <div class="set-card">
          <div class="sc-title">Personal Information</div>
          <div class="sc-sub">Update your photo and personal details here.</div>
          
          <div class="profile-upload">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->full_name) }}&background=A855F7&color=fff" class="pu-avatar">
            <div class="pu-actions">
              <button type="button" class="btn-outline">Upload New Photo</button>
              <button type="button" class="btn-outline btn-danger">Remove</button>
            </div>
          </div>

          <div class="form-grid">
            <div class="form-group fg-full">
              <label>Full Name</label>
              <input type="text" name="full_name" class="form-input" value="{{ old('full_name', auth()->user()->full_name) }}" required>
              @error('full_name')<span style="font-size:11px; color:#EF4444;">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
              <label>Email Address</label>
              <input type="email" class="form-input" value="{{ auth()->user()->email }}" disabled style="opacity: 0.6; cursor: not-allowed;">
            </div>
            <div class="form-group">
              <label>Phone Number</label>
              <input type="text" name="phone" class="form-input" placeholder="+255 7XX XXX XXX" value="{{ old('phone', auth()->user()->phone) }}" required>
              @error('phone')<span style="font-size:11px; color:#EF4444;">{{ $message }}</span>@enderror
            </div>
          </div>

          <div style="margin-top: 24px; text-align: right;">
            <button type="submit" class="btn-primary">Save Changes</button>
          </div>
        </div>
      </form>

      <div class="set-card">
        <div class="sc-title">Workspace Preferences</div>
        <div class="sc-sub">Customize how your EVENTA workspace operates.</div>
        
        <div class="toggle-row">
          <div class="tr-info">
            <div class="tr-title">Enable RSVP Tracking</div>
            <div class="tr-sub">Automatically send digital RSVPs to all added contributors.</div>
          </div>
          <label class="switch">
            <input type="checkbox" checked>
            <span class="slider"></span>
          </label>
        </div>

        <div class="toggle-row">
          <div class="tr-info">
            <div class="tr-title">Public Marketplace Visibility</div>
            <div class="tr-sub">Allow vendors to see your event details and send proposals.</div>
          </div>
          <label class="switch">
            <input type="checkbox">
            <span class="slider"></span>
          </label>
        </div>

        <div class="toggle-row">
          <div class="tr-info">
            <div class="tr-title">Escrow Auto-Release</div>
            <div class="tr-sub">Automatically release funds to vendors 48 hours after the event.</div>
          </div>
          <label class="switch">
            <input type="checkbox" checked>
            <span class="slider"></span>
          </label>
        </div>
      </div>
    </div>
    
    <!-- SECURITY TAB -->
    <div id="tab-security" class="settings-tab" style="display:none;">
      <div class="set-card">
        <div class="sc-title">Security & Password</div>
        <div class="sc-sub">Manage your password and security preferences.</div>
        <div class="form-group" style="margin-bottom:16px; max-width:400px;">
          <label>Current Password</label>
          <input type="password" class="form-input">
        </div>
        <div class="form-group" style="margin-bottom:16px; max-width:400px;">
          <label>New Password</label>
          <input type="password" class="form-input">
        </div>
        <button class="btn-primary" style="margin-top:8px;">Update Password</button>
      </div>
    </div>

    <!-- NOTIFICATIONS TAB -->
    <div id="tab-notifications" class="settings-tab" style="display:none;">
      <div class="set-card">
        <div class="sc-title">Notification Preferences</div>
        <div class="sc-sub">Choose how and when you want to be alerted.</div>
        <div class="toggle-row">
          <div class="tr-info">
            <div class="tr-title">Email Notifications</div>
            <div class="tr-sub">Receive daily summaries of your event's progress.</div>
          </div>
          <label class="switch">
            <input type="checkbox" checked>
            <span class="slider"></span>
          </label>
        </div>
        <div class="toggle-row">
          <div class="tr-info">
            <div class="tr-title">SMS Alerts</div>
            <div class="tr-sub">Instant text messages for new contributions.</div>
          </div>
          <label class="switch">
            <input type="checkbox" checked>
            <span class="slider"></span>
          </label>
        </div>
      </div>
    </div>

    <!-- BILLING TAB -->
    <div id="tab-billing" class="settings-tab" style="display:none;">
      <div class="set-card">
        <div class="sc-title">Billing & Plans</div>
        <div class="sc-sub">Manage your EVENTA subscription and payment methods.</div>
        <div style="background: linear-gradient(135deg, rgba(168, 85, 247, 0.1), rgba(217, 70, 239, 0.1)); padding: 24px; border-radius: 12px; border: 1px solid rgba(168, 85, 247, 0.2); margin-bottom: 24px;">
          <div style="font-size: 20px; font-weight: 700; color: #fff; margin-bottom: 8px;">Free Plan</div>
          <div style="font-size: 13px; color: var(--text-muted); margin-bottom: 16px;">Upgrade to Pro to unlock unlimited events, AI scheduling, and priority vendor matching.</div>
          <button class="btn-primary">Upgrade to Pro</button>
        </div>
      </div>
    </div>

    <!-- TEAM ACCESS TAB -->
    <div id="tab-team" class="settings-tab" style="display:none;">
      <div class="set-card">
        <div class="sc-title">Team & Committee Access</div>
        <div class="sc-sub">Invite members to help manage your events.</div>
        <div style="text-align: center; padding: 40px 20px;">
          <div style="font-size: 48px; margin-bottom: 16px;">🤝</div>
          <div style="font-size: 16px; font-weight: 600; color: #fff;">Invite Your Committee</div>
          <div style="font-size: 13px; color: var(--text-muted); margin: 8px 0 24px;">Add your partner, family members, or committee to help manage the budget and guest list.</div>
          <button class="btn-primary" style="margin: 0 auto;">+ Invite Member</button>
        </div>
      </div>
    </div>

  </div>

</div>

@endsection

@section('scripts')
<script>
function switchTab(el, tabId) {
  // Update sidebar active state
  document.querySelectorAll('.set-item').forEach(item => item.classList.remove('active'));
  el.classList.add('active');
  
  // Update tab content visibility
  document.querySelectorAll('.settings-tab').forEach(tab => tab.style.display = 'none');
  document.getElementById(tabId).style.display = 'block';
}
</script>
@endsection
