@extends('layouts.app')
@section('title', 'My Events')

@section('extra_css')
<style>
.page-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  margin-bottom: 24px;
}
.ph-title {
  font-size: 28px;
  font-weight: 700;
  color: #fff;
  letter-spacing: -0.5px;
  margin-bottom: 6px;
}
.ph-sub {
  color: var(--text-muted);
  font-size: 14px;
}

.btn-primary {
  background: linear-gradient(90deg, #A855F7, #D946EF);
  color: #fff;
  padding: 10px 20px;
  border-radius: 8px;
  font-size: 13px;
  font-weight: 600;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  border: none;
  cursor: pointer;
  box-shadow: 0 4px 14px rgba(139, 92, 246, 0.25);
  transition: transform 0.2s;
  width: fit-content;
}
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(139, 92, 246, 0.35); }

.filter-bar {
  display: flex; gap: 12px; margin-bottom: 24px;
}
.filter-btn {
  background: var(--bg-card);
  border: 1px solid var(--border);
  color: var(--text-muted);
  padding: 8px 16px;
  border-radius: 99px;
  font-size: 12px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s;
}
.filter-btn.active {
  background: rgba(139, 92, 246, 0.15);
  color: var(--brand-purple);
  border-color: rgba(139, 92, 246, 0.3);
}

.data-card {
  background: var(--bg-card);
  border: 1px solid var(--border);
  border-radius: 12px;
  padding: 20px;
}

.data-table {
  width: 100%;
  border-collapse: collapse;
}
.data-table th {
  text-align: left; font-size: 11px; font-weight: 500; color: var(--text-muted); padding-bottom: 16px; border-bottom: 1px solid var(--border); text-transform: uppercase; letter-spacing: 0.5px;
}
.data-table td {
  padding: 16px 0; border-bottom: 1px solid rgba(255,255,255,0.03); font-size: 13px; color: var(--text-main);
}
.data-table tr:last-child td { border-bottom: none; }

.event-name-col { display: flex; align-items: center; gap: 12px; }
.event-icon { width: 40px; height: 40px; border-radius: 10px; background: rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center; font-size: 16px; color: var(--brand-magenta); }
.event-name-text { font-weight: 600; color: #fff; font-size: 14px; }
.event-type-text { font-size: 11px; color: var(--text-faint); margin-top: 2px; }

.status-pill {
  display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 99px; font-size: 11px; font-weight: 500;
}
.status-pill::before { content: ''; width: 6px; height: 6px; border-radius: 50%; }
.pill-active { background: rgba(16, 185, 129, 0.15); color: var(--status-green); border: 1px solid rgba(16, 185, 129, 0.2); }
.pill-active::before { background: var(--status-green); }
.pill-inactive { background: rgba(255, 255, 255, 0.05); color: var(--text-muted); border: 1px solid rgba(255, 255, 255, 0.1); }
.pill-inactive::before { background: var(--text-faint); }

.action-btns { display: flex; gap: 8px; }
.btn-icon { width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,0.03); border: 1px solid var(--border); color: var(--text-muted); display: flex; align-items: center; justify-content: center; transition: all 0.2s; text-decoration: none;}
.btn-icon:hover { background: var(--bg-card-hover); color: #fff; }

.pagination-wrap { margin-top: 24px; display: flex; justify-content: center; }
.pagination-wrap nav p { display: none; }

/* ─── Mobile Responsive ─── */
@media (max-width: 768px) {
  .page-header { flex-direction: column; align-items: flex-start; gap: 16px; margin-bottom: 32px; }
  .ph-title { font-size: 22px; }
  .filter-bar { flex-wrap: wrap; gap: 8px; }
  .data-card { padding: 12px; overflow-x: auto; }
  .data-table th:nth-child(3), .data-table td:nth-child(3),
  .data-table th:nth-child(4), .data-table td:nth-child(4) { display: none; }
}

@media (max-width: 480px) {
  .ph-title { font-size: 20px; }
  .btn-primary { padding: 10px 16px; font-size: 12px; }
  .filter-btn { padding: 6px 12px; font-size: 11px; }
  .data-table th:nth-child(5), .data-table td:nth-child(5) { display: none; }
  .event-icon { width: 32px; height: 32px; font-size: 14px; }
  .event-name-text { font-size: 13px; }
}
</style>
@endsection

@section('content')

<div class="page-header">
  <div>
    <h1 class="ph-title">My Events</h1>
    <p class="ph-sub">Manage all your events and workspaces in one place.</p>
  </div>
  <a href="{{ route('events.create') }}" class="btn-primary">
    <i class="fa-solid fa-plus"></i> Create New Event
  </a>
</div>

<div class="filter-bar">
  <button class="filter-btn active">All Events</button>
  <button class="filter-btn">Upcoming</button>
  <button class="filter-btn">Past</button>
  <button class="filter-btn">Drafts</button>
</div>

<div class="data-card">
  <table class="data-table">
    <thead>
      <tr>
        <th>Event Details</th>
        <th>Date</th>
        <th>Venue</th>
        <th>Budget</th>
        <th>Status</th>
        <th style="text-align:right;">Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($events as $e)
      <tr>
        <td>
          <div class="event-name-col">
            <div class="event-icon">
              <i class="fa-solid {{ $e->event_type == 'wedding' ? 'fa-rings-wedding' : ($e->event_type == 'conference' ? 'fa-microphone' : 'fa-calendar-star') }}"></i>
            </div>
            <div>
              <div class="event-name-text">{{ $e->name }}</div>
              <div class="event-type-text">{{ ucfirst($e->event_type ?? 'General Event') }} · Created by {{ $e->creator?->full_name }}</div>
            </div>
          </div>
        </td>
        <td style="color:var(--text-muted);">{{ $e->event_date->format('M d, Y') }}</td>
        <td>{{ $e->venue ?? 'TBD' }}</td>
        <td style="font-weight:500;">${{ number_format($e->target_budget) }}</td>
        <td>
          <span class="status-pill {{ $e->is_active ? 'pill-active' : 'pill-inactive' }}">
            {{ $e->is_active ? 'Active' : 'Archived' }}
          </span>
        </td>
        <td>
          <div class="action-btns" style="justify-content:flex-end;">
            <a href="{{ route('events.show', $e) }}" class="btn-icon" title="View Workspace"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
            <a href="{{ route('events.edit', $e) }}" class="btn-icon" title="Edit Details"><i class="fa-solid fa-pen"></i></a>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="6" style="text-align:center; padding: 60px 20px;">
          <div style="width:64px; height:64px; border-radius:50%; background:rgba(255,255,255,0.02); display:flex; align-items:center; justify-content:center; margin: 0 auto 16px;">
            <i class="fa-regular fa-calendar-xmark" style="font-size:24px; color:var(--text-faint);"></i>
          </div>
          <div style="font-size:15px; font-weight:500; color:#fff; margin-bottom:8px;">No events found</div>
          <div style="font-size:13px; color:var(--text-muted); margin-bottom:24px;">Get started by creating your first event workspace.</div>
          <a href="{{ route('events.create') }}" class="btn-primary" style="display:inline-flex;">Create Event</a>
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
  
  @if($events->hasPages())
  <div class="pagination-wrap">{{ $events->links() }}</div>
  @endif
</div>

@endsection
