@extends('layouts.app')
@section('title', $event->name)

@section('extra_css')
<style>
.page-header { margin-bottom: 32px; display: flex; align-items: center; justify-content: space-between; }
.ph-left { display: flex; align-items: center; gap: 16px; }
.btn-back { width: 36px; height: 36px; border-radius: 10px; background: rgba(255,255,255,0.03); border: 1px solid var(--border); color: var(--text-muted); display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s; }
.btn-back:hover { background: var(--bg-card-hover); color: #fff; }
.ph-title { font-size: 24px; font-weight: 700; color: #fff; letter-spacing: -0.5px; }

.btn-primary { background: linear-gradient(90deg, #A855F7, #D946EF); color: #fff; padding: 10px 20px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 14px rgba(139, 92, 246, 0.25); transition: transform 0.2s; width: fit-content; }
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(139, 92, 246, 0.35); }

.grid-layout { display: grid; grid-template-columns: 2fr 1fr; gap: 24px; }

.card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 16px; padding: 24px; }
.card-header { font-size: 16px; font-weight: 600; color: #fff; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; }

.info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
.info-item { display: flex; flex-direction: column; gap: 6px; }
.ii-label { font-size: 11px; font-weight: 500; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; }
.ii-value { font-size: 15px; font-weight: 500; color: #fff; }

.budget-progress { margin-top: 16px; }
.bp-bar { height: 8px; background: rgba(255,255,255,0.05); border-radius: 99px; overflow: hidden; margin-bottom: 8px; }
.bp-fill { height: 100%; background: linear-gradient(90deg, #A855F7, #D946EF); border-radius: 99px; }
.bp-labels { display: flex; justify-content: space-between; font-size: 12px; color: var(--text-muted); }

.description-box { margin-top: 24px; padding-top: 24px; border-top: 1px solid rgba(255,255,255,0.05); font-size: 14px; line-height: 1.6; color: var(--text-muted); }

/* ─── Mobile Responsive ─── */
@media (max-width: 768px) {
  .page-header { flex-direction: column; align-items: flex-start; gap: 16px; }
  .ph-title { font-size: 20px; }
  .grid-layout { grid-template-columns: 1fr; }
  .info-grid { grid-template-columns: 1fr 1fr; gap: 16px; }
  .card { padding: 20px; }
}

@media (max-width: 480px) {
  .ph-title { font-size: 18px; }
  .btn-primary { padding: 10px 16px; font-size: 12px; }
  .info-grid { grid-template-columns: 1fr; gap: 12px; }
  .card { padding: 16px; border-radius: 12px; }
}
</style>
@endsection

@section('content')

<div class="page-header">
  <div class="ph-left">
    <a href="{{ route('events.index') }}" class="btn-back"><i class="fa-solid fa-arrow-left"></i></a>
    <h1 class="ph-title">{{ $event->name }}</h1>
  </div>
  <a href="{{ route('events.edit', $event) }}" class="btn-primary">
    <i class="fa-solid fa-pen"></i> Edit Workspace
  </a>
</div>

<div class="grid-layout">
  
  <div style="display: flex; flex-direction: column; gap: 24px;">
    <div class="card">
      <div class="card-header">Workspace Overview</div>
      <div class="info-grid">
        <div class="info-item">
          <span class="ii-label">Event Date</span>
          <span class="ii-value">{{ $event->event_date ? $event->event_date->format('F d, Y') : 'TBD' }}</span>
        </div>
        <div class="info-item">
          <span class="ii-label">Days Remaining</span>
          <span class="ii-value" style="color: var(--brand-magenta);">{{ $event->days_to_go }} days</span>
        </div>
        <div class="info-item">
          <span class="ii-label">Venue</span>
          <span class="ii-value">{{ $event->venue ?? 'Not Specified' }}</span>
        </div>
        <div class="info-item">
          <span class="ii-label">Status</span>
          <span class="ii-value" style="color: var(--status-green);">Active Workspace</span>
        </div>
      </div>
      
      @if($event->description)
      <div class="description-box">
        <strong style="color:#fff; display:block; margin-bottom:8px;">Internal Notes</strong>
        {{ $event->description }}
      </div>
      @endif
    </div>
  </div>

  <div style="display: flex; flex-direction: column; gap: 24px;">
    <div class="card">
      <div class="card-header">Financial Snapshot</div>
      
      <div style="display:flex; justify-content:space-between; margin-bottom: 8px;">
        <span style="font-size:13px; color:var(--text-muted);">Target Budget</span>
        <span style="font-size:14px; font-weight:600; color:#fff;">${{ number_format($event->target_budget) }}</span>
      </div>
      
      <div class="budget-progress">
        <div class="bp-bar">
          <div class="bp-fill" style="width: {{ $event->progress_percent }}%;"></div>
        </div>
        <div class="bp-labels">
          <span>${{ number_format($event->total_confirmed) }} collected</span>
          <span>{{ $event->progress_percent }}%</span>
        </div>
      </div>

      <div style="margin-top: 24px; display:flex; gap:12px;">
        <a href="{{ route('contributions.index') }}" class="btn-primary" style="flex:1; justify-content:center; background: rgba(139, 92, 246, 0.1); border: 1px solid rgba(139, 92, 246, 0.3); color: #A855F7; box-shadow: none;">
          View Budget
        </a>
      </div>
    </div>
  </div>

</div>

@endsection
