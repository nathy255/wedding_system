@extends('layouts.app')
@section('title','Reports & Analytics')
@section('heading','Reports & Analytics')
@section('subheading','Financial overview for ' . ($event?->couple_name ?? 'current event'))

@section('topbar_actions')
  <a href="{{ route('reports.csv') }}" class="btn btn-outline">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
    Export CSV
  </a>
  <a href="{{ route('reports.pdf') }}" class="btn btn-primary">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
    Export PDF
  </a>
@endsection

@section('content')

@if($event)
{{-- Summary Cards --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:28px;">
  @foreach([
    ['Total Confirmed', 'TZS ' . number_format($event->total_confirmed), 'var(--green)', 'var(--green-pale)'],
    ['Total Pending',   'TZS ' . number_format($event->total_pending),   'var(--amber)', 'var(--amber-pale)'],
    ['Progress',        $event->progress_percent . '% of TZS ' . number_format($event->target_budget), 'var(--rose)', 'var(--rose-pale)'],
  ] as [$label,$val,$color,$bg])
  <div style="background:#fff;border:1px solid var(--border);border-radius:14px;padding:22px;">
    <div style="font-size:12px;letter-spacing:1px;text-transform:uppercase;color:var(--ink-faint);margin-bottom:8px;">{{ $label }}</div>
    <div style="font-family:'Cormorant Garamond',serif;font-size:28px;font-weight:600;color:{{ $color }};">{{ $val }}</div>
  </div>
  @endforeach
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">

  {{-- By Payment Method --}}
  <div class="table-card">
    <div class="table-header"><div class="table-title">By Payment Method</div></div>
    <table>
      <thead><tr><th>Method</th><th>Count</th><th>Total (TZS)</th></tr></thead>
      <tbody>
        @foreach($data['contributions_by_method'] ?? [] as $row)
        <tr>
          <td style="font-weight:500;">{{ ucwords(str_replace('_',' ',$row->payment_method)) }}</td>
          <td>{{ $row->count }}</td>
          <td><span class="amount-cell">{{ number_format($row->total) }}</span></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  {{-- Top Contributors --}}
  <div class="table-card">
    <div class="table-header"><div class="table-title">Top Contributors</div></div>
    <table>
      <thead><tr><th>Name</th><th>Phone</th><th>Total (TZS)</th></tr></thead>
      <tbody>
        @foreach($data['top_contributors'] ?? [] as $i => $row)
        <tr>
          <td>
            <div class="donor-cell">
              <div class="d-avatar" style="background:{{ ['#8B2A4A','#1A4A7A','#2A6B4A','#8B5E1A','#533499'][$i % 5] }};">
                {{ strtoupper(substr($row->contributor_name, 0, 2)) }}
              </div>
              <div class="d-name">{{ $row->contributor_name }}</div>
            </div>
          </td>
          <td style="font-size:12px;color:var(--ink-faint);">{{ $row->contributor_phone }}</td>
          <td><span class="amount-cell">{{ number_format($row->total) }}</span></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

</div>
@else
<div style="text-align:center;padding:60px;color:var(--ink-faint);">
  <div style="font-family:'Cormorant Garamond',serif;font-size:24px;margin-bottom:8px;">No active event</div>
  <p>Create an event first to see reports.</p>
  <a href="{{ route('events.create') }}" class="btn btn-primary" style="margin-top:16px;">Create Event</a>
</div>
@endif

@endsection
