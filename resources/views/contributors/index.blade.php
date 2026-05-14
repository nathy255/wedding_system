@extends('layouts.app')
@section('title', 'Contributors')
@section('heading', 'Contributors')
@section('subheading', 'Manage all people contributing to wedding events')

@section('content')
<div class="table-card">
  <div class="table-header">
    <div class="table-title">Registered Contributors</div>
  </div>
  <table>
    <thead>
      <tr>
        <th>Name</th>
        <th>Phone</th>
        <th>Total Contributions</th>
        <th>Registered Date</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($contributors as $c)
      <tr>
        <td>
          <div class="donor-cell">
            <div class="d-avatar" style="background:var(--rose);">{{ strtoupper(substr($c->full_name, 0, 1)) }}</div>
            <div class="d-name">{{ $c->full_name }}</div>
          </div>
        </td>
        <td>{{ $c->phone ?? '—' }}</td>
        <td>{{ $c->contributions_count }} entries</td>
        <td>{{ $c->created_at->format('M d, Y') }}</td>
        <td>
          <div class="action-btns">
            <a href="{{ route('contributors.show', $c) }}" class="btn btn-outline btn-sm">View History</a>
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="5" style="text-align:center; padding:40px; color:var(--ink-faint);">No contributors found.</td></tr>
      @endforelse
    </tbody>
  </table>
  @if($contributors->hasPages())
  <div class="pagination-wrap">{{ $contributors->links() }}</div>
  @endif
</div>
@endsection
