@extends('layouts.app')
@section('title','Add Contribution')
@section('heading','Add Contribution')
@section('subheading','Record a new cash or gift contribution')

@section('topbar_actions')
  <a href="{{ route('contributions.index') }}" class="btn btn-outline">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    Back
  </a>
@endsection

@section('content')
<div style="display:grid;grid-template-columns:1fr 300px;gap:24px;">
  <div>
    {{-- Type Toggle --}}
    <div style="display:flex;background:#fff;border:1px solid var(--border);border-radius:14px;padding:6px;gap:6px;margin-bottom:24px;">
      <button type="button" id="btn-cash" onclick="switchType('cash')" style="flex:1;padding:13px;border-radius:10px;border:none;background:var(--rose);color:#fff;font-family:'DM Sans',sans-serif;font-size:14px;font-weight:500;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:9px;box-shadow:0 4px 12px rgba(139,42,74,.25);">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        Cash Contribution
      </button>
      <button type="button" id="btn-gift" onclick="switchType('gift')" style="flex:1;padding:13px;border-radius:10px;border:none;background:transparent;color:var(--ink-faint);font-family:'DM Sans',sans-serif;font-size:14px;font-weight:500;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:9px;">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 12v10H4V12"/><path d="M22 7H2v5h20V7z"/><path d="M12 22V7"/><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/></svg>
        Gift Contribution
      </button>
    </div>

    {{-- CASH FORM --}}
    <div id="panel-cash">
      <form method="POST" action="{{ route('contributions.store') }}">
        @csrf
        <input type="hidden" name="type" value="cash"/>
        <input type="hidden" name="event_id" value="{{ $event?->id }}"/>

        <div class="form-card">
          <div class="form-card-header">
            <div class="form-card-title">Cash Contribution</div>
            <div class="form-card-sub">Record money received from a contributor</div>
          </div>
          <div class="form-body">
            <div class="form-grid">

              <div class="field span2">
                <label>Amount (TZS)</label>
                <input type="number" name="amount" value="{{ old('amount') }}" placeholder="0" style="font-size:22px;font-family:'Cormorant Garamond',serif;font-weight:600;padding:12px 16px;" required/>
                @error('amount')<span class="error-msg">{{ $message }}</span>@enderror
              </div>

              <div class="field">
                <label>Contributor Name</label>
                <input type="text" name="contributor_name" value="{{ old('contributor_name') }}" placeholder="Full name" required/>
                @error('contributor_name')<span class="error-msg">{{ $message }}</span>@enderror
              </div>

              <div class="field">
                <label>Phone Number</label>
                <input type="tel" name="contributor_phone" value="{{ old('contributor_phone') }}" placeholder="+255 7XX XXX XXX" required/>
              </div>

              <div class="field">
                <label>Payment Method</label>
                <select name="payment_method">
                  <option value="mpesa">M-Pesa</option>
                  <option value="airtel_money">Airtel Money</option>
                  <option value="cash">Cash (Hand)</option>
                  <option value="bank_transfer">Bank Transfer</option>
                  <option value="tigopesa">Tigo Pesa</option>
                  <option value="other">Other</option>
                </select>
              </div>

              <div class="field">
                <label>Payment Reference / Transaction ID</label>
                <input type="text" name="payment_reference" value="{{ old('payment_reference') }}" placeholder="e.g. MP2026XXXX"/>
                <span style="font-size:11.5px;color:var(--ink-faint);">Leave blank if paid by hand</span>
              </div>

              <div class="field span2">
                <label>Status</label>
                <div style="display:flex;gap:10px;">
                  @foreach(['pending'=>'⏳ Pending','confirmed'=>'✓ Confirmed','rejected'=>'✕ Rejected'] as $val => $label)
                  <label style="flex:1;display:flex;align-items:center;justify-content:center;gap:7px;padding:10px;border-radius:9px;border:1.5px solid var(--border);cursor:pointer;font-size:13px;font-weight:500;transition:all 0.15s;" id="status-{{ $val }}">
                    <input type="radio" name="status" value="{{ $val }}" {{ old('status','pending') === $val ? 'checked' : '' }} style="accent-color:var(--rose);" onchange="highlightStatus()"/>
                    {{ $label }}
                  </label>
                  @endforeach
                </div>
              </div>

              <div class="field span2">
                <label>Notes (optional)</label>
                <textarea name="notes" placeholder="Any additional notes...">{{ old('notes') }}</textarea>
              </div>

            </div>
          </div>
          <div class="form-actions">
            <a href="{{ route('contributions.index') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Contribution</button>
          </div>
        </div>
      </form>
    </div>

    {{-- GIFT FORM --}}
    <div id="panel-gift" style="display:none;">
      <form method="POST" action="{{ route('contributions.store') }}">
        @csrf
        <input type="hidden" name="type" value="gift"/>
        <input type="hidden" name="event_id" value="{{ $event?->id }}"/>

        <div class="form-card">
          <div class="form-card-header">
            <div class="form-card-title">Gift Contribution</div>
            <div class="form-card-sub">Register a physical gift item</div>
          </div>
          <div class="form-body">
            <div class="form-grid">

              <div class="field span2">
                <label>Gift Item Name</label>
                <input type="text" name="contributor_name" placeholder="e.g. Dining Set (12 pieces), Samsung TV 43-inch..." required/>
              </div>

              <div class="field">
                <label>Donor Name</label>
                <input type="text" name="contributor_phone" placeholder="Full name" required/>
              </div>

              <div class="field">
                <label>Donor Phone</label>
                <input type="tel" placeholder="+255 7XX XXX XXX"/>
              </div>

              <div class="field span2">
                <label>Status</label>
                <div style="display:flex;gap:10px;">
                  @foreach(['pending'=>'⏳ Pledged','confirmed'=>'✓ Received','rejected'=>'✕ Cancelled'] as $val => $label)
                  <label style="flex:1;display:flex;align-items:center;justify-content:center;gap:7px;padding:10px;border-radius:9px;border:1.5px solid var(--border);cursor:pointer;font-size:13px;font-weight:500;">
                    <input type="radio" name="status" value="{{ $val }}" {{ $val === 'pending' ? 'checked' : '' }} style="accent-color:var(--rose);"/>
                    {{ $label }}
                  </label>
                  @endforeach
                </div>
              </div>

              <div class="field span2">
                <label>Description</label>
                <textarea name="notes" placeholder="Describe the gift item..."></textarea>
              </div>

            </div>
          </div>
          <div class="form-actions">
            <a href="{{ route('contributions.index') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Gift</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  {{-- Summary Sidebar --}}
  <div>
    <div style="background:#fff;border:1px solid var(--border);border-radius:16px;padding:22px;">
      <div style="font-family:'Cormorant Garamond',serif;font-size:18px;font-weight:600;margin-bottom:18px;">Event Summary</div>
      @if($event)
      @foreach([
        ['Event', $event->couple_name],
        ['Wedding Date', $event->wedding_date->format('M d, Y')],
        ['Target Budget', 'TZS ' . number_format($event->target_budget)],
        ['Collected So Far', 'TZS ' . number_format($event->total_confirmed)],
        ['Remaining', 'TZS ' . number_format($event->target_budget - $event->total_confirmed)],
        ['Progress', $event->progress_percent . '%'],
      ] as [$label, $value])
      <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid var(--border);font-size:13px;">
        <span style="color:var(--ink-faint);">{{ $label }}</span>
        <span style="font-weight:600;color:var(--ink);">{{ $value }}</span>
      </div>
      @endforeach
      @endif
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
function switchType(type) {
  const isCash = type === 'cash';
  document.getElementById('panel-cash').style.display = isCash ? 'block' : 'none';
  document.getElementById('panel-gift').style.display = isCash ? 'none' : 'block';
  const cashBtn = document.getElementById('btn-cash');
  const giftBtn = document.getElementById('btn-gift');
  cashBtn.style.background = isCash ? 'var(--rose)' : 'transparent';
  cashBtn.style.color = isCash ? '#fff' : 'var(--ink-faint)';
  cashBtn.style.boxShadow = isCash ? '0 4px 12px rgba(139,42,74,.25)' : 'none';
  giftBtn.style.background = !isCash ? 'var(--gold)' : 'transparent';
  giftBtn.style.color = !isCash ? '#fff' : 'var(--ink-faint)';
  giftBtn.style.boxShadow = !isCash ? '0 4px 12px rgba(184,147,42,.25)' : 'none';
}
</script>
@endsection
