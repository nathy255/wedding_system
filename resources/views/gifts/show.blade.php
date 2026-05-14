@extends('layouts.app')
@section('title', 'Gift Details')
@section('heading', 'Gift Details')
@section('subheading', $gift->item_name . ' from ' . $gift->donor_name)

@section('topbar_actions')
  <a href="{{ route('gifts.index') }}" class="btn btn-outline">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    Back to Registry
  </a>
@endsection

@section('content')
<div style="display:grid;grid-template-columns: 1fr 340px; gap: 28px; align-items: start;">
  
  <div class="form-card">
    <div class="form-card-header" style="display:flex; justify-content:space-between; align-items:center;">
      <div>
        <div class="form-card-title">{{ $gift->item_name }}</div>
        <div class="form-card-sub">Registered on {{ $gift->created_at->format('M d, Y') }}</div>
      </div>
      <span class="badge badge-{{ $gift->status }}" style="padding:6px 14px; font-size:13px;">
        {{ ucfirst($gift->status) }}
      </span>
    </div>

    <div class="form-body">
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:32px;">
        
        <div>
          <label style="font-size:11px;color:var(--ink-faint);text-transform:uppercase;letter-spacing:1px;display:block;margin-bottom:8px;">Donor Information</label>
          <div style="font-size:16px; font-weight:600; color:var(--ink);">{{ $gift->donor_name }}</div>
          <div style="font-size:13px; color:var(--ink-muted); margin-top:2px;">{{ $gift->donor_phone }}</div>
        </div>

        <div>
          <label style="font-size:11px;color:var(--ink-faint);text-transform:uppercase;letter-spacing:1px;display:block;margin-bottom:8px;">Category</label>
          <div style="font-size:15px; font-weight:500; color:var(--ink);">{{ ucfirst($gift->category) }}</div>
        </div>

        @if($gift->estimated_value)
        <div>
          <label style="font-size:11px;color:var(--ink-faint);text-transform:uppercase;letter-spacing:1px;display:block;margin-bottom:8px;">Estimated Value</label>
          <div style="font-size:18px; font-weight:600; color:var(--rose); font-family:'Cormorant Garamond', serif;">
            TZS {{ number_format($gift->estimated_value) }}
          </div>
        </div>
        @endif

        @if($gift->status === 'received')
        <div>
          <label style="font-size:11px;color:var(--ink-faint);text-transform:uppercase;letter-spacing:1px;display:block;margin-bottom:8px;">Received By</label>
          <div style="font-size:14px; font-weight:500; color:var(--ink);">{{ $gift->receivedBy?->full_name ?? 'System' }}</div>
          <div style="font-size:12px; color:var(--ink-faint); margin-top:2px;">{{ $gift->received_at->format('M d, Y H:i') }}</div>
        </div>
        @endif

        @if($gift->description)
        <div style="grid-column: span 2;">
          <label style="font-size:11px;color:var(--ink-faint);text-transform:uppercase;letter-spacing:1px;display:block;margin-bottom:8px;">Description / Notes</label>
          <div style="font-size:14px; color:var(--ink-muted); line-height:1.6; background:var(--ivory); padding:16px; border:1px solid var(--border); border-radius:10px;">
            {{ $gift->description }}
          </div>
        </div>
        @endif

      </div>
    </div>

    <div class="form-actions" style="justify-content: space-between;">
      <div>
        @if($gift->status === 'pledged')
          <form method="POST" action="{{ route('gifts.receive', $gift) }}" style="display:inline;">
            @csrf @method('PATCH')
            <button type="submit" class="btn btn-green">
              <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 12v10H4V12"/><path d="M22 7H2v5h20V7z"/><path d="M12 22V7"/></svg>
              Mark as Received
            </button>
          </form>
        @endif
      </div>
      <div style="display:flex; gap:12px;">
        <a href="{{ route('gifts.edit', $gift) }}" class="btn btn-outline">
          <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
          Edit Gift
        </a>
      </div>
    </div>
  </div>

  <div style="background:linear-gradient(135deg, var(--rose) 0%, #6A1830 100%); border-radius:16px; padding:24px; color:#fff; box-shadow:0 10px 25px rgba(139,42,74,0.2);">
    <div style="font-family:'Cormorant Garamond', serif; font-size:18px; font-weight:600; margin-bottom:12px;">Registry Stats</div>
    <div style="font-size:13px; color:rgba(255,255,255,0.7); line-height:1.6;">
      This gift is part of the registry for <strong>{{ $gift->event->couple_name }}</strong>.
    </div>
    <div style="margin-top:24px; padding-top:16px; border-top:1px solid rgba(255,255,255,0.15);">
      <div style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:8px;">
        <span>Gift Status</span>
        <span style="font-weight:700; color:var(--gold-light);">{{ strtoupper($gift->status) }}</span>
      </div>
    </div>
  </div>

</div>
@endsection
