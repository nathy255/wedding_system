@extends('layouts.app')
@section('title','Gift Registry')
@section('heading','Gift Registry')
@section('subheading','All physical gifts for ' . ($event?->couple_name ?? 'current event'))

@section('topbar_actions')
  <a href="{{ route('gifts.create') }}" class="btn btn-primary">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Add Gift
  </a>
@endsection

@section('content')
<div class="table-card">
  <div class="table-header">
    <div>
      <div class="table-title">All Gifts</div>
      <div style="font-size:12px;color:var(--ink-faint);margin-top:2px;">{{ $gifts->total() }} total gifts</div>
    </div>
  </div>
  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Item</th>
        <th>Category</th>
        <th>Donor</th>
        <th>Est. Value (TZS)</th>
        <th>Date</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($gifts as $gift)
      <tr>
        <td style="color:var(--ink-faint);font-size:12px;">{{ $gifts->firstItem() + $loop->index }}</td>
        <td>
          <div style="font-weight:500;color:var(--ink);">{{ $gift->item_name }}</div>
          <div style="font-size:11.5px;color:var(--ink-faint);">{{ ucwords(str_replace('_',' ',$gift->category)) }}</div>
        </td>
        <td style="font-size:12.5px;">{{ ucwords(str_replace('_',' ',$gift->category)) }}</td>
        <td>
          <div class="donor-cell">
            <div class="d-avatar" style="background:var(--gold);">{{ strtoupper(substr($gift->donor_name ?? 'U', 0, 2)) }}</div>
            <div>
              <div class="d-name">{{ $gift->donor_name }}</div>
              <div class="d-phone">{{ $gift->donor_phone }}</div>
            </div>
          </div>
        </td>
        <td><span class="amount-cell">{{ $gift->estimated_value > 0 ? number_format($gift->estimated_value) : '—' }}</span></td>
        <td style="font-size:12px;color:var(--ink-faint);">{{ $gift->created_at->format('M d, Y') }}</td>
        <td><span class="badge badge-{{ $gift->status }}">{{ ucfirst($gift->status) }}</span></td>
        <td>
          <div class="action-btns">
            @if($gift->status === 'pledged')
            <form method="POST" action="{{ route('gifts.receive',$gift) }}" style="display:inline;">@csrf @method('PATCH')
              <button type="submit" class="btn btn-green btn-sm" style="font-size:11px;padding:5px 9px;">✓ Received</button>
            </form>
            @endif
            <a href="{{ route('gifts.edit',$gift) }}" class="btn btn-outline btn-sm" style="font-size:11px;padding:5px 9px;">Edit</a>
            <form method="POST" action="{{ route('gifts.destroy',$gift) }}" style="display:inline;">@csrf @method('DELETE')
              <button type="submit" class="btn btn-outline btn-sm" style="font-size:11px;padding:5px 9px;color:#C62828;border-color:#C62828;" onclick="return confirm('Delete this gift?')">Delete</button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="8" style="text-align:center;padding:40px;color:var(--ink-faint);">
        No gifts registered. <a href="{{ route('gifts.create') }}" style="color:var(--rose);font-weight:500;">Register first gift →</a>
      </td></tr>
      @endforelse
    </tbody>
  </table>
  @if($gifts->hasPages())
  <div class="pagination-wrap">{{ $gifts->links() }}</div>
  @endif
</div>
@endsection
