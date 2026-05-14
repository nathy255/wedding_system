@extends('layouts.app')
@section('title', 'Register Gift')
@section('heading', 'Register Gift')
@section('subheading', 'Register a physical gift item from a donor')

@section('topbar_actions')
  <a href="{{ route('gifts.index') }}" class="btn btn-outline">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    Back to Registry
  </a>
@endsection

@section('content')
<div class="form-card" style="max-width: 800px; margin: 0 auto;">
  <form method="POST" action="{{ route('gifts.store') }}">
    @csrf
    <input type="hidden" name="event_id" value="{{ $event?->id }}"/>

    <div class="form-card-header">
      <div class="form-card-title">Gift Details</div>
      <div class="form-card-sub">Enter the information about the gift and the donor</div>
    </div>

    <div class="form-body">
      <div class="form-grid">
        
        <div class="field span2">
          <label>Gift Item Name</label>
          <input type="text" name="item_name" value="{{ old('item_name') }}" placeholder="e.g. Samsung 43\" Smart TV, Dining Set..." required/>
          @error('item_name')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <div class="field">
          <label>Donor Name</label>
          <input type="text" name="donor_name" value="{{ old('donor_name') }}" placeholder="Full name" required/>
          @error('donor_name')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <div class="field">
          <label>Donor Phone</label>
          <input type="tel" name="donor_phone" value="{{ old('donor_phone') }}" placeholder="+255 7XX XXX XXX" required/>
          @error('donor_phone')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <div class="field">
          <label>Category</label>
          <select name="category" required>
            <option value="electronics">Electronics</option>
            <option value="kitchenware">Kitchenware</option>
            <option value="furniture">Furniture</option>
            <option value="clothing">Clothing</option>
            <option value="cash_equivalent">Cash Equivalent (Voucher, etc.)</option>
            <option value="other">Other</option>
          </select>
        </div>

        <div class="field">
          <label>Estimated Value (TZS)</label>
          <input type="number" name="estimated_value" value="{{ old('estimated_value') }}" placeholder="0"/>
          <span style="font-size:11px;color:var(--ink-faint);">Optional: For reporting purposes</span>
        </div>

        <div class="field span2">
          <label>Status</label>
          <div style="display:flex;gap:12px;">
            @foreach(['pledged' => '⏳ Pledged', 'received' => '📦 Received', 'cancelled' => '✕ Cancelled'] as $val => $lbl)
              <label style="flex:1;display:flex;align-items:center;justify-content:center;gap:8px;padding:12px;border:1.5px solid var(--border);border-radius:10px;cursor:pointer;font-size:14px;font-weight:500;">
                <input type="radio" name="status" value="{{ $val }}" {{ old('status', 'pledged') === $val ? 'checked' : '' }} style="accent-color:var(--rose);"/>
                {{ $lbl }}
              </label>
            @endforeach
          </div>
        </div>

        <div class="field span2">
          <label>Description / Notes</label>
          <textarea name="description" placeholder="Brand, model, or any special notes...">{{ old('description') }}</textarea>
        </div>

      </div>
    </div>

    <div class="form-actions">
      <a href="{{ route('gifts.index') }}" class="btn btn-outline">Cancel</a>
      <button type="submit" class="btn btn-primary">Register Gift</button>
    </div>
  </form>
</div>
@endsection
