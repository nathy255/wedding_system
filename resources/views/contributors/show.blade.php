@extends('layouts.app')
@section('title', 'Contributor Details')
@section('heading', 'Contributor Profile')
@section('subheading', $contributor->full_name)

@section('topbar_actions')
  <a href="{{ route('contributors.index') }}" class="btn btn-outline">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    Back
  </a>
@endsection

@section('content')
<div style="display:grid; grid-template-columns: 300px 1fr; gap: 28px; align-items: start;">
  
  <div style="display:flex; flex-direction:column; gap:24px;">
    <div style="background:#fff; border:1px solid var(--border); border-radius:16px; padding:32px; text-align:center;">
       <div style="width:80px; height:80px; border-radius:50%; background:linear-gradient(135deg, var(--rose), var(--gold)); color:#fff; display:flex; align-items:center; justify-content:center; font-size:32px; font-weight:700; margin: 0 auto 20px;">
          {{ strtoupper(substr($contributor->full_name, 0, 1)) }}
       </div>
       <div style="font-size:20px; font-weight:600; color:var(--ink);">{{ $contributor->full_name }}</div>
       <div style="font-size:14px; color:var(--ink-faint); margin-top:4px;">{{ $contributor->phone ?? 'No phone set' }}</div>
       <div style="margin-top:24px; padding-top:24px; border-top:1px solid var(--border);">
          <div style="font-size:11px; color:var(--ink-faint); text-transform:uppercase; letter-spacing:1px; margin-bottom:12px;">Summary</div>
          <div style="display:flex; justify-content:space-between; margin-bottom:12px;">
             <span style="font-size:13px; color:var(--ink-muted);">Total Contributions</span>
             <span style="font-size:13px; font-weight:700; color:var(--rose);">{{ $contributor->contributions->count() }}</span>
          </div>
       </div>
    </div>
  </div>

  <div class="table-card">
    <div class="table-header">
      <div class="table-title">Contribution History</div>
    </div>
    <table>
      <thead>
        <tr>
          <th>Event</th>
          <th>Type</th>
          <th>Amount</th>
          <th>Date</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($contributions as $c)
        <tr>
          <td style="font-weight:500;">{{ $c->event->couple_name }}</td>
          <td><span class="badge badge-{{ $c->type }}">{{ ucfirst($c->type) }}</span></td>
          <td><span class="amount-cell">{{ number_format($c->amount) }}</span></td>
          <td style="font-size:12px; color:var(--ink-faint);">{{ $c->created_at->format('M d, Y') }}</td>
          <td><span class="badge badge-{{ $c->status }}">{{ ucfirst($c->status) }}</span></td>
          <td>
            <a href="{{ route('contributions.show', $c) }}" class="btn btn-outline btn-sm">View</a>
          </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center; padding:40px; color:var(--ink-faint);">No contribution history found.</td></tr>
        @endforelse
      </tbody>
    </table>
    @if($contributions->hasPages())
    <div class="pagination-wrap">{{ $contributions->links() }}</div>
    @endif
  </div>

</div>
@endsection
