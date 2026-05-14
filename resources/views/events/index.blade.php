@extends('layouts.app')
@section('title', 'Events')
@section('heading', 'Wedding Events')
@section('subheading', 'Manage all wedding events on the platform')

@section('topbar_actions')
  <a href="{{ route('events.create') }}" class="btn btn-primary">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    New Event
  </a>
@endsection

@section('content')
<div class="table-card">
  <div class="table-header">
    <div class="table-title">All Events</div>
  </div>
  <table>
    <thead>
      <tr>
        <th>Couple</th>
        <th>Wedding Date</th>
        <th>Venue</th>
        <th>Budget</th>
        <th>Contributions</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($events as $e)
      <tr>
        <td>
          <div style="font-weight:600; color:var(--ink);">{{ $e->couple_name }}</div>
          <div style="font-size:11px; color:var(--ink-faint);">Created by {{ $e->creator?->full_name }}</div>
        </td>
        <td>{{ $e->wedding_date->format('M d, Y') }}</td>
        <td>{{ $e->venue ?? '—' }}</td>
        <td><span class="amount-cell">{{ number_format($e->target_budget) }}</span></td>
        <td>
          <div style="font-size:12px;">{{ $e->contributions_count }} entries</div>
          <div style="font-size:11px; color:var(--ink-faint);">{{ $e->gifts_count }} gifts</div>
        </td>
        <td>
          <span class="badge {{ $e->is_active ? 'badge-confirmed' : 'badge-rejected' }}">
            {{ $e->is_active ? 'Active' : 'Inactive' }}
          </span>
        </td>
        <td>
          <div class="action-btns">
            <a href="{{ route('events.show', $e) }}" class="btn btn-outline btn-sm">View</a>
            <a href="{{ route('events.edit', $e) }}" class="btn btn-outline btn-sm">Edit</a>
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="7" style="text-align:center; padding:40px; color:var(--ink-faint);">No events found.</td></tr>
      @endforelse
    </tbody>
  </table>
  @if($events->hasPages())
  <div class="pagination-wrap">{{ $events->links() }}</div>
  @endif
</div>
@endsection
