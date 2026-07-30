@extends('layouts.app')
@section('title', 'Budget Tracker & Reports')

@section('extra_css')
<style>
.page-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px; }
.ph-title { font-size: 28px; font-weight: 800; color: #fff; letter-spacing: -0.5px; margin-bottom: 6px; }
.ph-sub { color: var(--text-muted); font-size: 14px; }

.btn-export { background: rgba(255,255,255,0.05); color: #fff; padding: 10px 20px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; border: 1px solid var(--border); transition: all 0.2s; }
.btn-export:hover { background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2); }

.report-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 24px; margin-bottom: 24px; }

.chart-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 20px; padding: 24px; }
.cc-title { font-size: 16px; font-weight: 600; color: #fff; margin-bottom: 24px; display: flex; align-items: center; gap: 8px; }

.stat-item { padding: 16px; border-radius: 12px; background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; transition: transform 0.2s; }
.stat-item:hover { transform: translateX(4px); background: rgba(255,255,255,0.04); }
.si-left { display: flex; align-items: center; gap: 12px; }
.si-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
.si-name { font-size: 14px; font-weight: 600; color: #fff; }
.si-sub { font-size: 12px; color: var(--text-muted); }
.si-value { font-size: 16px; font-weight: 700; color: #fff; text-align: right; }
.si-count { font-size: 11px; color: var(--text-faint); }

.empty-state { text-align: center; padding: 40px 0; color: var(--text-muted); }

/* Payment Method Colors */
.pm-mpesa .si-icon { background: rgba(16, 185, 129, 0.1); color: #10B981; }
.pm-card .si-icon { background: rgba(59, 130, 246, 0.1); color: #3B82F6; }
.pm-cash .si-icon { background: rgba(245, 158, 11, 0.1); color: #F59E0B; }
.pm-bank .si-icon { background: rgba(139, 92, 246, 0.1); color: #8B5CF6; }

/* ─── Mobile Responsive ─── */
@media (max-width: 768px) {
  .page-header { flex-direction: column; align-items: flex-start; gap: 16px; margin-bottom: 32px; }
  .ph-title { font-size: 22px; }
  .report-grid { grid-template-columns: 1fr; }
  .chart-card { padding: 16px; border-radius: 14px; }
}

@media (max-width: 480px) {
  .ph-title { font-size: 20px; }
  .btn-export { padding: 8px 14px; font-size: 12px; }
  .stat-item { padding: 12px; }
  .si-icon { width: 32px; height: 32px; font-size: 14px; }
  .si-name { font-size: 13px; }
  .si-value { font-size: 14px; }
}
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')

<div class="page-header">
  <div>
    <h1 class="ph-title">Budget Tracker & Reports</h1>
    <p class="ph-sub">Comprehensive analytics and financial breakdown for your events.</p>
  </div>
  <div style="display:flex; gap:12px;">
    <a href="{{ route('reports.csv') }}" class="btn-export"><i class="fa-solid fa-file-csv"></i> Export CSV</a>
    <a href="{{ route('reports.pdf') }}" class="btn-export" style="background: linear-gradient(90deg, #3B82F6, #2563EB); border:none;"><i class="fa-solid fa-file-pdf"></i> Download PDF</a>
  </div>
</div>

@if(!$event)
  <div class="chart-card empty-state">
    <i class="fa-solid fa-chart-pie" style="font-size:32px; margin-bottom:16px; opacity:0.5;"></i>
    <div>No active event found. Create an event to view reports.</div>
  </div>
@else

<div class="report-grid">
  <!-- Left Column: Charts -->
  <div style="display:flex; flex-direction:column; gap:24px;">
    <div class="chart-card">
      <div class="cc-title"><i class="fa-solid fa-money-bill-trend-up" style="color:var(--brand-purple);"></i> Contribution Trend</div>
      <canvas id="trendChart" height="100"></canvas>
    </div>
  </div>

  <!-- Right Column: Stats -->
  <div style="display:flex; flex-direction:column; gap:24px;">
    <!-- By Method -->
    <div class="chart-card">
      <div class="cc-title"><i class="fa-solid fa-wallet" style="color:var(--status-green);"></i> Revenue by Method</div>
      @forelse($data['contributions_by_method'] as $method)
        @php
            $pmClass = 'pm-bank';
            $icon = 'fa-building-columns';
            $name = strtolower($method->payment_method);
            if($name == 'mpesa') { $pmClass = 'pm-mpesa'; $icon = 'fa-mobile-screen'; }
            if($name == 'card') { $pmClass = 'pm-card'; $icon = 'fa-credit-card'; }
            if($name == 'cash') { $pmClass = 'pm-cash'; $icon = 'fa-money-bill'; }
        @endphp
        <div class="stat-item {{ $pmClass }}">
          <div class="si-left">
            <div class="si-icon"><i class="fa-solid {{ $icon }}"></i></div>
            <div>
              <div class="si-name">{{ ucfirst($method->payment_method) }}</div>
              <div class="si-sub">{{ $method->count }} transactions</div>
            </div>
          </div>
          <div class="si-value">${{ number_format($method->total) }}</div>
        </div>
      @empty
        <div class="empty-state" style="padding:20px 0;">No data</div>
      @endforelse
    </div>

    <!-- Top Contributors -->
    <div class="chart-card">
      <div class="cc-title"><i class="fa-solid fa-medal" style="color:var(--status-orange);"></i> Top Contributors</div>
      @forelse($data['top_contributors'] as $top)
        <div class="stat-item pm-bank">
          <div class="si-left">
            <div class="si-icon" style="background:rgba(255,255,255,0.05); color:#fff;">
              <i class="fa-solid fa-user"></i>
            </div>
            <div>
              <div class="si-name">{{ $top['name'] }}</div>
              <div class="si-sub">{{ $top['phone'] ?? 'N/A' }}</div>
            </div>
          </div>
          <div class="si-value">${{ number_format($top['total']) }}</div>
        </div>
      @empty
        <div class="empty-state" style="padding:20px 0;">No data</div>
      @endforelse
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('trendChart').getContext('2d');
    
    // Parse data from PHP
    const rawData = @json($data['daily_totals']);
    const labels = rawData.map(item => item.date);
    const totals = rawData.map(item => item.total);

    // Create Gradient
    let gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(139, 92, 246, 0.5)'); // Brand purple
    gradient.addColorStop(1, 'rgba(139, 92, 246, 0.0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Daily Contributions ($)',
                data: totals,
                borderColor: '#8B5CF6',
                backgroundColor: gradient,
                borderWidth: 3,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#8B5CF6',
                pointBorderWidth: 2,
                pointRadius: 4,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    grid: { color: 'rgba(255,255,255,0.05)' },
                    ticks: { color: 'rgba(255,255,255,0.5)' }
                },
                y: {
                    grid: { color: 'rgba(255,255,255,0.05)' },
                    ticks: { color: 'rgba(255,255,255,0.5)' },
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
@endif

@endsection
