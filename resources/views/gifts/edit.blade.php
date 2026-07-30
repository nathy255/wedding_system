@extends('layouts.app')
@section('title', 'Edit Gift')

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
.form-textarea { resize: vertical; min-height: 100px; }
.form-input:focus, .form-select:focus, .form-textarea:focus { border-color: var(--brand-magenta); box-shadow: 0 0 0 3px rgba(217, 70, 239, 0.1); }
.form-input::placeholder, .form-textarea::placeholder { color: var(--text-faint); }

.form-actions { display: flex; justify-content: flex-end; gap: 12px; padding-top: 16px; border-top: 1px solid var(--border); }
.btn-cancel { padding: 12px 24px; border-radius: 8px; background: transparent; border: 1px solid var(--border); color: var(--text-muted); font-size: 13px; font-weight: 600; text-decoration: none; transition: all 0.2s; cursor: pointer; }
.btn-cancel:hover { background: rgba(255,255,255,0.05); color: #fff; }
.btn-submit { padding: 12px 32px; border-radius: 8px; background: linear-gradient(90deg, #F43F5E, #E11D48); color: #fff; border: none; font-size: 13px; font-weight: 600; cursor: pointer; box-shadow: 0 4px 14px rgba(244, 63, 94, 0.25); transition: transform 0.2s; }
.btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(244, 63, 94, 0.35); }
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
  <a href="{{ route('gifts.index') }}" class="btn-back"><i class="fa-solid fa-arrow-left"></i></a>
  <h1 class="ph-title">Edit Gift Status</h1>
</div>

<div class="form-wrapper">
  <form method="POST" action="{{ route('gifts.update', $gift) }}">
    @csrf
    @method('PUT')
    
    <div class="form-card">
      <div class="fc-title">Gift Information</div>
      <div class="fc-sub">Update the details or status of this gift.</div>
      
      <div class="form-grid">
        <div class="form-group">
          <label>Event</label>
          <select name="event_id" class="form-select" disabled>
            <option value="{{ $gift->event_id }}">{{ $gift->event?->name ?? 'General' }}</option>
          </select>
        </div>

        <div class="form-group">
          <label>Gifter/Donor Name</label>
          <input type="text" name="donor_name" class="form-input" value="{{ old('donor_name', $gift->donor_name) }}" required>
          @error('donor_name')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
          <label>Gifter/Donor Phone</label>
          <input type="text" name="donor_phone" class="form-input" value="{{ old('donor_phone', $gift->donor_phone) }}" required>
          @error('donor_phone')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
          <label>Item Name</label>
          <input type="text" name="item_name" class="form-input" value="{{ old('item_name', $gift->item_name) }}" required>
          @error('item_name')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
          <label>Category</label>
          <select name="category" class="form-select" required>
            <option value="other" {{ old('category', $gift->category) == 'other' ? 'selected' : '' }}>Other</option>
            <option value="kitchen_dining" {{ old('category', $gift->category) == 'kitchen_dining' ? 'selected' : '' }}>Kitchen & Dining</option>
            <option value="bedroom_linen" {{ old('category', $gift->category) == 'bedroom_linen' ? 'selected' : '' }}>Bedroom & Linen</option>
            <option value="electronics" {{ old('category', $gift->category) == 'electronics' ? 'selected' : '' }}>Electronics</option>
            <option value="furniture" {{ old('category', $gift->category) == 'furniture' ? 'selected' : '' }}>Furniture</option>
            <option value="clothing" {{ old('category', $gift->category) == 'clothing' ? 'selected' : '' }}>Clothing</option>
          </select>
          @error('category')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
          <label>Estimated Value</label>
          <input type="number" step="0.01" name="estimated_value" class="form-input" value="{{ old('estimated_value', $gift->estimated_value) }}">
          @error('estimated_value')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <div class="form-group fg-full">
          <label>Description/Notes (Optional)</label>
          <textarea name="description" class="form-textarea">{{ old('description', $gift->description) }}</textarea>
          @error('description')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
          <label>Status</label>
          <select name="status" class="form-select" required>
            <option value="pledged" {{ old('status', $gift->status) == 'pledged' ? 'selected' : '' }}>Pledged</option>
            <option value="received" {{ old('status', $gift->status) == 'received' ? 'selected' : '' }}>Received</option>
            <option value="cancelled" {{ old('status', $gift->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
          </select>
          @error('status')<span class="error-msg">{{ $message }}</span>@enderror
        </div>
      </div>
    </div>

    <div class="form-actions">
      <a href="{{ route('gifts.index') }}" class="btn-cancel">Cancel</a>
      <button type="submit" class="btn-submit">Save Changes</button>
    </div>
  </form>
</div>

@endsection
