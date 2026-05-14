@extends('layouts.app')
@section('title','Contributions')
@section('heading','Contributions')
@section('subheading','All cash and gift entries for ' . ($event?->couple_name ?? 'current event'))

@section('topbar_actions')
  <a href="{{ route('contributions.create') }}" class="btn btn-primary">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Add Contribution
  </a>
@endsection

@section('content')

{{-- Filters --}}
<form method="GET" action="{{ route('contributions.index') }}" style="background:#fff;border:1px solid var(--border);border-radius:14px;padding:18px 22px;margin-bottom:22px;display:flex;gap:12px;align-items:flex-end;">
  <div style="flex:1;">
    <label style="font-size:12px;font-weight:500;color:var(--ink-muted);display:block;margin-bottom:5px;">Search</label>
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, phone, or reference..." style="width:100%;padding:9px 12px;border:1.5px solid var(--border);border-radius:8px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;" onfocus="this.style.borderColor='var(--rose)'" onblur="this.style.borderColor='var(--border)'"/>
  </div>
  <div>
    <label style="font-size:12px;font-weight:500;color:var(--ink-muted);display:block;margin-bottom:5px;">Status</label>
    <select name="status" style="padding:9px 28px 9px 12px;border:1.5px solid var(--border);border-radius:8px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;background-color:#fff;appearance:none;background-image:url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239C8580' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E\");background-repeat:no-repeat;background-position:right 10px center;">
      <option value="">All Status</option>
      <option value="pending"   {{ request('status')==='pending'   ? 'selected' : '' }}>Pending</option>
      <option value="confirmed" {{ request('status')==='confirmed' ? 'selected' : '' }}>Confirmed</option>
      <option value="rejected"  {{ request('status')==='rejected'  ? 'selected' : '' }}>Rejected</option>
    </select>
  </div>
  <div>
    <label style="font-size:12px;font-weight:500;color:var(--ink-muted);display:block;margin-bottom:5px;">Type</label>
    <select name="type" style="padding:9px 28px 9px 12px;border:1.5px solid var(--border);border-radius:8px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;background-color:#fff;appearance:none;background-image:url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239C8580' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E\");background-repeat:no-repeat;background-position:right 10px center;">
      <option value="">All Types</option>
      <option value="cash" {{ request('type')==='cash' ? 'selected' : '' }}>Cash</option>
      <option value="gift" {{ request('type')==='gift' ? 'selected' : '' }}>Gift</option>
    </select>
  </div>
  <button type="submit" class="btn btn-primary" style="padding:9px 18px;">Search</button>
  @if(request()->hasAny(['search','status','type']))
  <a href="{{ route('contributions.index') }}" class="btn btn-outline" style="padding:9px 14px;">Clear</a>
  @endif
</form>

{{-- Table --}}
<div class="table-card">
  <div class="table-header">
    <div>
      <div class="table-title">All Contributions</div>
      <div style="font-size:12px;color:var(--ink-faint);margin-top:2px;">{{ $contributions->total() }} total entries</div>
    </div>
    <a href="{{ route('reports.csv') }}" class="btn btn-outline" style="font-size:12px;padding:7px 14px;">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="14" height="14"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
      Export CSV
    </a>
  </div>

  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Contributor</th>
        <th>Type</th>
        <th>Amount (TZS)</th>
        <th>Method</th>
        <th>Reference</th>
        <th>Recorded By</th>
        <th>Date</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($contributions as $c)
      <tr>
        <td style="color:var(--ink-faint);font-size:12px;">{{ $contributions->firstItem() + $loop->index }}</td>
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
        <td><span class="amount-cell">{{ $c->amount > 0 ? number_format($c->amount) : '—' }}</span></td>
        <td style="font-size:12.5px;">{{ ucwords(str_replace('_',' ',$c->payment_method ?? '—')) }}</td>
        <td style="font-size:12px;color:var(--ink-faint);font-family:monospace;">{{ $c->payment_reference ?? '—' }}</td>
        <td style="font-size:12.5px;">{{ $c->recordedBy?->full_name ?? '—' }}</td>
        <td style="font-size:12px;color:var(--ink-faint);">{{ $c->created_at->format('M d, Y') }}</td>
        <td><span class="badge badge-{{ $c->status }}">{{ ucfirst($c->status) }}</span></td>
        <td>
          <div class="action-btns">
            @if($c->status === 'pending')
            <form method="POST" action="{{ route('contributions.confirm',$c) }}" style="display:inline;">@csrf @method('PATCH')
              <button type="submit" class="btn btn-green btn-sm" style="font-size:11px;padding:5px 9px;">✓</button>
            </form>
            <form method="POST" action="{{ route('contributions.reject',$c) }}" style="display:inline;">@csrf @method('PATCH')
              <button type="submit" class="btn btn-outline btn-sm" style="font-size:11px;padding:5px 9px;color:#C62828;border-color:#C62828;" onclick="return confirm('Reject this contribution?')">✕</button>
            </form>
            @endif
            <a href="{{ route('contributions.show',$c) }}" class="btn btn-outline btn-sm" style="font-size:11px;padding:5px 9px;">View</a>
            <a href="{{ route('contributions.edit',$c) }}" class="btn btn-outline btn-sm" style="font-size:11px;padding:5px 9px;">Edit</a>
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="10" style="text-align:center;padding:40px;color:var(--ink-faint);">
        No contributions found. <a href="{{ route('contributions.create') }}" style="color:var(--rose);font-weight:500;">Add the first one →</a>
      </td></tr>
      @endforelse
    </tbody>
  </table>

  @if($contributions->hasPages())
  <div class="pagination-wrap">{{ $contributions->withQueryString()->links() }}</div>
  @endif
</div>

@endsection
