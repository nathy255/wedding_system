@extends('layouts.app')
@section('title', 'Contribution Details')
@section('heading', 'Contribution Details')
@section('subheading', 'Detailed record of ' . $contribution->contributor_name . '\'s contribution')

@section('topbar_actions')
  <a href="{{ route('contributions.index') }}" class="btn btn-outline">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    Back to List
  </a>
@endsection

@section('content')
<div style="display:grid;grid-template-columns:1fr 340px;gap:28px;align-items:start;">
  
  {{-- Main Details Card --}}
  <div class="form-card">
    <div class="form-card-header" style="display:flex;justify-content:space-between;align-items:center;">
      <div>
        <div class="form-card-title">General Information</div>
        <div class="form-card-sub">Recorded on {{ $contribution->created_at->format('M d, Y at H:i') }}</div>
      </div>
      <span class="badge badge-{{ $contribution->status }}" style="padding:6px 14px;font-size:13px;">
        {{ ucfirst($contribution->status) }}
      </span>
    </div>
    
    <div class="form-body">
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:32px;">
        
        <div>
          <label style="font-size:11px;color:var(--ink-faint);text-transform:uppercase;letter-spacing:1px;display:block;margin-bottom:8px;">Contributor</label>
          <div style="display:flex;align-items:center;gap:14px;">
            <div style="width:48px;height:48px;border-radius:12px;background:var(--gold-pale);color:var(--gold);display:flex;align-items:center;justify-content:center;font-size:20px;font-family:'Cormorant Garamond',serif;font-weight:600;">
              {{ strtoupper(substr($contribution->contributor_name, 0, 1)) }}
            </div>
            <div>
              <div style="font-size:16px;font-weight:600;color:var(--ink);">{{ $contribution->contributor_name }}</div>
              <div style="font-size:13px;color:var(--ink-muted);">{{ $contribution->contributor_phone }}</div>
            </div>
          </div>
        </div>

        <div>
          <label style="font-size:11px;color:var(--ink-faint);text-transform:uppercase;letter-spacing:1px;display:block;margin-bottom:8px;">Type & Method</label>
          <div style="font-size:15px;font-weight:500;color:var(--ink);">
            {{ ucfirst($contribution->type) }}
            @if($contribution->payment_method)
              <span style="color:var(--ink-faint);font-weight:400;"> via </span> 
              {{ ucwords(str_replace('_',' ',$contribution->payment_method)) }}
            @endif
          </div>
          @if($contribution->payment_reference)
            <div style="font-size:12px;color:var(--rose);margin-top:4px;font-family:monospace;">Ref: {{ $contribution->payment_reference }}</div>
          @endif
        </div>

        <div style="grid-column: span 2; padding:24px; background:var(--ivory); border-radius:12px; border:1px dashed var(--border); display:flex; justify-content:space-between; align-items:center;">
          <div>
            <label style="font-size:11px;color:var(--ink-faint);text-transform:uppercase;letter-spacing:1px;display:block;margin-bottom:4px;">Amount Contributed</label>
            <div style="font-family:'Cormorant Garamond',serif;font-size:32px;font-weight:600;color:var(--rose);">
              TZS {{ number_format($contribution->amount) }}
            </div>
          </div>
          <div style="text-align:right;">
             <label style="font-size:11px;color:var(--ink-faint);text-transform:uppercase;letter-spacing:1px;display:block;margin-bottom:4px;">Recorded By</label>
             <div style="font-size:14px;font-weight:500;color:var(--ink);">{{ $contribution->recordedBy?->full_name ?? 'System' }}</div>
          </div>
        </div>

        @if($contribution->notes)
        <div style="grid-column: span 2;">
          <label style="font-size:11px;color:var(--ink-faint);text-transform:uppercase;letter-spacing:1px;display:block;margin-bottom:8px;">Notes / Description</label>
          <div style="font-size:14px;color:var(--ink-muted);line-height:1.6;background:var(--surface);padding:16px;border:1px solid var(--border);border-radius:10px;">
            {{ $contribution->notes }}
          </div>
        </div>
        @endif

      </div>
    </div>

    <div class="form-actions" style="justify-content: space-between;">
      <div>
        @if($contribution->status === 'pending')
          <form method="POST" action="{{ route('contributions.confirm', $contribution) }}" style="display:inline;">
            @csrf @method('PATCH')
            <button type="submit" class="btn btn-green">
              <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
              Confirm Contribution
            </button>
          </form>
          <form method="POST" action="{{ route('contributions.reject', $contribution) }}" style="display:inline;">
            @csrf @method('PATCH')
            <button type="submit" class="btn btn-outline" style="color:#C62828; border-color:rgba(198,40,40,0.2);" onclick="return confirm('Reject this entry?')">
              <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
              Reject
            </button>
          </form>
        @endif
      </div>
      <div style="display:flex;gap:12px;">
        <a href="{{ route('contributions.edit', $contribution) }}" class="btn btn-outline">
          <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
          Edit Entry
        </a>
        <a href="{{ route('contributions.receipt', $contribution) }}" target="_blank" class="btn btn-primary">
          <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
          Print Receipt
        </a>
      </div>
    </div>
  </div>

  {{-- Sidebar Info --}}
  <div style="display:flex;flex-direction:column;gap:24px;">
    
    <div style="background:#fff;border:1px solid var(--border);border-radius:16px;padding:24px;">
      <div style="font-family:'Cormorant Garamond',serif;font-size:18px;font-weight:600;margin-bottom:16px;">Confirmation Status</div>
      
      @if($contribution->status === 'confirmed')
        <div style="display:flex;gap:12px;margin-bottom:20px;">
          <div style="width:36px;height:36px;border-radius:50%;background:var(--green-pale);color:var(--green);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
          </div>
          <div>
            <div style="font-size:14px;font-weight:600;color:var(--ink);">Verified & Confirmed</div>
            <div style="font-size:12px;color:var(--ink-faint);margin-top:2px;">On {{ $contribution->confirmed_at->format('M d, Y H:i') }} by {{ $contribution->confirmedBy?->full_name }}</div>
          </div>
        </div>
      @else
        <div style="display:flex;gap:12px;margin-bottom:20px;">
          <div style="width:36px;height:36px;border-radius:50%;background:var(--amber-pale);color:var(--amber);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          </div>
          <div>
            <div style="font-size:14px;font-weight:600;color:var(--ink);">Awaiting Confirmation</div>
            <div style="font-size:12px;color:var(--ink-faint);margin-top:2px;">This entry has not been verified yet.</div>
          </div>
        </div>
      @endif

      <div style="padding:16px;background:var(--ivory);border-radius:10px;font-size:12px;color:var(--ink-muted);line-height:1.5;">
        <strong style="color:var(--rose);">Note:</strong> Confirmed contributions are automatically added to the event's total balance and are visible in reports.
      </div>
    </div>

    <div style="background:linear-gradient(135deg, var(--ink) 0%, #2A1A17 100%);border-radius:16px;padding:24px;color:#fff;position:relative;overflow:hidden;">
      <div style="position:absolute;top:-20px;right:-20px;width:100px;height:100px;background:var(--rose);opacity:0.1;filter:blur(40px);border-radius:50%;"></div>
      <div style="font-family:'Cormorant Garamond',serif;font-size:18px;font-weight:600;margin-bottom:12px;color:var(--gold-light);">Event Context</div>
      <div style="font-size:15px;font-weight:500;margin-bottom:4px;">{{ $contribution->event->couple_name }}</div>
      <div style="font-size:12px;color:rgba(255,255,255,0.5);">{{ $contribution->event->wedding_date->format('F d, Y') }}</div>
      <div style="margin-top:20px;padding-top:16px;border-top:1px solid rgba(255,255,255,0.1);">
         <div style="display:flex;justify-content:space-between;font-size:11px;color:rgba(255,255,255,0.4);text-transform:uppercase;margin-bottom:6px;">
            <span>Budget Progress</span>
            <span>{{ $contribution->event->progress_percent }}%</span>
         </div>
         <div style="height:6px;background:rgba(255,255,255,0.1);border-radius:3px;overflow:hidden;">
            <div style="height:100%;width:{{ $contribution->event->progress_percent }}%;background:var(--gold-light);border-radius:3px;"></div>
         </div>
      </div>
    </div>

  </div>

</div>
@endsection
