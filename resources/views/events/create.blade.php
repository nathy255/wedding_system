@extends('layouts.app')
@section('title', 'Create Event')

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
.form-input, .form-select, .form-textarea {
  background: rgba(0,0,0,0.15); border: 1px solid var(--border); border-radius: 10px; padding: 12px 16px; color: #fff; font-size: 13px; font-family: 'Inter', sans-serif; transition: all 0.2s; outline: none; width: 100%;
}
.form-input:focus, .form-select:focus, .form-textarea:focus { border-color: var(--brand-purple); box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1); }
.form-input::placeholder, .form-textarea::placeholder { color: var(--text-faint); }
.form-textarea { resize: vertical; min-height: 100px; }

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
  <a href="{{ route('events.index') }}" class="btn-back"><i class="fa-solid fa-arrow-left"></i></a>
  <h1 class="ph-title">Create New Event Workspace</h1>
</div>

<div class="form-wrapper">
  <form method="POST" action="{{ route('events.store') }}">
    @csrf
    
    <div class="form-card">
      <div class="fc-title">Event Details</div>
      <div class="fc-sub">Provide the foundational information for this event workspace.</div>
      
      <div class="form-grid">
        <div class="form-group fg-full">
          <label>Event Name</label>
          <input type="text" name="couple_name" class="form-input" placeholder="e.g. Global Tech Summit 2025" value="{{ old('couple_name') }}" required>
          <div style="font-size:10px; color:var(--text-faint); margin-top:4px;">* Field temporarily named 'couple_name' for backend compatibility.</div>
          @error('couple_name')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
          <label>Event Type</label>
          <select name="event_type" class="form-select">
            <option value="corporate">Corporate Conference</option>
            <option value="wedding">Wedding / Reception</option>
            <option value="party">Private Party</option>
            <option value="exhibition">Exhibition / Trade Show</option>
            <option value="other">Other</option>
          </select>
        </div>

        <div class="form-group">
          <label>Date</label>
          <input type="date" name="wedding_date" class="form-input" value="{{ old('wedding_date') }}" required>
          @error('wedding_date')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <div class="form-group fg-full">
          <label>Venue (Optional)</label>
          <input type="text" name="venue" class="form-input" placeholder="e.g. Dubai World Trade Centre" value="{{ old('venue') }}">
        </div>

        <div class="form-group fg-full">
          <label>Target Budget (Optional)</label>
          <div style="position:relative;">
            <i class="fa-solid fa-dollar-sign" style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:var(--text-faint);"></i>
            <input type="number" name="target_budget" class="form-input" style="padding-left:36px;" placeholder="0.00" value="{{ old('target_budget') }}">
          </div>
        </div>

        <div class="form-group fg-full">
          <label>Description / Internal Notes</label>
          <textarea name="description" class="form-textarea" placeholder="Add any initial briefing notes or descriptions for your team here...">{{ old('description') }}</textarea>
        </div>
      </div>
    </div>

    <div class="form-actions">
      <a href="{{ route('events.index') }}" class="btn-cancel">Cancel</a>
      <button type="submit" class="btn-submit">Create Workspace</button>
    </div>
  </form>
</div>

@endsection
