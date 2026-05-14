@extends('layouts.app')
@section('title', 'Edit Contribution')
@section('heading', 'Edit Contribution')
@section('subheading', 'Update record for ' . $contribution->contributor_name)

@section('topbar_actions')
  <a href="{{ route('contributions.show', $contribution) }}" class="btn btn-outline">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    Back to Details
  </a>
@endsection

@section('content')
<div style="display:grid;grid-template-columns:1fr 300px;gap:24px;">
  <div>
    <form method="POST" action="{{ route('contributions.update', $contribution) }}">
      @csrf
      @method('PUT')
      <input type="hidden" name="event_id" value="{{ $contribution->event_id }}"/>
      <input type="hidden" name="type" value="{{ $contribution->type }}"/>

      <div class="form-card">
        <div class="form-card-header">
          <div class="form-card-title">{{ ucfirst($contribution->type) }} Contribution Details</div>
          <div class="form-card-sub">Modify the entry information below</div>
        </div>
        <div class="form-body">
          <div class="form-grid">

            @if($contribution->type === 'cash')
            <div class="field span2">
              <label>Amount (TZS)</label>
              <input type="number" name="amount" value="{{ old('amount', $contribution->amount) }}" placeholder="0" style="font-size:22px;font-family:'Cormorant Garamond',serif;font-weight:600;padding:12px 16px;" required/>
              @error('amount')<span class="error-msg">{{ $message }}</span>@enderror
            </div>
            @endif

            <div class="field">
              <label>{{ $contribution->type === 'gift' ? 'Gift Item Name' : 'Contributor Name' }}</label>
              <input type="text" name="contributor_name" value="{{ old('contributor_name', $contribution->contributor_name) }}" placeholder="Full name" required/>
              @error('contributor_name')<span class="error-msg">{{ $message }}</span>@enderror
            </div>

            <div class="field">
              <label>{{ $contribution->type === 'gift' ? 'Donor Name' : 'Phone Number' }}</label>
              <input type="text" name="contributor_phone" value="{{ old('contributor_phone', $contribution->contributor_phone) }}" placeholder="+255 7XX XXX XXX" required/>
              @error('contributor_phone')<span class="error-msg">{{ $message }}</span>@enderror
            </div>

            @if($contribution->type === 'cash')
            <div class="field">
              <label>Payment Method</label>
              <select name="payment_method">
                @foreach(['mpesa'=>'M-Pesa', 'airtel_money'=>'Airtel Money', 'cash'=>'Cash (Hand)', 'bank_transfer'=>'Bank Transfer', 'tigopesa'=>'Tigo Pesa', 'other'=>'Other'] as $val => $lbl)
                  <option value="{{ $val }}" {{ old('payment_method', $contribution->payment_method) === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                @endforeach
              </select>
            </div>

            <div class="field">
              <label>Payment Reference / Transaction ID</label>
              <input type="text" name="payment_reference" value="{{ old('payment_reference', $contribution->payment_reference) }}" placeholder="e.g. MP2026XXXX"/>
            </div>
            @endif

            <div class="field span2">
              <label>Status</label>
              <div style="display:flex;gap:10px;">
                @php
                  $statuses = $contribution->type === 'cash' 
                    ? ['pending'=>'⏳ Pending','confirmed'=>'✓ Confirmed','rejected'=>'✕ Rejected']
                    : ['pending'=>'⏳ Pledged','confirmed'=>'✓ Received','rejected'=>'✕ Cancelled'];
                @endphp
                @foreach($statuses as $val => $label)
                <label style="flex:1;display:flex;align-items:center;justify-content:center;gap:7px;padding:10px;border-radius:9px;border:1.5px solid var(--border);cursor:pointer;font-size:13px;font-weight:500;transition:all 0.15s; {{ old('status', $contribution->status) === $val ? 'border-color:var(--rose); background:var(--rose-pale); color:var(--rose);' : '' }}">
                  <input type="radio" name="status" value="{{ $val }}" {{ old('status', $contribution->status) === $val ? 'checked' : '' }} style="accent-color:var(--rose);"/>
                  {{ $label }}
                </label>
                @endforeach
              </div>
            </div>

            <div class="field span2">
              <label>Notes / Description</label>
              <textarea name="notes" placeholder="Any additional notes...">{{ old('notes', $contribution->notes) }}</textarea>
            </div>

          </div>
        </div>
        <div class="form-actions">
          <a href="{{ route('contributions.show', $contribution) }}" class="btn btn-outline">Cancel</a>
          <button type="submit" class="btn btn-primary">Update Contribution</button>
        </div>
      </div>
    </form>
  </div>

  {{-- Context Sidebar --}}
  <div>
    <div style="background:#fff;border:1px solid var(--border);border-radius:16px;padding:22px;">
      <div style="font-family:'Cormorant Garamond',serif;font-size:18px;font-weight:600;margin-bottom:18px;">Audit Trail</div>
      <div style="display:flex;flex-direction:column;gap:16px;">
        <div style="display:flex;gap:10px;">
          <div style="width:8px;height:8px;border-radius:50%;background:var(--gold);margin-top:4px;"></div>
          <div>
            <div style="font-size:12px;font-weight:600;">Created</div>
            <div style="font-size:11px;color:var(--ink-faint);">{{ $contribution->created_at->format('M d, Y H:i') }}</div>
            <div style="font-size:11px;color:var(--ink-muted);">by {{ $contribution->recordedBy?->full_name }}</div>
          </div>
        </div>
        @if($contribution->confirmed_at)
        <div style="display:flex;gap:10px;">
          <div style="width:8px;height:8px;border-radius:50%;background:var(--green);margin-top:4px;"></div>
          <div>
            <div style="font-size:12px;font-weight:600;">Confirmed</div>
            <div style="font-size:11px;color:var(--ink-faint);">{{ $contribution->confirmed_at->format('M d, Y H:i') }}</div>
            <div style="font-size:11px;color:var(--ink-muted);">by {{ $contribution->confirmedBy?->full_name }}</div>
          </div>
        </div>
        @endif
        <div style="display:flex;gap:10px;">
          <div style="width:8px;height:8px;border-radius:50%;background:var(--rose);margin-top:4px;"></div>
          <div>
            <div style="font-size:12px;font-weight:600;">Last Updated</div>
            <div style="font-size:11px;color:var(--ink-faint);">{{ $contribution->updated_at->format('M d, Y H:i') }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
