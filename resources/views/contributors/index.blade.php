@extends('layouts.app')
@section('title', 'Guests & Contributors')

@section('extra_css')
<style>
.page-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px; }
.ph-title { font-size: 28px; font-weight: 700; color: #fff; letter-spacing: -0.5px; margin-bottom: 6px; }
.ph-sub { color: var(--text-muted); font-size: 14px; }

.btn-primary { background: linear-gradient(90deg, #A855F7, #D946EF); color: #fff; padding: 10px 20px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px; border: none; cursor: pointer; box-shadow: 0 4px 14px rgba(139, 92, 246, 0.25); transition: transform 0.2s; width: fit-content; }
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(139, 92, 246, 0.35); }

.data-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 16px; padding: 20px; overflow-x: auto; }

@media(max-width: 768px) {
  .page-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 16px;
    margin-bottom: 32px;
  }
  .page-header .btn-primary {
    align-self: flex-start;
  }
}

.data-table { width: 100%; border-collapse: collapse; }
.data-table th { text-align: left; font-size: 11px; font-weight: 500; color: var(--text-muted); padding-bottom: 16px; border-bottom: 1px solid var(--border); text-transform: uppercase; letter-spacing: 0.5px; }
.data-table td { padding: 16px 0; border-bottom: 1px solid rgba(255,255,255,0.03); font-size: 13px; color: var(--text-main); }
.data-table tr:last-child td { border-bottom: none; }

.user-cell { display: flex; align-items: center; gap: 12px; }
.uc-avatar { width: 36px; height: 36px; border-radius: 50%; }
.uc-name { font-weight: 600; color: #fff; }
.uc-phone { font-size: 12px; color: var(--text-muted); }

.action-btns { display: flex; gap: 8px; }
.btn-icon { width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,0.03); border: 1px solid var(--border); color: var(--text-muted); display: flex; align-items: center; justify-content: center; transition: all 0.2s; text-decoration: none; }
.btn-icon:hover { background: var(--bg-card-hover); color: #fff; }

.pagination-wrap { margin-top: 24px; display: flex; justify-content: center; }
</style>
@endsection

@section('content')

<div class="page-header">
  <div>
    <h1 class="ph-title">Guests & Contributors</h1>
    <p class="ph-sub">All individuals who have contributed or been invited to your events.</p>
  </div>
  <a href="{{ route('contributors.create') }}" class="btn-primary">
    <i class="fa-solid fa-user-plus"></i> Add Contributor
  </a>
</div>

<div class="data-card">
  <table class="data-table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Contributions</th>
        <th style="text-align:right;">Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($contributors as $c)
      <tr>
        <td>
          <div class="user-cell">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($c->full_name) }}&background=8B5CF6&color=fff" class="uc-avatar">
            <div>
              <div class="uc-name">{{ $c->full_name }}</div>
              <div class="uc-phone">{{ $c->phone ?? 'No phone' }}</div>
            </div>
          </div>
        </td>
        <td>{{ $c->email ?? '—' }}</td>
        <td>{{ $c->contributions_count ?? 0 }} records</td>
        <td>
          <div class="action-btns" style="justify-content:flex-end;">
            <a href="{{ route('contributors.show', $c) }}" class="btn-icon" title="View"><i class="fa-solid fa-eye"></i></a>
            <a href="{{ route('contributors.edit', $c) }}" class="btn-icon" title="Edit"><i class="fa-solid fa-pen"></i></a>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="4" style="text-align:center; padding: 60px 20px;">
          <div style="width:64px; height:64px; border-radius:50%; background:rgba(255,255,255,0.02); display:flex; align-items:center; justify-content:center; margin: 0 auto 16px;">
            <i class="fa-solid fa-user-group" style="font-size:24px; color:var(--text-faint);"></i>
          </div>
          <div style="font-size:15px; font-weight:500; color:#fff; margin-bottom:8px;">No contributors yet</div>
          <div style="font-size:13px; color:var(--text-muted); margin-bottom:24px;">Add guests and contributors to start tracking RSVPs and payments.</div>
          <a href="{{ route('contributors.create') }}" class="btn-primary" style="display:inline-flex;">Add First Contributor</a>
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>

  @if($contributors->hasPages())
  <div class="pagination-wrap">{{ $contributors->links() }}</div>
  @endif
</div>

@endsection
