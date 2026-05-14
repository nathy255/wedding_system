@extends('layouts.app')

@section('title', 'Dashboard')
@section('heading', 'Good morning, ' . auth()->user()->full_name . ' ✦')
@section('subheading', now()->format('l, F j, Y') . ($event ? ' · ' . $event->couple_name . '\'s Wedding' : ''))

@section('topbar_actions')
  <a href="{{ route('contributions.create') }}" class="btn btn-primary">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Add Contribution
  </a>
@endsection

@section('content')

{{-- Progress Banner --}}
@if($event)
<div style="background:#fff;border:1px solid var(--border);border-radius:16px;padding:24px 28px;margin-bottom:28px;display:flex;align-items:center;gap:32px;">
  <div style="flex:1;">
    <div style="font-size:12px;font-weight:500;letter-spacing:1.5px;text-transform:uppercase;color:var(--ink-faint);margin-bottom:6px;">Total Collected</div>
    <div style="font-family:'Cormorant Garamond',serif;font-size:38px;font-weight:600;line-height:1;">
      TZS {{ number_format($stats['total_confirmed']) }}
      <span style="font-size:18px;color:var(--ink-faint);font-weight:400;">/ {{ number_format($event->target_budget) }}</span>
    </div>
    <div style="margin-top:14px;height:8px;background:var(--rose-pale);border-radius:99px;overflow:hidden;">
      <div style="height:100%;width:{{ $stats['progress_percent'] }}%;background:linear-gradient(90deg,var(--rose),var(--gold-light));border-radius:99px;transition:width 1s ease;"></div>
    </div>
    <div style="display:flex;justify-content:space-between;margin-top:8px;font-size:12px;color:var(--ink-faint);">
      <span><strong style="color:var(--rose);">{{ $stats['progress_percent'] }}%</strong> of target reached</span>
      <span>TZS {{ number_format($event->target_budget - $stats['total_confirmed']) }} remaining</span>
    </div>
  </div>
  <div style="width:1px;background:var(--border);align-self:stretch;"></div>
  <div style="display:flex;gap:28px;">
    @foreach([['Days to Go', $stats['days_to_go']], ['Contributors', $stats['total_contributors']], ['Gifts', $stats['total_gifts']]] as [$lbl, $val])
    <div style="text-align:center;">
      <div style="font-family:'Cormorant Garamond',serif;font-size:30px;font-weight:600;color:var(--ink);">{{ $val }}</div>
      <div style="font-size:11px;color:var(--ink-faint);margin-top:2px;white-space:nowrap;">{{ $lbl }}</div>
    </div>
    @if(!$loop->last)<div style="width:1px;background:var(--border);align-self:stretch;"></div>@endif
    @endforeach
  </div>
</div>
@endif

