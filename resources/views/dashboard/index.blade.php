@extends('layouts.app')
@section('title', 'Dashboard')

@section('extra_css')
<style>
/* ─── Welcome Banner ─── */
.welcome-banner {
  background: linear-gradient(135deg, rgba(139,92,246,0.12), rgba(217,70,239,0.06));
  border: 1px solid rgba(139,92,246,0.2);
  border-radius: 20px; padding: 28px 32px;
  display: flex; justify-content: space-between; align-items: center;
  margin-bottom: 32px; position: relative; overflow: hidden;
}
.welcome-banner::before {
  content: ''; position: absolute; top: -50%; right: -5%;
  width: 300px; height: 300px; border-radius: 50%;
  background: radial-gradient(circle, rgba(217,70,239,0.1), transparent 70%);
}
.wb-title { font-size: 24px; font-weight: 800; color: #fff; margin-bottom: 6px; letter-spacing: -0.5px; }
.wb-sub { font-size: 14px; color: var(--text-muted); }
.btn-primary { background: linear-gradient(90deg, #A855F7, #D946EF); color: #fff; padding: 12px 24px; border-radius: 10px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px; border: none; cursor: pointer; box-shadow: 0 4px 16px rgba(139,92,246,0.3); transition: transform 0.2s, box-shadow 0.2s; white-space: nowrap; width: fit-content; }
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(139,92,246,0.4); }

/* ─── KPI Grid ─── */
.kpi-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
.kpi-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 16px; padding: 24px; position: relative; overflow: hidden; transition: transform 0.2s, border-color 0.2s; }
.kpi-card:hover { transform: translateY(-3px); border-color: rgba(255,255,255,0.1); }
.kpi-label { font-size: 12px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; font-weight: 500; margin-bottom: 10px; }
.kpi-value { font-size: 32px; font-weight: 800; color: #fff; letter-spacing: -1px; margin-bottom: 6px; }
.kpi-delta { font-size: 12px; font-weight: 600; display: flex; align-items: center; gap: 4px; }
.delta-up { color: var(--status-green); }
.delta-down { color: var(--status-red); }
.kpi-icon { position: absolute; top: 20px; right: 20px; font-size: 24px; opacity: 0.15; }

/* ─── Main Grid ─── */
.main-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 24px; margin-bottom: 24px; }

/* ─── Activity Feed ─── */
.section-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 20px; padding: 24px; }
.sc-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
.sc-title { font-size: 16px; font-weight: 700; color: #fff; }
.sc-link { font-size: 12px; color: var(--brand-purple); text-decoration: none; font-weight: 600; }
.sc-link:hover { text-decoration: underline; }

.activity-table { width: 100%; border-collapse: collapse; }
.activity-table th { text-align: left; font-size: 11px; font-weight: 500; color: var(--text-muted); padding-bottom: 12px; border-bottom: 1px solid var(--border); text-transform: uppercase; letter-spacing: 0.5px; }
.activity-table td { padding: 14px 0; border-bottom: 1px solid rgba(255,255,255,0.03); font-size: 13px; color: var(--text-main); vertical-align: middle; }
.activity-table tr:last-child td { border-bottom: none; }
.payer-info { display: flex; align-items: center; gap: 10px; }
.payer-avatar { width: 32px; height: 32px; border-radius: 50%; flex-shrink: 0; }
.payer-name { font-weight: 600; color: #fff; font-size: 13px; }
.payer-event { font-size: 11px; color: var(--text-muted); }
.amount-cell { font-weight: 700; color: #fff; }
.status-pill { display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; border-radius: 99px; font-size: 11px; font-weight: 600; }
.sp-confirmed { background: rgba(16,185,129,0.12); color: #10B981; }
.sp-pending { background: rgba(245,158,11,0.12); color: #F59E0B; }

/* ─── Upcoming Events Sidebar ─── */
.upcoming-item { display: flex; gap: 14px; padding: 14px; border-radius: 12px; background: rgba(255,255,255,0.02); margin-bottom: 10px; border: 1px solid rgba(255,255,255,0.03); cursor: pointer; text-decoration: none; transition: transform 0.15s, background 0.15s; }
.upcoming-item:hover { transform: translateX(4px); background: rgba(255,255,255,0.04); }
.ui-date { min-width: 44px; display: flex; flex-direction: column; align-items: center; padding: 8px; background: rgba(139,92,246,0.1); border-radius: 10px; }
.ui-day { font-size: 20px; font-weight: 800; color: #fff; line-height: 1; }
.ui-mon { font-size: 10px; color: var(--brand-purple); font-weight: 600; letter-spacing: 0.5px; }
.ui-name { font-size: 13px; font-weight: 600; color: #fff; margin-bottom: 3px; }
.ui-type { font-size: 11px; color: var(--text-muted); }

/* ─── Vendor Showcase ─── */
.vendor-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
.vendor-mini { border-radius: 14px; overflow: hidden; text-decoration: none; transition: transform 0.2s; }
.vendor-mini:hover { transform: translateY(-4px); }
.vm-img { width: 100%; height: 120px; object-fit: cover; }
.vm-info { padding: 12px; background: var(--bg-card); border: 1px solid var(--border); border-top: none; border-radius: 0 0 14px 14px; }
.vm-name { font-size: 13px; font-weight: 600; color: #fff; margin-bottom: 2px; }
.vm-cat { font-size: 11px; color: var(--text-muted); }
.vm-price { font-size: 12px; font-weight: 600; color: var(--brand-purple); margin-top: 6px; }

@media(max-width: 1100px) { .kpi-grid { grid-template-columns: repeat(2, 1fr); } }
@media(max-width: 900px) { .main-grid { grid-template-columns: 1fr; } }
@media(max-width: 768px) {
  .welcome-banner {
    flex-direction: column;
    align-items: flex-start;
    gap: 16px;
    padding: 24px;
    margin-bottom: 32px;
  }
  .welcome-banner .btn-primary {
    align-self: flex-start;
  }
}
@media(max-width: 600px) { .vendor-row { grid-template-columns: 1fr; } .kpi-grid { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')

{{-- Welcome Banner --}}
<div class="welcome-banner">
  <div>
    <div class="wb-title">Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 18 ? 'afternoon' : 'evening') }}, {{ explode(' ', auth()->user()->full_name)[0] }} 👋</div>
    <div class="wb-sub">
      @if($event)
        Your active event: <strong style="color:#fff;">{{ $event->name }}</strong>
        @if($stats['days_to_go'] > 0) — <span style="color:var(--brand-magenta);">{{ $stats['days_to_go'] }} days to go!</span>@endif
      @else
        Welcome to EVENTA. Create your first event to get started.
      @endif
    </div>
  </div>
  <a href="{{ route('events.create') }}" class="btn-primary">
    <i class="fa-solid fa-plus"></i> New Event
  </a>
</div>

{{-- KPI Cards --}}
<div class="kpi-grid">
  @if(auth()->user()->isVendor())
    <div class="kpi-card">
      <div class="kpi-label">Available Leads</div>
      <div class="kpi-value" style="background: linear-gradient(135deg,#8B5CF6,#D946EF); -webkit-background-clip:text; -webkit-text-fill-color:transparent;">{{ $stats['total_events'] }}</div>
      <div class="kpi-delta delta-up"><i class="fa-solid fa-arrow-trend-up" style="font-size:10px;"></i> Public events</div>
      <div class="kpi-icon" style="color:#A855F7;"><i class="fa-solid fa-briefcase"></i></div>
    </div>
    <div class="kpi-card">
      <div class="kpi-label">Profile Views</div>
      <div class="kpi-value">{{ $stats['total_vendors'] }}</div>
      <div class="kpi-delta delta-up"><i class="fa-solid fa-eye" style="font-size:10px;"></i> Last 30 days</div>
      <div class="kpi-icon" style="color:#10B981;"><i class="fa-solid fa-chart-line"></i></div>
    </div>
    <div class="kpi-card">
      <div class="kpi-label">Pending Proposals</div>
      <div class="kpi-value">{{ $stats['total_gifts'] }}</div>
      <div class="kpi-delta" style="color:#F59E0B;"><i class="fa-solid fa-clock" style="font-size:10px;"></i> Awaiting response</div>
      <div class="kpi-icon" style="color:#F59E0B;"><i class="fa-solid fa-file-signature"></i></div>
    </div>
    <div class="kpi-card">
      <div class="kpi-label">Profile Completion</div>
      <div class="kpi-value">{{ number_format($stats['progress_percent']) }}%</div>
      <div class="kpi-delta" style="color:var(--text-muted);">Add more portfolio items</div>
      <div class="kpi-icon" style="color:#3B82F6;"><i class="fa-solid fa-star"></i></div>
    </div>
  @else
    <div class="kpi-card">
      <div class="kpi-label">Total Collected</div>
      <div class="kpi-value" style="background: linear-gradient(135deg,#10B981,#059669); -webkit-background-clip:text; -webkit-text-fill-color:transparent;">${{ number_format($stats['total_confirmed']) }}</div>
      <div class="kpi-delta delta-up"><i class="fa-solid fa-arrow-trend-up" style="font-size:10px;"></i> Confirmed funds</div>
      <div class="kpi-icon" style="color:#10B981;"><i class="fa-solid fa-sack-dollar"></i></div>
    </div>

    <div class="kpi-card">
      <div class="kpi-label">Pending Escrow</div>
      <div class="kpi-value" style="background: linear-gradient(135deg,#F59E0B,#D97706); -webkit-background-clip:text; -webkit-text-fill-color:transparent;">${{ number_format($stats['total_pending']) }}</div>
      <div class="kpi-delta" style="color:#F59E0B;"><i class="fa-solid fa-clock" style="font-size:10px;"></i> Awaiting clearance</div>
      <div class="kpi-icon" style="color:#F59E0B;"><i class="fa-solid fa-vault"></i></div>
    </div>

    <div class="kpi-card">
      <div class="kpi-label">Total Guests</div>
      <div class="kpi-value">{{ number_format($stats['total_guests']) }}</div>
      <div class="kpi-delta delta-up"><i class="fa-solid fa-arrow-trend-up" style="font-size:10px;"></i> Contributors added</div>
      <div class="kpi-icon" style="color:#A855F7;"><i class="fa-solid fa-users"></i></div>
    </div>

    <div class="kpi-card">
      <div class="kpi-label">Active Events</div>
      <div class="kpi-value">{{ $stats['total_events'] }}</div>
      <div class="kpi-delta" style="color:var(--text-muted);">{{ $stats['total_vendors'] }} vendors on platform</div>
      <div class="kpi-icon" style="color:#D946EF;"><i class="fa-regular fa-calendar-check"></i></div>
    </div>
  @endif
</div>

{{-- Main Content Grid --}}
<div class="main-grid">

  {{-- Recent Transactions --}}
  <div class="section-card">
    <div class="sc-header">
      <div class="sc-title">Recent Transactions</div>
      <a href="{{ route('contributions.index') }}" class="sc-link">View All <i class="fa-solid fa-arrow-right" style="font-size:10px;"></i></a>
    </div>
    <table class="activity-table">
      <thead>
        <tr>
          <th>Payer</th>
          <th>Method</th>
          <th>Amount</th>
          <th>Status</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        @forelse($recent_contributions as $c)
        <tr>
          <td>
            <div class="payer-info">
              <img src="https://ui-avatars.com/api/?name={{ urlencode($c->contributor_name ?? 'Guest') }}&background=8B5CF6&color=fff&size=64" class="payer-avatar" alt="avatar">
              <div>
                <div class="payer-name">{{ $c->contributor_name ?? 'Anonymous' }}</div>
                <div class="payer-event">{{ $c->event?->name ?? 'General' }}</div>
              </div>
            </div>
          </td>
          <td>
            @php $m = strtolower($c->payment_method ?? ''); @endphp
            @if($m == 'mpesa') <span style="color:#10B981;"><i class="fa-solid fa-mobile-screen"></i> M-Pesa</span>
            @elseif($m == 'card') <span style="color:#3B82F6;"><i class="fa-regular fa-credit-card"></i> Card</span>
            @else <span style="color:var(--text-muted);"><i class="fa-solid fa-money-bill"></i> {{ ucfirst($m ?: 'Cash') }}</span>
            @endif
          </td>
          <td class="amount-cell">${{ number_format($c->amount) }}</td>
          <td>
            <span class="status-pill {{ $c->status === 'confirmed' ? 'sp-confirmed' : 'sp-pending' }}">
              {{ ucfirst($c->status) }}
            </span>
          </td>
          <td style="color:var(--text-muted); font-size:12px;">{{ $c->created_at->format('M d') }}</td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center; padding:32px 0; color:var(--text-muted);">No transactions yet. <a href="{{ route('contributions.create') }}" style="color:var(--brand-purple);">Record the first payment →</a></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Upcoming Events --}}
  <div>
    <div class="section-card">
      <div class="sc-header">
        <div class="sc-title">Upcoming Events</div>
        <a href="{{ route('calendar.index') }}" class="sc-link">Calendar <i class="fa-solid fa-arrow-right" style="font-size:10px;"></i></a>
      </div>
      @forelse($upcoming_events as $ev)
      <a href="{{ route('events.show', $ev) }}" class="upcoming-item">
        <div class="ui-date">
          <div class="ui-day">{{ \Carbon\Carbon::parse($ev->event_date)->format('d') }}</div>
          <div class="ui-mon">{{ \Carbon\Carbon::parse($ev->event_date)->format('M') }}</div>
        </div>
        <div>
          <div class="ui-name">{{ $ev->name }}</div>
          <div class="ui-type"><i class="fa-solid fa-location-dot" style="font-size:10px; margin-right:4px;"></i>{{ $ev->location ?? 'Location TBA' }}</div>
        </div>
      </a>
      @empty
      <div style="text-align:center; padding:20px 0; color:var(--text-muted);">
        <i class="fa-regular fa-calendar" style="font-size:32px; opacity:0.3; margin-bottom:12px; display:block;"></i>
        No upcoming events scheduled.
        <br><a href="{{ route('events.create') }}" style="color:var(--brand-purple); font-size:13px; font-weight:600;">Create one →</a>
      </div>
      @endforelse
    </div>
  </div>

</div>

{{-- Vendor Showcase --}}
@if($top_vendors->count() > 0)
<div class="section-card">
  <div class="sc-header">
    <div class="sc-title">Top Vendors on Marketplace</div>
    <a href="{{ route('vendors.index') }}" class="sc-link">Explore All <i class="fa-solid fa-arrow-right" style="font-size:10px;"></i></a>
  </div>
  <div class="vendor-row">
    @foreach($top_vendors as $v)
    <a href="{{ route('vendors.show', $v) }}" class="vendor-mini">
      <img src="{{ $v->cover_image }}" class="vm-img" alt="{{ $v->name }}">
      <div class="vm-info">
        <div class="vm-name">{{ $v->name }}</div>
        <div class="vm-cat">{{ $v->category }} · <i class="fa-solid fa-star" style="color:#F59E0B; font-size:10px;"></i> {{ $v->rating }}</div>
        <div class="vm-price">From ${{ number_format($v->starting_price) }}</div>
      </div>
    </a>
    @endforeach
  </div>
</div>
@endif

@endsection
