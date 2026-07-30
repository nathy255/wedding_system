@extends('layouts.app')
@section('title', 'Gift Details')

@section('extra_css')
<style>
.page-header { margin-bottom: 32px; display: flex; align-items: center; justify-content: space-between; }
.ph-left { display: flex; align-items: center; gap: 16px; }
.btn-back { width: 36px; height: 36px; border-radius: 10px; background: rgba(255,255,255,0.03); border: 1px solid var(--border); color: var(--text-muted); display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s; }
.btn-back:hover { background: var(--bg-card-hover); color: #fff; }
.ph-title { font-size: 24px; font-weight: 700; color: #fff; letter-spacing: -0.5px; }

.btn-primary { background: linear-gradient(90deg, #F43F5E, #E11D48); color: #fff; padding: 10px 20px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 14px rgba(244, 63, 94, 0.25); transition: transform 0.2s; width: fit-content; }
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(244, 63, 94, 0.35); }

.detail-card { max-width: 600px; background: var(--bg-card); border: 1px solid var(--border); border-radius: 24px; padding: 40px; box-shadow: 0 12px 32px rgba(0,0,0,0.2); }
.dc-icon { width: 80px; height: 80px; border-radius: 50%; background: rgba(244, 63, 94, 0.1); color: #F43F5E; display: flex; align-items: center; justify-content: center; font-size: 32px; margin-bottom: 24px; }

.status-badge { display: inline-flex; align-items: center; gap: 6px; padding: 6px 16px; border-radius: 99px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 24px; }
.badge-received { background: rgba(16, 185, 129, 0.1); color: #10B981; border: 1px solid rgba(16, 185, 129, 0.2); }
.badge-pledged { background: rgba(139, 92, 246, 0.1); color: var(--brand-purple); border: 1px solid rgba(139, 92, 246, 0.2); }

.info-group { margin-bottom: 24px; }
.ig-label { font-size: 12px; font-weight: 500; color: var(--text-muted); margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
.ig-val { font-size: 16px; font-weight: 500; color: #fff; line-height: 1.5; }

.divider { height: 1px; background: var(--border); margin: 32px 0; }

/* ─── Mobile Responsive ─── */
@media (max-width: 768px) {
  .page-header { flex-direction: column; align-items: flex-start; gap: 16px; }
  .ph-title { font-size: 20px; }
  .detail-card { padding: 24px; border-radius: 16px; }
  .dc-icon { width: 64px; height: 64px; font-size: 24px; margin-bottom: 20px; }
}

@media (max-width: 480px) {
  .ph-title { font-size: 18px; }
  .btn-primary { padding: 10px 16px; font-size: 12px; }
  .detail-card { padding: 20px 16px; }
  .ig-val { font-size: 14px; }
}
</style>
@endsection

@section('content')

<div class="page-header">
  <div class="ph-left">
    <a href="{{ route('gifts.index') }}" class="btn-back"><i class="fa-solid fa-arrow-left"></i></a>
    <h1 class="ph-title">Gift Overview</h1>
  </div>
  <a href="{{ route('gifts.edit', $gift) }}" class="btn-primary">
    <i class="fa-solid fa-pen"></i> Edit Record
  </a>
</div>

<div class="detail-card">
  <div class="dc-icon"><i class="fa-solid fa-gift"></i></div>
  
  <span class="status-badge {{ $gift->status == 'received' ? 'badge-received' : 'badge-pledged' }}">
    @if($gift->status == 'received')
      <i class="fa-solid fa-check"></i> Received
    @else
      <i class="fa-solid fa-clock"></i> Pledged
    @endif
  </span>

  <div class="info-group">
    <div class="ig-label">Item Name</div>
    <div class="ig-val">{{ $gift->item_name }}</div>
  </div>

  <div class="info-group">
    <div class="ig-label">Category</div>
    <div class="ig-val">{{ ucfirst(str_replace('_', ' ', $gift->category)) }}</div>
  </div>

  <div class="info-group">
    <div class="ig-label">Estimated Value</div>
    <div class="ig-val">${{ number_format($gift->estimated_value, 2) }}</div>
  </div>

  <div class="info-group">
    <div class="ig-label">Description/Notes</div>
    <div class="ig-val">{{ $gift->description ?? 'No description provided.' }}</div>
  </div>

  <div class="divider"></div>

  <div class="info-group">
    <div class="ig-label">Gifter (Donor)</div>
    <div class="ig-val">
      @if($gift->donor_id)
        <a href="{{ route('contributors.show', $gift->donor_id) }}" style="color: var(--brand-purple); text-decoration: none;">
          {{ $gift->display_donor }}
        </a>
      @else
        {{ $gift->display_donor }}
      @endif
      @if($gift->donor_phone)
        <span style="font-size: 13px; color: var(--text-muted); margin-left: 8px;">({{ $gift->donor_phone }})</span>
      @endif
    </div>
  </div>

  <div class="info-group">
    <div class="ig-label">Event Workspace</div>
    <div class="ig-val">{{ $gift->event?->name ?? 'General Allocation' }}</div>
  </div>

  <div class="info-group">
    <div class="ig-label">Date Recorded</div>
    <div class="ig-val">{{ $gift->created_at->format('F d, Y') }}</div>
  </div>
</div>

@endsection
