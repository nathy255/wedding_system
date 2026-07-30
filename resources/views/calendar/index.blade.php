@extends('layouts.app')
@section('title', 'Calendar')

@section('extra_css')
<style>
.page-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px; }
.ph-title { font-size: 28px; font-weight: 800; color: #fff; letter-spacing: -0.5px; margin-bottom: 6px; }
.ph-sub { color: var(--text-muted); font-size: 14px; }

.btn-primary { background: linear-gradient(90deg, #A855F7, #D946EF); color: #fff; padding: 10px 20px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px; border: none; cursor: pointer; box-shadow: 0 4px 14px rgba(139,92,246,0.25); transition: transform 0.2s; width: fit-content; }
.btn-primary:hover { transform: translateY(-2px); }

.calendar-layout { display: grid; grid-template-columns: 1fr 320px; gap: 24px; }

/* Calendar Grid */
.calendar-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 20px; padding: 24px; }
.cal-nav { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
.cal-month { font-size: 20px; font-weight: 700; color: #fff; }
.cal-arrows { display: flex; gap: 8px; }
.cal-btn { width: 36px; height: 36px; border-radius: 8px; background: rgba(255,255,255,0.03); border: 1px solid var(--border); color: var(--text-muted); display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; }
.cal-btn:hover { background: rgba(255,255,255,0.08); color: #fff; }

.cal-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 4px; }
.cal-day-header { text-align: center; font-size: 11px; font-weight: 600; color: var(--text-faint); text-transform: uppercase; letter-spacing: 0.5px; padding: 8px 0 16px; }
.cal-day { min-height: 80px; border-radius: 10px; padding: 8px; cursor: pointer; transition: background 0.15s; position: relative; }
.cal-day:hover { background: rgba(255,255,255,0.03); }
.cal-day.today { background: rgba(139, 92, 246, 0.08); }
.cal-day.today .day-num { background: linear-gradient(135deg, #A855F7, #D946EF); color: #fff; border-radius: 50%; }
.cal-day.other-month .day-num { color: var(--text-faint); }

.day-num { width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 500; color: #fff; margin-bottom: 4px; }
.day-event { background: linear-gradient(90deg, rgba(139,92,246,0.3), rgba(217,70,239,0.3)); border-left: 2px solid #A855F7; border-radius: 4px; font-size: 10px; font-weight: 600; color: #C4B5FD; padding: 2px 6px; margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.day-event.event-green { background: rgba(16,185,129,0.15); border-color: #10B981; color: #6EE7B7; }
.day-event.event-blue { background: rgba(59,130,246,0.15); border-color: #3B82F6; color: #93C5FD; }

/* Upcoming Events Sidebar */
.sidebar-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 20px; padding: 24px; }
.sc-title { font-size: 16px; font-weight: 700; color: #fff; margin-bottom: 20px; }

.upcoming-event { display: flex; gap: 16px; padding: 16px; border-radius: 12px; margin-bottom: 12px; background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.04); transition: transform 0.2s; cursor: pointer; }
.upcoming-event:hover { transform: translateX(4px); background: rgba(255,255,255,0.04); }
.ue-date { display: flex; flex-direction: column; align-items: center; background: rgba(139,92,246,0.1); border: 1px solid rgba(139,92,246,0.2); border-radius: 10px; padding: 8px 12px; min-width: 48px; }
.ue-day { font-size: 20px; font-weight: 800; color: #fff; line-height: 1; }
.ue-mon { font-size: 10px; font-weight: 600; color: var(--brand-purple); text-transform: uppercase; letter-spacing: 0.5px; }
.ue-info { flex: 1; }
.ue-name { font-size: 14px; font-weight: 600; color: #fff; margin-bottom: 4px; }
.ue-meta { font-size: 12px; color: var(--text-muted); display: flex; align-items: center; gap: 6px; }
.ue-dot { width: 6px; height: 6px; border-radius: 50%; background: #10B981; }

@media(max-width: 1024px) { .calendar-layout { grid-template-columns: 1fr; } }
@media (max-width: 768px) {
  .page-header { flex-direction: column; align-items: flex-start; gap: 16px; margin-bottom: 32px; }
  .ph-title { font-size: 22px; }
}
</style>
@endsection

@section('content')

<div class="page-header">
  <div>
    <h1 class="ph-title">Event Calendar</h1>
    <p class="ph-sub">Visualize your event timeline and planning milestones at a glance.</p>
  </div>
  <a href="{{ route('events.create') }}" class="btn-primary">
    <i class="fa-solid fa-plus"></i> Schedule Event
  </a>
</div>

<div class="calendar-layout">
  
  <!-- Main Calendar -->
  <div class="calendar-card">
    <div class="cal-nav">
      <div class="cal-month" id="cal-month-label">October 2026</div>
      <div class="cal-arrows">
        <button class="cal-btn" onclick="changeMonth(-1)"><i class="fa-solid fa-chevron-left"></i></button>
        <button class="cal-btn" onclick="changeMonth(1)"><i class="fa-solid fa-chevron-right"></i></button>
      </div>
    </div>
    <div class="cal-grid" id="cal-grid"></div>
  </div>

  <!-- Upcoming Sidebar -->
  <div>
    <div class="sidebar-card">
      <div class="sc-title">Upcoming Events</div>

      @php
        $upcoming = \App\Models\Event::where('event_date', '>=', now())->orderBy('event_date')->take(4)->get();
      @endphp

      @forelse($upcoming as $ev)
      <div class="upcoming-event">
        <div class="ue-date">
          <div class="ue-day">{{ \Carbon\Carbon::parse($ev->event_date)->format('d') }}</div>
          <div class="ue-mon">{{ \Carbon\Carbon::parse($ev->event_date)->format('M') }}</div>
        </div>
        <div class="ue-info">
          <div class="ue-name">{{ $ev->name }}</div>
          <div class="ue-meta">
            <span class="ue-dot"></span>
            {{ $ev->type ?? 'Event' }} &bull; {{ $ev->location ?? 'TBA' }}
          </div>
        </div>
      </div>
      @empty
      <div class="upcoming-event">
        <div class="ue-date">
          <div class="ue-day">15</div>
          <div class="ue-mon">Oct</div>
        </div>
        <div class="ue-info">
          <div class="ue-name">Grand Tech Summit 2026</div>
          <div class="ue-meta"><span class="ue-dot"></span> Conference · Dar es Salaam</div>
        </div>
      </div>
      <div class="upcoming-event">
        <div class="ue-date" style="background:rgba(16,185,129,0.1); border-color:rgba(16,185,129,0.2);">
          <div class="ue-day">22</div>
          <div class="ue-mon" style="color:#10B981;">Oct</div>
        </div>
        <div class="ue-info">
          <div class="ue-name">Sarah & James Wedding</div>
          <div class="ue-meta"><span class="ue-dot" style="background:#A855F7;"></span> Wedding · Zanzibar</div>
        </div>
      </div>
      @endforelse
    </div>
  </div>

</div>

@endsection

@section('scripts')
<script>
const months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
const days = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];

let current = new Date();

// Real events from the database
const events = @json($events);

function changeMonth(dir) {
  current.setMonth(current.getMonth() + dir);
  renderCalendar();
}

function renderCalendar() {
  const year = current.getFullYear();
  const month = current.getMonth();
  document.getElementById('cal-month-label').textContent = months[month] + ' ' + year;

  const grid = document.getElementById('cal-grid');
  grid.innerHTML = '';

  // Day headers
  days.forEach(d => {
    const el = document.createElement('div');
    el.className = 'cal-day-header';
    el.textContent = d;
    grid.appendChild(el);
  });

  const firstDay = new Date(year, month, 1).getDay();
  const daysInMonth = new Date(year, month + 1, 0).getDate();
  const daysInPrev = new Date(year, month, 0).getDate();
  const today = new Date();

  // Prev month padding
  for (let i = firstDay - 1; i >= 0; i--) {
    const el = document.createElement('div');
    el.className = 'cal-day other-month';
    el.innerHTML = `<div class="day-num">${daysInPrev - i}</div>`;
    grid.appendChild(el);
  }

  // Current month
  for (let d = 1; d <= daysInMonth; d++) {
    const el = document.createElement('div');
    const isToday = d === today.getDate() && month === today.getMonth() && year === today.getFullYear();
    el.className = 'cal-day' + (isToday ? ' today' : '');
    
    const dateKey = `${year}-${String(month+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
    const dayEvents = events[dateKey] || [];
    
    let html = `<div class="day-num">${d}</div>`;
    dayEvents.forEach(ev => {
      html += `<div class="day-event${ev.type === 'green' ? ' event-green' : ev.type === 'blue' ? ' event-blue' : ''}">${ev.label}</div>`;
    });
    
    el.innerHTML = html;
    grid.appendChild(el);
  }
}

renderCalendar();
</script>
@endsection
