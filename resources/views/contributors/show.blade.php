@extends('layouts.app')
@section('title', 'Contributor Profile')

@section('extra_css')
<style>
.page-header { margin-bottom: 32px; display: flex; align-items: center; justify-content: space-between; }
.ph-left { display: flex; align-items: center; gap: 16px; }
.btn-back { width: 36px; height: 36px; border-radius: 10px; background: rgba(255,255,255,0.03); border: 1px solid var(--border); color: var(--text-muted); display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s; }
.btn-back:hover { background: var(--bg-card-hover); color: #fff; }
.ph-title { font-size: 24px; font-weight: 700; color: #fff; letter-spacing: -0.5px; }

.btn-primary { background: linear-gradient(90deg, #A855F7, #D946EF); color: #fff; padding: 10px 20px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 14px rgba(139, 92, 246, 0.25); transition: transform 0.2s; width: fit-content; }
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(139, 92, 246, 0.35); }

.profile-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 16px; padding: 32px; text-align: center; margin-bottom: 24px; }
.pc-avatar { width: 96px; height: 96px; border-radius: 50%; object-fit: cover; margin: 0 auto 16px; border: 4px solid rgba(255,255,255,0.05); }
.pc-name { font-size: 20px; font-weight: 700; color: #fff; margin-bottom: 4px; }
.pc-contact { font-size: 14px; color: var(--text-muted); display: flex; justify-content: center; gap: 16px; margin-bottom: 24px; }
.pc-contact span { display: flex; align-items: center; gap: 6px; }

.stats-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; margin-top: 24px; border-top: 1px solid var(--border); padding-top: 24px; }
.stat-box { display: flex; flex-direction: column; align-items: center; }
.stat-value { font-size: 24px; font-weight: 700; color: #fff; margin-bottom: 4px; }
.stat-label { font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-muted); font-weight: 500; }

.data-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 16px; padding: 24px; }
.dc-title { font-size: 16px; font-weight: 600; color: #fff; margin-bottom: 16px; }
.data-table { width: 100%; border-collapse: collapse; }
.data-table th { text-align: left; font-size: 11px; font-weight: 500; color: var(--text-muted); padding-bottom: 16px; border-bottom: 1px solid var(--border); text-transform: uppercase; letter-spacing: 0.5px; }
.data-table td { padding: 16px 0; border-bottom: 1px solid rgba(255,255,255,0.03); font-size: 13px; color: var(--text-main); }
.data-table tr:last-child td { border-bottom: none; }

/* ─── Mobile Responsive ─── */
@media (max-width: 768px) {
  .page-header { flex-direction: column; align-items: flex-start; gap: 16px; }
  .ph-title { font-size: 20px; }
  .profile-card { padding: 24px 16px; }
  .pc-avatar { width: 72px; height: 72px; }
  .pc-name { font-size: 18px; }
  .pc-contact { flex-direction: column; gap: 8px; }
  .data-card { padding: 16px; overflow-x: auto; }
}

@media (max-width: 480px) {
  .ph-title { font-size: 18px; }
  .btn-primary { padding: 10px 16px; font-size: 12px; }
  .stats-grid { grid-template-columns: 1fr 1fr; gap: 12px; }
  .stat-value { font-size: 20px; }
}
</style>
@endsection

@section('content')

<div class="page-header">
  <div class="ph-left">
    <a href="{{ route('contributors.index') }}" class="btn-back"><i class="fa-solid fa-arrow-left"></i></a>
    <h1 class="ph-title">Contributor Profile</h1>
  </div>
  <a href="{{ route('contributors.edit', $contributor) }}" class="btn-primary">
    <i class="fa-solid fa-pen"></i> Edit Profile
  </a>
</div>

<div style="max-width: 800px;">
  <div class="profile-card">
    <img src="https://ui-avatars.com/api/?name={{ urlencode($contributor->full_name) }}&background=8B5CF6&color=fff" class="pc-avatar" alt="User">
    <div class="pc-name">{{ $contributor->full_name }}</div>
    <div class="pc-contact">
      @if($contributor->phone)
      <span><i class="fa-solid fa-phone" style="font-size:12px; color:var(--brand-purple);"></i> {{ $contributor->phone }}</span>
      @endif
      @if($contributor->email)
      <span><i class="fa-solid fa-envelope" style="font-size:12px; color:var(--brand-magenta);"></i> {{ $contributor->email }}</span>
      @endif
    </div>

    <div class="stats-grid">
      <div class="stat-box">
        <div class="stat-value" style="color:var(--status-green);">${{ number_format($contributor->contributions->where('status','confirmed')->sum('amount')) }}</div>
        <div class="stat-label">Total Contributed</div>
      </div>
      <div class="stat-box">
        <div class="stat-value">{{ $contributor->contributions->count() }}</div>
        <div class="stat-label">Contributions</div>
      </div>
    </div>
  </div>

  <div class="data-card">
    <div class="dc-title">Contribution History</div>
    <table class="data-table">
      <thead>
        <tr>
          <th>Date</th>
          <th>Event</th>
          <th>Amount</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        @forelse($contributions as $contribution)
        <tr>
          <td>{{ $contribution->created_at->format('M d, Y') }}</td>
          <td>{{ $contribution->event?->name ?? 'General' }}</td>
          <td style="font-weight:600; color:#fff;">${{ number_format($contribution->amount) }}</td>
          <td>
            @if($contribution->status == 'confirmed')
              <span style="color:var(--status-green);"><i class="fa-solid fa-circle-check"></i> Confirmed</span>
            @elseif($contribution->status == 'pending')
              <span style="color:var(--status-orange);"><i class="fa-solid fa-clock"></i> Pending</span>
            @else
              <span style="color:var(--status-red);"><i class="fa-solid fa-circle-xmark"></i> Rejected</span>
            @endif
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="4" style="text-align:center; padding: 32px 0; color:var(--text-muted);">
            No contributions recorded for this person yet.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection
