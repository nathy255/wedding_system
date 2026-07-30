@extends('layouts.app')
@section('title', 'Record Payment')

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
.form-input, .form-select {
  background: rgba(0,0,0,0.15); border: 1px solid var(--border); border-radius: 10px; padding: 12px 16px; color: #fff; font-size: 13px; font-family: 'Inter', sans-serif; transition: all 0.2s; outline: none; width: 100%;
}
.form-input:focus, .form-select:focus { border-color: #10B981; box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1); }
.form-input::placeholder { color: var(--text-faint); }

.payment-methods { display: flex; gap: 12px; }
.pm-option { flex: 1; position: relative; }
.pm-option input { position: absolute; opacity: 0; cursor: pointer; }
.pm-card { background: rgba(0,0,0,0.15); border: 1px solid var(--border); border-radius: 10px; padding: 16px; text-align: center; cursor: pointer; transition: all 0.2s; }
.pm-icon { font-size: 24px; color: var(--text-muted); margin-bottom: 8px; transition: all 0.2s; }
.pm-label { font-size: 12px; font-weight: 600; color: var(--text-muted); transition: all 0.2s; }
.pm-option input:checked + .pm-card { border-color: #10B981; background: rgba(16, 185, 129, 0.05); }
.pm-option input:checked + .pm-card .pm-icon, .pm-option input:checked + .pm-card .pm-label { color: #10B981; }

.form-actions { display: flex; justify-content: flex-end; gap: 12px; padding-top: 16px; border-top: 1px solid var(--border); }
.btn-cancel { padding: 12px 24px; border-radius: 8px; background: transparent; border: 1px solid var(--border); color: var(--text-muted); font-size: 13px; font-weight: 600; text-decoration: none; transition: all 0.2s; cursor: pointer; }
.btn-cancel:hover { background: rgba(255,255,255,0.05); color: #fff; }
.btn-submit { padding: 12px 32px; border-radius: 8px; background: linear-gradient(90deg, #10B981, #059669); color: #fff; border: none; font-size: 13px; font-weight: 600; cursor: pointer; box-shadow: 0 4px 14px rgba(16, 185, 129, 0.25); transition: transform 0.2s; }
.btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(16, 185, 129, 0.35); }
.error-msg { font-size: 11px; color: #EF4444; margin-top: 4px; }

/* ─── Mobile Responsive ─── */
@media (max-width: 768px) {
  .page-header { flex-direction: column; align-items: flex-start; gap: 12px; margin-bottom: 24px; }
  .ph-title { font-size: 20px; }
  .form-grid { grid-template-columns: 1fr; gap: 16px; }
  .fg-full { grid-column: span 1; }
  .payment-methods { flex-wrap: wrap; }
  .pm-option { min-width: calc(50% - 6px); }
  .form-card { padding: 20px; }
}
</style>
@endsection

@section('content')

<div class="page-header">
  <a href="{{ route('contributions.index') }}" class="btn-back"><i class="fa-solid fa-arrow-left"></i></a>
  <h1 class="ph-title">Record New Payment</h1>
</div>

<div class="form-wrapper">
  <form method="POST" action="{{ route('contributions.store') }}">
    @csrf
    
    <div class="form-card">
      <div class="fc-title">Transaction Details</div>
      <div class="fc-sub">Log a payment against a specific event.</div>
      
      <div class="form-grid">
        <div class="form-group">
          <label>Event</label>
          <select name="event_id" class="form-select" required>
            <option value="" disabled {{ old('event_id') ? '' : 'selected' }}>Select Event</option>
            @foreach(\App\Models\Event::all() as $e)
              <option value="{{ $e->id }}" {{ old('event_id', $event?->id) == $e->id ? 'selected' : '' }}>
                {{ $e->name }}
              </option>
            @endforeach
          </select>
          @error('event_id')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
          <label>Type</label>
          <select name="type" class="form-select" required>
            <option value="cash" {{ old('type') == 'cash' ? 'selected' : '' }}>Cash Contribution</option>
            <option value="gift" {{ old('type') == 'gift' ? 'selected' : '' }}>Gift</option>
          </select>
          @error('type')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
          <label>Contributor Name</label>
          <input type="text" name="contributor_name" class="form-input" placeholder="e.g. John Doe" value="{{ old('contributor_name') }}" required>
          @error('contributor_name')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
          <label>Phone Number</label>
          <input type="text" name="contributor_phone" class="form-input" placeholder="+255 7XX XXX XXX" value="{{ old('contributor_phone') }}" required>
          @error('contributor_phone')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <div class="form-group fg-full">
          <label>Amount</label>
          <div style="position:relative;">
            <i class="fa-solid fa-dollar-sign" style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:var(--text-faint);"></i>
            <input type="number" step="0.01" name="amount" class="form-input" style="padding-left:36px; font-size:16px; font-weight:600;" placeholder="0.00" value="{{ old('amount') }}">
          </div>
          @error('amount')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <div class="form-group fg-full">
          <label style="margin-bottom: 8px;">Payment Method</label>
          <div class="payment-methods">
            <label class="pm-option">
              <input type="radio" name="payment_method" value="mpesa" {{ old('payment_method', 'mpesa') == 'mpesa' ? 'checked' : '' }}>
              <div class="pm-card">
                <div class="pm-icon"><i class="fa-solid fa-mobile-screen"></i></div>
                <div class="pm-label">M-Pesa</div>
              </div>
            </label>
            <label class="pm-option">
              <input type="radio" name="payment_method" value="cash" {{ old('payment_method') == 'cash' ? 'checked' : '' }}>
              <div class="pm-card">
                <div class="pm-icon"><i class="fa-solid fa-money-bill"></i></div>
                <div class="pm-label">Cash</div>
              </div>
            </label>
            <label class="pm-option">
              <input type="radio" name="payment_method" value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'checked' : '' }}>
              <div class="pm-card">
                <div class="pm-icon"><i class="fa-solid fa-building-columns"></i></div>
                <div class="pm-label">Bank Tx</div>
              </div>
            </label>
            <label class="pm-option">
              <input type="radio" name="payment_method" value="other" {{ old('payment_method') == 'other' ? 'checked' : '' }}>
              <div class="pm-card">
                <div class="pm-icon"><i class="fa-regular fa-credit-card"></i></div>
                <div class="pm-label">Other</div>
              </div>
            </label>
          </div>
          @error('payment_method')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
          <label>Payment Reference (Optional)</label>
          <input type="text" name="payment_reference" class="form-input" placeholder="e.g. M-Pesa code" value="{{ old('payment_reference') }}">
        </div>

        <div class="form-group">
          <label>Status</label>
          <select name="status" class="form-select" required>
            <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
          </select>
          @error('status')<span class="error-msg">{{ $message }}</span>@enderror
        </div>
      </div>
    </div>

    <div class="form-actions">
      <a href="{{ route('contributions.index') }}" class="btn-cancel">Cancel</a>
      <button type="submit" class="btn-submit">Process Payment</button>
    </div>
  </form>
</div>

@endsection
