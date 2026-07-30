@extends('layouts.app')
@section('title', 'Payment Receipt')

@section('extra_css')
<style>
.page-header { margin-bottom: 32px; display: flex; align-items: center; justify-content: space-between; }
.ph-left { display: flex; align-items: center; gap: 16px; }
.btn-back { width: 36px; height: 36px; border-radius: 10px; background: rgba(255,255,255,0.03); border: 1px solid var(--border); color: var(--text-muted); display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s; }
.btn-back:hover { background: var(--bg-card-hover); color: #fff; }
.ph-title { font-size: 24px; font-weight: 700; color: #fff; letter-spacing: -0.5px; }

.btn-primary { background: linear-gradient(90deg, #10B981, #059669); color: #fff; padding: 10px 20px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 14px rgba(16, 185, 129, 0.25); transition: transform 0.2s; width: fit-content; }
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(16, 185, 129, 0.35); }

.receipt-wrapper { max-width: 500px; margin: 0 auto; }
.receipt-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 24px; padding: 40px; box-shadow: 0 24px 64px rgba(0,0,0,0.4); text-align: center; position: relative; overflow: hidden; }
.rc-header { margin-bottom: 32px; }
.rc-icon { width: 64px; height: 64px; border-radius: 50%; background: rgba(16, 185, 129, 0.1); color: #10B981; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 16px; }
.rc-title { font-size: 14px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; font-weight: 600; margin-bottom: 8px; }
.rc-amount { font-size: 48px; font-weight: 800; color: #fff; letter-spacing: -1px; }

.rc-divider { height: 1px; background: dashed 1px var(--border); margin: 32px 0; }

.rc-details { text-align: left; display: flex; flex-direction: column; gap: 16px; }
.rc-row { display: flex; justify-content: space-between; align-items: center; }
.rc-label { font-size: 13px; color: var(--text-muted); }
.rc-val { font-size: 14px; font-weight: 600; color: #fff; }

.status-badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 99px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
.badge-confirmed { background: rgba(16, 185, 129, 0.1); color: #10B981; }
.badge-pending { background: rgba(245, 158, 11, 0.1); color: #F59E0B; }

.print-actions { display: flex; gap: 12px; margin-top: 24px; justify-content: center; }
.btn-outline { background: transparent; border: 1px solid var(--border); color: #fff; padding: 10px 20px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; transition: all 0.2s; cursor: pointer; }
.btn-outline:hover { background: rgba(255,255,255,0.05); }

/* Decorative top gradient */
.receipt-card::before {
  content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 6px;
  background: linear-gradient(90deg, #10B981, #059669);
}

/* ─── Mobile Responsive ─── */
@media (max-width: 768px) {
  .page-header { flex-direction: column; align-items: flex-start; gap: 16px; }
  .ph-title { font-size: 20px; }
  .receipt-card { padding: 24px 16px; border-radius: 16px; }
  .rc-amount { font-size: 36px; }
  .rc-icon { width: 52px; height: 52px; font-size: 20px; }
}

@media (max-width: 480px) {
  .ph-title { font-size: 18px; }
  .btn-primary { padding: 10px 16px; font-size: 12px; }
  .receipt-card { padding: 20px 14px; }
  .rc-amount { font-size: 28px; }
  .print-actions { flex-direction: column; }
  .btn-outline { text-align: center; }
}
</style>
@endsection

@section('content')

<div class="page-header">
  <div class="ph-left">
    <a href="{{ route('contributions.index') }}" class="btn-back"><i class="fa-solid fa-arrow-left"></i></a>
    <h1 class="ph-title">Transaction Receipt</h1>
  </div>
  <a href="{{ route('contributions.edit', $contribution) }}" class="btn-primary" style="background: linear-gradient(90deg, #A855F7, #D946EF); box-shadow: 0 4px 14px rgba(139, 92, 246, 0.25);">
    <i class="fa-solid fa-pen"></i> Edit Record
  </a>
</div>

<div class="receipt-wrapper">
  <div class="receipt-card">
    <div class="rc-header">
      <div class="rc-icon">
        <i class="fa-solid fa-check"></i>
      </div>
      <div class="rc-title">Payment Successful</div>
      <div class="rc-amount">${{ number_format($contribution->amount, 2) }}</div>
      
      <div style="margin-top: 16px;">
        <span class="status-badge {{ $contribution->status == 'confirmed' ? 'badge-confirmed' : 'badge-pending' }}">
          {{ $contribution->status }}
        </span>
      </div>
    </div>
    
    <div class="rc-divider"></div>
    
    <div class="rc-details">
      <div class="rc-row">
        <span class="rc-label">Date & Time</span>
        <span class="rc-val">{{ $contribution->created_at->format('M d, Y • h:i A') }}</span>
      </div>
      <div class="rc-row">
        <span class="rc-label">Transaction ID</span>
        <span class="rc-val" style="font-family: monospace; color: var(--brand-magenta);">#TXN-{{ str_pad($contribution->id, 6, '0', STR_PAD_LEFT) }}</span>
      </div>
      <div class="rc-row">
        <span class="rc-label">Paid By</span>
        <span class="rc-val">{{ $contribution->contributor_name ?? 'Anonymous' }}</span>
      </div>
      <div class="rc-row">
        <span class="rc-label">Event / Workspace</span>
        <span class="rc-val">{{ $contribution->event?->name ?? 'General Allocation' }}</span>
      </div>
      <div class="rc-row">
        <span class="rc-label">Payment Method</span>
        <span class="rc-val" style="display:flex; align-items:center; gap:6px;">
          @if(strtolower($contribution->payment_method) == 'mpesa')
            <i class="fa-solid fa-mobile-screen" style="color:#10B981;"></i> M-Pesa
          @else
            <i class="fa-solid fa-credit-card" style="color:#3B82F6;"></i> {{ ucfirst($contribution->payment_method) }}
          @endif
        </span>
      </div>
    </div>
  </div>

  <div class="print-actions">
    <button onclick="window.print()" class="btn-outline">
      <i class="fa-solid fa-print"></i> Print Receipt
    </button>
    <a href="{{ route('contributions.receipt', $contribution) }}" class="btn-primary">
      <i class="fa-solid fa-download"></i> Download PDF
    </a>
  </div>
</div>

@endsection
