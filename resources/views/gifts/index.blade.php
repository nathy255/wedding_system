@extends('layouts.app')
@section('title', 'Gifts Registry')

@section('extra_css')
<style>
.page-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px; }
.ph-title { font-size: 28px; font-weight: 700; color: #fff; letter-spacing: -0.5px; margin-bottom: 6px; }
.ph-sub { color: var(--text-muted); font-size: 14px; }

.btn-primary { background: linear-gradient(90deg, #F43F5E, #E11D48); color: #fff; padding: 10px 20px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px; border: none; cursor: pointer; box-shadow: 0 4px 14px rgba(244, 63, 94, 0.25); transition: transform 0.2s; width: fit-content; }
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(244, 63, 94, 0.35); }

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

.status-pill { display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 99px; font-size: 11px; font-weight: 500; }
.status-pill::before { content: ''; width: 6px; height: 6px; border-radius: 50%; }
.pill-received { background: rgba(16, 185, 129, 0.15); color: var(--status-green); border: 1px solid rgba(16, 185, 129, 0.2); }
.pill-received::before { background: var(--status-green); }
.pill-pledged { background: rgba(139, 92, 246, 0.15); color: var(--brand-purple); border: 1px solid rgba(139, 92, 246, 0.2); }
.pill-pledged::before { background: var(--brand-purple); }

.action-btns { display: flex; gap: 8px; }
.btn-icon { width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,0.03); border: 1px solid var(--border); color: var(--text-muted); display: flex; align-items: center; justify-content: center; transition: all 0.2s; text-decoration: none;}
.btn-icon:hover { background: var(--bg-card-hover); color: #fff; }

.pagination-wrap { margin-top: 24px; display: flex; justify-content: center; }
</style>
@endsection

@section('content')

<div class="page-header">
  <div>
    <h1 class="ph-title">Gifts Registry</h1>
    <p class="ph-sub">Manage physical gifts and pledges for your events.</p>
  </div>
  <a href="{{ route('gifts.create') }}" class="btn-primary">
    <i class="fa-solid fa-gift"></i> Record Gift
  </a>
</div>

<div class="data-card">
  <table class="data-table">
    <thead>
      <tr>
        <th>Date</th>
        <th>Gifter / Donor</th>
        <th>Event</th>
        <th>Item Name</th>
        <th>Category</th>
        <th>Estimated Value</th>
        <th>Status</th>
        <th style="text-align:right;">Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($gifts as $g)
      <tr>
        <td style="color:var(--text-muted);">{{ $g->created_at->format('M d, Y') }}</td>
        <td>
          <div style="font-weight:600; color:#fff;">{{ $g->display_donor }}</div>
          <div style="font-size:11px; color:var(--text-muted);">{{ $g->donor_phone ?? '' }}</div>
        </td>
        <td>{{ $g->event?->name ?? 'General' }}</td>
        <td style="font-weight:500; color:#fff;">{{ $g->item_name }}</td>
        <td>{{ ucfirst(str_replace('_', ' ', $g->category)) }}</td>
        <td style="font-weight:600; color:#fff;">${{ number_format($g->estimated_value, 2) }}</td>
        <td>
          <span class="status-pill {{ $g->status == 'received' ? 'pill-received' : 'pill-pledged' }}">
            {{ ucfirst($g->status) }}
          </span>
        </td>
        <td>
          <div class="action-btns" style="justify-content:flex-end;">
            <a href="{{ route('gifts.show', $g) }}" class="btn-icon" title="View"><i class="fa-solid fa-eye"></i></a>
            <a href="{{ route('gifts.edit', $g) }}" class="btn-icon" title="Edit"><i class="fa-solid fa-pen"></i></a>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="8" style="text-align:center; padding: 60px 20px;">
          <div style="width:64px; height:64px; border-radius:50%; background:rgba(255,255,255,0.02); display:flex; align-items:center; justify-content:center; margin: 0 auto 16px;">
            <i class="fa-solid fa-box-open" style="font-size:24px; color:var(--text-faint);"></i>
          </div>
          <div style="font-size:15px; font-weight:500; color:#fff; margin-bottom:8px;">No gifts recorded</div>
          <div style="font-size:13px; color:var(--text-muted); margin-bottom:24px;">Start tracking physical items and pledges from your guests.</div>
          <a href="{{ route('gifts.create') }}" class="btn-primary" style="display:inline-flex;">Record Gift</a>
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
  
  @if($gifts->hasPages())
  <div class="pagination-wrap">{{ $gifts->links() }}</div>
  @endif
</div>

@endsection
