@extends('layouts.app')
@section('title', 'Event Details')
@section('heading', 'Event Details')
@section('subheading', $event->couple_name)

@section('topbar_actions')
  <div style="display:flex; gap:12px;">
    <a href="{{ route('events.index') }}" class="btn btn-outline">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
      Back
    </a>
    <a href="{{ route('events.edit', $event) }}" class="btn btn-primary">Edit Event</a>
  </div>
@endsection

@section('content')
<div style="display:grid; grid-template-columns: 1fr 350px; gap: 28px; align-items: start;">
  
  <div style="display:flex; flex-direction:column; gap:28px;">
    
    <div class="form-card">
      <div class="form-card-header">
        <div class="form-card-title">Event Overview</div>
      </div>
      <div class="form-body">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:32px;">
           <div>
             <label style="font-size:11px;color:var(--ink-faint);text-transform:uppercase;letter-spacing:1px;display:block;margin-bottom:8px;">Wedding Date</label>
             <div style="font-size:16px; font-weight:600;">{{ $event->wedding_date->format('F d, Y') }}</div>
             <div style="font-size:13px; color:var(--rose); margin-top:2px;">{{ $event->days_to_go }} days to go</div>
           </div>
           <div>
             <label style="font-size:11px;color:var(--ink-faint);text-transform:uppercase;letter-spacing:1px;display:block;margin-bottom:8px;">Venue</label>
             <div style="font-size:16px; font-weight:600;">{{ $event->venue ?? 'Not set' }}</div>
           </div>
           <div>
             <label style="font-size:11px;color:var(--ink-faint);text-transform:uppercase;letter-spacing:1px;display:block;margin-bottom:8px;">Target Budget</label>
             <div style="font-size:20px; font-weight:700; color:var(--rose); font-family:'Cormorant Garamond', serif;">TZS {{ number_format($event->target_budget) }}</div>
           </div>
           <div>
             <label style="font-size:11px;color:var(--ink-faint);text-transform:uppercase;letter-spacing:1px;display:block;margin-bottom:8px;">Status</label>
             <span class="badge {{ $event->is_active ? 'badge-confirmed' : 'badge-rejected' }}">
               {{ $event->is_active ? 'Active' : 'Inactive' }}
             </span>
           </div>
        </div>
      </div>
    </div>

    @if($event->description)
    <div class="form-card">
      <div class="form-card-header"><div class="form-card-title">Description</div></div>
      <div class="form-body" style="font-size:14px; line-height:1.7; color:var(--ink-muted);">
        {{ $event->description }}
      </div>
    </div>
    @endif

  </div>

  <div style="display:flex; flex-direction:column; gap:24px;">
    
    <div style="background:#fff; border:1px solid var(--border); border-radius:16px; padding:24px;">
      <div style="font-family:'Cormorant Garamond', serif; font-size:18px; font-weight:600; margin-bottom:18px;">Financial Snapshot</div>
      
      <div style="margin-bottom:20px;">
        <div style="display:flex; justify-content:space-between; font-size:13px; margin-bottom:8px;">
          <span style="color:var(--ink-faint);">Confirmed Collection</span>
          <span style="font-weight:600; color:var(--green);">TZS {{ number_format($event->total_confirmed) }}</span>
        </div>
        <div style="height:8px; background:var(--ivory); border-radius:4px; overflow:hidden;">
          <div style="height:100%; width:{{ $event->progress_percent }}%; background:var(--green);"></div>
        </div>
        <div style="font-size:11px; text-align:right; margin-top:4px; color:var(--ink-faint);">{{ $event->progress_percent }}% of target</div>
      </div>

      <div style="display:flex; justify-content:space-between; font-size:13px; padding:12px 0; border-top:1px solid var(--border);">
        <span style="color:var(--ink-faint);">Pending Pledges</span>
        <span style="font-weight:600; color:var(--amber);">TZS {{ number_format($event->total_pending) }}</span>
      </div>
      
      <div style="display:flex; justify-content:space-between; font-size:13px; padding:12px 0; border-top:1px solid var(--border);">
        <span style="color:var(--ink-faint);">Remaining Gap</span>
        <span style="font-weight:600; color:var(--rose);">TZS {{ number_format($event->target_budget - $event->total_confirmed) }}</span>
      </div>
    </div>

  </div>

</div>
@endsection
