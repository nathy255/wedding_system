@extends('layouts.app')
@section('title', 'Edit Contributor')

@section('extra_css')
<style>
.page-header { margin-bottom: 32px; display: flex; align-items: center; gap: 16px; }
.btn-back { width: 36px; height: 36px; border-radius: 10px; background: rgba(255,255,255,0.03); border: 1px solid var(--border); color: var(--text-muted); display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s; }
.btn-back:hover { background: var(--bg-card-hover); color: #fff; }
.ph-title { font-size: 24px; font-weight: 700; color: #fff; letter-spacing: -0.5px; }

.form-wrapper { max-width: 800px; }
.form-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 16px; padding: 32px; margin-bottom: 24px; box-shadow: 0 12px 32px rgba(0,0,0,0.2); }
.fc-title { font-size: 16px; font-weight: 600; color: #fff; margin-bottom: 4px; }
.fc-sub { font-size: 12px; color: var(--text-muted); margin-bottom: 24px; }

.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.form-group { display: flex; flex-direction: column; gap: 8px; }
.fg-full { grid-column: span 2; }

label { font-size: 12px; font-weight: 500; color: var(--text-muted); }
.form-input {
  background: rgba(0,0,0,0.15); border: 1px solid var(--border); border-radius: 10px; padding: 12px 16px; color: #fff; font-size: 13px; font-family: 'Inter', sans-serif; transition: all 0.2s; outline: none; width: 100%;
}
.form-input:focus { border-color: var(--brand-purple); box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1); }

.form-actions { display: flex; justify-content: flex-end; gap: 12px; padding-top: 16px; border-top: 1px solid var(--border); }
.btn-cancel { padding: 12px 24px; border-radius: 8px; background: transparent; border: 1px solid var(--border); color: var(--text-muted); font-size: 13px; font-weight: 600; text-decoration: none; transition: all 0.2s; cursor: pointer; }
.btn-cancel:hover { background: rgba(255,255,255,0.05); color: #fff; }
.btn-submit { padding: 12px 32px; border-radius: 8px; background: linear-gradient(90deg, #A855F7, #D946EF); color: #fff; border: none; font-size: 13px; font-weight: 600; cursor: pointer; box-shadow: 0 4px 14px rgba(139, 92, 246, 0.25); transition: transform 0.2s; }
.btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(139, 92, 246, 0.35); }
.error-msg { font-size: 11px; color: #EF4444; margin-top: 4px; }

/* ─── Mobile Responsive ─── */
@media (max-width: 768px) {
  .page-header { flex-direction: column; align-items: flex-start; gap: 12px; margin-bottom: 24px; }
  .ph-title { font-size: 20px; }
  .form-grid { grid-template-columns: 1fr; gap: 16px; }
  .fg-full { grid-column: span 1; }
  .form-card { padding: 20px; }
}
</style>
@endsection

@section('content')

<div class="page-header">
  <a href="{{ route('contributors.index') }}" class="btn-back"><i class="fa-solid fa-arrow-left"></i></a>
  <h1 class="ph-title">Edit Contributor</h1>
</div>

<div class="form-wrapper">
  <form method="POST" action="{{ route('contributors.update', $contributor) }}">
    @csrf
    @method('PUT')
    
    <div class="form-card">
      <div class="fc-title">Personal Details</div>
      <div class="fc-sub">Update the contact information for this individual.</div>
      
      <div class="form-grid">
        <div class="form-group fg-full">
          <label>Full Name</label>
          <input type="text" name="full_name" class="form-input" value="{{ old('full_name', $contributor->full_name) }}" required>
          @error('full_name')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
          <label>Phone Number</label>
          <input type="text" name="phone" class="form-input" value="{{ old('phone', $contributor->phone) }}" required>
          @error('phone')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
          <label>Email Address (Optional)</label>
          <input type="email" name="email" class="form-input" value="{{ old('email', $contributor->email) }}">
          @error('email')<span class="error-msg">{{ $message }}</span>@enderror
        </div>
      </div>
    </div>

    <div class="form-actions">
      <a href="{{ route('contributors.index') }}" class="btn-cancel">Cancel</a>
      <button type="submit" class="btn-submit">Save Changes</button>
    </div>
  </form>
</div>

@endsection