{{-- Stats Grid --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:28px;">
  @php
  $cards = [
    ['Cash Collected (TZS)', number_format($stats['total_confirmed']), 'rose', '↑ Today', 'M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6'],
    ['Pending Amount (TZS)', number_format($stats['total_pending']), 'gold', 'Pending', 'M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6'],
    ['Gifts Registered', $stats['total_gifts'], 'green', 'Total', 'M20 12v10H4V12M22 7H2v5h20V7zM12 22V7'],
    ['Receipts Sent', $stats['receipts_sent'], 'blue', 'Auto', 'M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2zM22 6l-10 7L2 6'],
  ];
  $topColors = ['rose'=>'linear-gradient(90deg,var(--rose),var(--rose-light))', 'gold'=>'linear-gradient(90deg,var(--gold),var(--gold-light))', 'green'=>'linear-gradient(90deg,var(--green),#4CAF82)', 'blue'=>'linear-gradient(90deg,var(--blue),#3A7AC8)'];
  $bgColors = ['rose'=>'var(--rose-pale)','gold'=>'var(--gold-pale)','green'=>'var(--green-pale)','blue'=>'var(--blue-pale)'];
  $txtColors= ['rose'=>'var(--rose)','gold'=>'var(--gold)','green'=>'var(--green)','blue'=>'var(--blue)'];
  @endphp

  @foreach($cards as [$label, $val, $color, $badge, $icon])
  <div style="background:#fff;border:1px solid var(--border);border-radius:14px;padding:20px 22px;position:relative;overflow:hidden;">
    <div style="position:absolute;top:0;left:0;right:0;height:3px;background:{{ $topColors[$color] }};"></div>
    <div style="width:36px;height:36px;border-radius:8px;background:{{ $bgColors[$color] }};color:{{ $txtColors[$color] }};display:flex;align-items:center;justify-content:center;margin-bottom:14px;">
      <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="{{ $icon }}"/></svg>
    </div>
    <div style="position:absolute;top:18px;right:18px;font-size:11px;font-weight:500;padding:3px 8px;border-radius:99px;background:{{ $bgColors[$color] }};color:{{ $txtColors[$color] }};">{{ $badge }}</div>
    <div style="font-family:'Cormorant Garamond',serif;font-size:30px;font-weight:600;line-height:1;">{{ $val }}</div>
    <div style="font-size:12px;color:var(--ink-faint);margin-top:4px;">{{ $label }}</div>
  </div>
  @endforeach
</div>

{{-- Two Column --}}
<div style="display:grid;grid-template-columns:1fr 340px;gap:20px;">

  {{-- Contributions Table --}}
  <div class="table-card">
    <div class="table-header">
      <div class="table-title">Recent Contributions</div>
      <a href="{{ route('contributions.index') }}" class="btn btn-outline btn-sm" style="font-size:12px;padding:6px 14px;">View all →</a>
    </div>
    <table>
      <thead>
        <tr>
          <th>Contributor</th>
          <th>Type</th>
          <th>Amount</th>
          <th>Date</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @forelse($recent_contributions as $c)
        <tr>
          <td>
            <div class="donor-cell">
              <div class="d-avatar" style="background:{{ ['#8B2A4A','#1A4A7A','#2A6B4A','#8B5E1A','#533499'][$loop->index % 5] }};">
                {{ strtoupper(substr($c->contributor_name ?? 'U', 0, 2)) }}
              </div>
              <div>
                <div class="d-name">{{ $c->contributor_name ?? 'Unknown' }}</div>
                <div class="d-phone">{{ $c->contributor_phone }}</div>
              </div>
            </div>
          </td>
          <td><span class="badge badge-{{ $c->type }}">{{ ucfirst($c->type) }}</span></td>
          <td><span class="amount-cell">{{ $c->type === 'cash' ? number_format($c->amount) : '—' }}</span></td>
          <td style="font-size:12.5px;color:var(--ink-faint);">{{ $c->created_at->format('M d, H:i') }}</td>
          <td><span class="badge badge-{{ $c->status }}">{{ ucfirst($c->status) }}</span></td>
          <td>
            @if($c->status === 'pending')
            <form method="POST" action="{{ route('contributions.confirm', $c) }}" style="display:inline;">
              @csrf @method('PATCH')
              <button type="submit" class="btn btn-green btn-sm" style="font-size:11px;padding:5px 10px;">✓ Confirm</button>
            </form>
            @else
            <a href="{{ route('contributions.show', $c) }}" class="btn btn-outline btn-sm" style="font-size:11px;padding:5px 10px;">View</a>
            @endif
          </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;padding:32px;color:var(--ink-faint);">No contributions yet. <a href="{{ route('contributions.create') }}" style="color:var(--rose);">Add the first one →</a></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Right Sidebar --}}
  <div style="display:flex;flex-direction:column;gap:18px;">

    {{-- Quick Actions --}}
    <div style="background:#fff;border:1px solid var(--border);border-radius:16px;overflow:hidden;">
      <div class="table-header"><div class="table-title">Quick Actions</div></div>
      <div style="padding:14px;display:grid;grid-template-columns:1fr 1fr;gap:10px;">
        @foreach([
          [route('contributions.create'), 'Add Cash', 'M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6'],
          [route('gifts.create'), 'Add Gift', 'M20 12v10H4V12M22 7H2v5h20V7zM12 22V7'],
          [route('contributors.index'), 'Contributors', 'M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6'],
          [route('reports.pdf'), 'Export PDF', 'M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zM14 2v6h6M16 13H8M16 17H8M10 9H8'],
        ] as [$url, $label, $path])
        <a href="{{ $url }}" style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;padding:14px;border-radius:10px;border:1px solid var(--border);background:var(--ivory);text-decoration:none;transition:all 0.15s;" onmouseover="this.style.background='var(--rose-pale)';this.style.borderColor='var(--rose-light)'" onmouseout="this.style.background='var(--ivory)';this.style.borderColor='var(--border)'">
          <svg width="20" height="20" fill="none" stroke="var(--rose)" stroke-width="2" viewBox="0 0 24 24"><path d="{{ $path }}"/></svg>
          <span style="font-size:12px;font-weight:500;color:var(--ink-muted);text-align:center;">{{ $label }}</span>
        </a>
        @endforeach
      </div>
    </div>

    {{-- Recent Gifts --}}
    <div style="background:#fff;border:1px solid var(--border);border-radius:16px;overflow:hidden;">
      <div class="table-header">
        <div class="table-title">Gift Registry</div>
        <a href="{{ route('gifts.index') }}" style="font-size:12px;font-weight:500;color:var(--rose);text-decoration:none;">View all →</a>
      </div>
      <div>
        @forelse($recent_gifts as $gift)
        <div style="display:flex;align-items:center;gap:12px;padding:12px 22px;border-bottom:1px solid var(--border);">
          <div style="width:34px;height:34px;border-radius:8px;background:var(--rose-pale);color:var(--rose);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 12v10H4V12M22 7H2v5h20V7zM12 22V7"/></svg>
          </div>
          <div style="flex:1;min-width:0;">
            <div style="font-size:13.5px;font-weight:500;color:var(--ink);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $gift->item_name }}</div>
            <div style="font-size:11.5px;color:var(--ink-faint);">{{ $gift->donor_name }}</div>
          </div>
          <span class="badge badge-{{ $gift->status }}" style="font-size:11px;">{{ ucfirst($gift->status) }}</span>
        </div>
        @empty
        <div style="padding:24px;text-align:center;color:var(--ink-faint);font-size:13px;">No gifts registered yet.</div>
        @endforelse
      </div>
    </div>

  </div>
</div>

@endsection
