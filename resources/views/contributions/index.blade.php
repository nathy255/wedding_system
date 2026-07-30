@extends('layouts.app')
@section('title', 'Financials & Contributions')

@section('extra_css')
<style>
.page-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px; }
.ph-title { font-size: 28px; font-weight: 700; color: #fff; letter-spacing: -0.5px; margin-bottom: 6px; }
.ph-sub { color: var(--text-muted); font-size: 14px; }

.btn-primary { background: linear-gradient(90deg, #10B981, #059669); color: #fff; padding: 10px 20px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px; border: none; cursor: pointer; box-shadow: 0 4px 14px rgba(16, 185, 129, 0.25); transition: transform 0.2s; width: fit-content; }
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(16, 185, 129, 0.35); }

.stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 24px; }
.stat-card { background: linear-gradient(135deg, rgba(255,255,255,0.03), rgba(255,255,255,0.01)); border: 1px solid var(--border); border-radius: 16px; padding: 24px; }
.sc-label { font-size: 12px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; font-weight: 500; margin-bottom: 8px; }
.sc-value { font-size: 32px; font-weight: 800; color: #fff; }

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
  .stats-grid {
    grid-template-columns: 1fr;
    gap: 12px;
  }
}

.data-table { width: 100%; border-collapse: collapse; }
.data-table th { text-align: left; font-size: 11px; font-weight: 500; color: var(--text-muted); padding-bottom: 16px; border-bottom: 1px solid var(--border); text-transform: uppercase; letter-spacing: 0.5px; }
.data-table td { padding: 16px 0; border-bottom: 1px solid rgba(255,255,255,0.03); font-size: 13px; color: var(--text-main); }
.data-table tr:last-child td { border-bottom: none; }

.status-pill { display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 99px; font-size: 11px; font-weight: 500; }
.status-pill::before { content: ''; width: 6px; height: 6px; border-radius: 50%; }
.pill-confirmed { background: rgba(16, 185, 129, 0.15); color: var(--status-green); border: 1px solid rgba(16, 185, 129, 0.2); }
.pill-confirmed::before { background: var(--status-green); }
.pill-pending { background: rgba(245, 158, 11, 0.15); color: var(--status-orange); border: 1px solid rgba(245, 158, 11, 0.2); }
.pill-pending::before { background: var(--status-orange); }

.action-btns { display: flex; gap: 8px; }
.btn-icon { width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,0.03); border: 1px solid var(--border); color: var(--text-muted); display: flex; align-items: center; justify-content: center; transition: all 0.2s; text-decoration: none;}
.btn-icon:hover { background: var(--bg-card-hover); color: #fff; }

.pagination-wrap { margin-top: 24px; display: flex; justify-content: center; }
</style>
@endsection

@section('content')

<div class="page-header">
  <div>
    <h1 class="ph-title">Financials & Escrow</h1>
    <p class="ph-sub">Track all mobile money and card payments across your events.</p>
  </div>
  <a href="{{ route('contributions.create') }}" class="btn-primary">
    <i class="fa-solid fa-plus"></i> Record Payment
  </a>
</div>

<div class="stats-grid">
  <div class="stat-card">
    <div class="sc-label">Total Volume</div>
    <div class="sc-value" style="background: linear-gradient(135deg,#10B981,#059669); -webkit-background-clip:text; -webkit-text-fill-color:transparent;">
      ${{ number_format($contributions->where('status', 'confirmed')->sum('amount')) }}
    </div>
  </div>
  <div class="stat-card">
    <div class="sc-label">Pending Clearing</div>
    <div class="sc-value" style="background: linear-gradient(135deg,#F59E0B,#D97706); -webkit-background-clip:text; -webkit-text-fill-color:transparent;">
      ${{ number_format($contributions->where('status', 'pending')->sum('amount')) }}
    </div>
  </div>
  <div class="stat-card">
    <div class="sc-label">Total Transactions</div>
    <div class="sc-value">{{ $contributions->total() }}</div>
  </div>
</div>

<div class="data-card">
  <table class="data-table">
    <thead>
      <tr>
        <th>Date</th>
        <th>Contributor</th>
        <th>Event</th>
        <th>Payment Method</th>
        <th>Amount</th>
        <th>Status</th>
        <th style="text-align:right;">Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($contributions as $c)
      <tr>
        <td style="color:var(--text-muted);">{{ $c->created_at->format('M d, Y') }}</td>
        <td>
          <div style="font-weight:600; color:#fff;">{{ $c->contributor_name ?? 'Anonymous' }}</div>
          <div style="font-size:11px; color:var(--text-muted);">{{ $c->contributor_phone ?? '' }}</div>
        </td>
        <td>{{ $c->event?->name ?? 'General' }}</td>
        <td>
          @php $m = strtolower($c->payment_method ?? ''); @endphp
          @if($m == 'mpesa') <span style="color:#10B981;"><i class="fa-solid fa-mobile-screen"></i> M-Pesa</span>
          @elseif($m == 'cash') <span style="color:#F59E0B;"><i class="fa-solid fa-money-bill"></i> Cash</span>
          @elseif($m == 'bank_transfer') <span style="color:#8B5CF6;"><i class="fa-solid fa-building-columns"></i> Bank</span>
          @else <span style="color:var(--text-muted);"><i class="fa-solid fa-credit-card"></i> {{ ucfirst($m ?: 'Other') }}</span>
          @endif
        </td>
        <td style="font-weight:600; color:#fff;">${{ number_format($c->amount) }}</td>
        <td>
          <span class="status-pill {{ $c->status == 'confirmed' ? 'pill-confirmed' : 'pill-pending' }}">
            {{ ucfirst($c->status) }}
          </span>
        </td>
        <td>
          <div class="action-btns" style="justify-content:flex-end;">
            <a href="{{ route('contributions.show', $c) }}" class="btn-icon" title="View"><i class="fa-solid fa-receipt"></i></a>
            <a href="{{ route('contributions.edit', $c) }}" class="btn-icon" title="Edit"><i class="fa-solid fa-pen"></i></a>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="7" style="text-align:center; padding: 60px 20px;">
          <div style="width:64px; height:64px; border-radius:50%; background:rgba(255,255,255,0.02); display:flex; align-items:center; justify-content:center; margin: 0 auto 16px;">
            <i class="fa-solid fa-money-bill-transfer" style="font-size:24px; color:var(--text-faint);"></i>
          </div>
          <div style="font-size:15px; font-weight:500; color:#fff; margin-bottom:8px;">No transactions found</div>
          <div style="font-size:13px; color:var(--text-muted); margin-bottom:24px;">Start accepting payments to see them here.</div>
          <a href="{{ route('contributions.create') }}" class="btn-primary" style="display:inline-flex;">Record Payment</a>
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
  
  @if($contributions->hasPages())
  <div class="pagination-wrap">{{ $contributions->links() }}</div>
  @endif
</div>

@endsection
