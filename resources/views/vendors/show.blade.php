@extends('layouts.app')
@section('title', $vendor->name)

@section('extra_css')
<style>
.page-header { margin-bottom: 24px; display: flex; justify-content: space-between; align-items: flex-start; }
.ph-left { display: flex; flex-direction: column; gap: 8px; }
.btn-back { width: 36px; height: 36px; border-radius: 10px; background: rgba(255,255,255,0.03); border: 1px solid var(--border); color: var(--text-muted); display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s; margin-bottom: 12px; }
.btn-back:hover { background: var(--bg-card-hover); color: #fff; }
.ph-title { font-size: 32px; font-weight: 800; color: #fff; letter-spacing: -0.5px; }

.vendor-meta { display: flex; align-items: center; gap: 16px; font-size: 14px; font-weight: 500; }
.vm-rating { display: flex; align-items: center; gap: 4px; color: #fff; }
.vm-reviews { color: var(--text-muted); text-decoration: underline; cursor: pointer; }
.vm-location { color: var(--text-muted); display: flex; align-items: center; gap: 4px; }

.hero-gallery { display: grid; grid-template-columns: 2fr 1fr 1fr; grid-template-rows: 200px 200px; gap: 12px; border-radius: 24px; overflow: hidden; margin-bottom: 32px; }
.hg-main { grid-column: 1 / 2; grid-row: 1 / 3; }
.hg-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s; cursor: pointer; }
.hg-img-wrap { overflow: hidden; position: relative; }
.hg-img-wrap:hover .hg-img { transform: scale(1.05); }

.content-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 48px; }

.section-title { font-size: 20px; font-weight: 700; color: #fff; margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid var(--border); }
.description-text { font-size: 15px; line-height: 1.6; color: var(--text-muted); margin-bottom: 32px; }

.feature-list { display: flex; flex-direction: column; gap: 16px; margin-bottom: 32px; }
.feature-item { display: flex; align-items: center; gap: 16px; }
.fi-icon { font-size: 24px; color: var(--text-main); width: 32px; text-align: center; }
.fi-text { font-size: 15px; font-weight: 500; color: #fff; }
.fi-sub { font-size: 13px; color: var(--text-muted); margin-top: 2px; }

/* Booking Card */
.booking-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 24px; padding: 24px; box-shadow: 0 24px 64px rgba(0,0,0,0.4); position: sticky; top: 24px; }
.bc-price { font-size: 24px; font-weight: 700; color: #fff; margin-bottom: 24px; }
.bc-price span { font-size: 15px; font-weight: 500; color: var(--text-muted); }

.date-picker { background: rgba(0,0,0,0.2); border: 1px solid var(--border); border-radius: 12px; padding: 12px; margin-bottom: 16px; cursor: pointer; }
.dp-label { font-size: 10px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); margin-bottom: 4px; }
.dp-val { font-size: 14px; font-weight: 500; color: #fff; }

.btn-reserve { width: 100%; background: linear-gradient(135deg, var(--brand-purple), var(--brand-magenta)); color: #fff; padding: 16px; border-radius: 12px; font-size: 15px; font-weight: 700; border: none; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 8px 24px rgba(139, 92, 246, 0.3); margin-bottom: 16px; }
.btn-reserve:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(139, 92, 246, 0.4); }

.payment-methods { display: flex; justify-content: center; gap: 12px; color: var(--text-muted); font-size: 20px; margin-top: 16px; border-top: 1px solid var(--border); padding-top: 16px; }

@media(max-width: 1024px) {
  .hero-gallery { grid-template-columns: 1fr; grid-template-rows: 300px; }
  .hg-side { display: none; }
  .content-grid { grid-template-columns: 1fr; }
  .booking-card { position: static; }
}
@media(max-width: 768px) {
  .page-header { flex-direction: column; align-items: flex-start; gap: 16px; margin-bottom: 24px; }
  .ph-title { font-size: 24px; }
  .vendor-meta { flex-wrap: wrap; gap: 8px 12px; }
}
</style>
@endsection

@section('content')

<a href="{{ route('vendors.index') }}" class="btn-back"><i class="fa-solid fa-arrow-left"></i></a>

<div class="page-header">
  <div class="ph-left">
    <h1 class="ph-title">{{ $vendor->name }}</h1>
    <div class="vendor-meta">
      <div class="vm-rating"><i class="fa-solid fa-star" style="font-size:12px;"></i> {{ number_format($vendor->rating, 2) }}</div>
      <div class="vm-reviews">{{ $vendor->review_count }} reviews</div>
      <div>•</div>
      <div class="vm-location"><i class="fa-solid fa-location-dot"></i> {{ $vendor->location }}</div>
      <div>•</div>
      <div class="vm-location"><i class="fa-solid fa-tags"></i> {{ $vendor->category }}</div>
    </div>
  </div>
  <div class="flex gap-2">
    <button class="btn-back" style="margin:0;"><i class="fa-solid fa-arrow-up-from-bracket"></i></button>
    <button class="btn-back" style="margin:0;"><i class="fa-regular fa-heart"></i></button>
  </div>
</div>

<div class="hero-gallery">
  <div class="hg-img-wrap hg-main">
    <img src="{{ $vendor->cover_image }}" class="hg-img" alt="Cover">
  </div>
  <div class="hg-img-wrap hg-side">
    <img src="https://images.unsplash.com/photo-1519167758481-83f550bb49b3?q=80&w=800&auto=format&fit=crop" class="hg-img" alt="Gallery 1">
  </div>
  <div class="hg-img-wrap hg-side" style="border-top-right-radius: 24px;">
    <img src="https://images.unsplash.com/photo-1469334031218-e382a71b716b?q=80&w=800&auto=format&fit=crop" class="hg-img" alt="Gallery 2">
  </div>
  <div class="hg-img-wrap hg-side">
    <img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?q=80&w=800&auto=format&fit=crop" class="hg-img" alt="Gallery 3">
  </div>
  <div class="hg-img-wrap hg-side" style="border-bottom-right-radius: 24px;">
    <img src="https://images.unsplash.com/photo-1555244162-803834f70033?q=80&w=800&auto=format&fit=crop" class="hg-img" alt="Gallery 4">
  </div>
</div>

<div class="content-grid">
  <div class="cg-left">
    <div class="section-title">About this vendor</div>
    <div class="description-text">
      {{ $vendor->description ?? 'No description provided by the vendor.' }}
      <br><br>
      Our goal is to provide world-class service to ensure your event is memorable. We offer tailored packages that fit every budget. Whether it is a corporate conference or an intimate wedding, our team brings professionalism and creativity to the table.
    </div>

    <div class="section-title">What they offer</div>
    <div class="feature-list">
      <div class="feature-item">
        <div class="fi-icon"><i class="fa-solid fa-shield-halved"></i></div>
        <div>
          <div class="fi-text">Verified Professional</div>
          <div class="fi-sub">Identity and business licenses verified by EVENTA.</div>
        </div>
      </div>
      <div class="feature-item">
        <div class="fi-icon"><i class="fa-solid fa-calendar-check"></i></div>
        <div>
          <div class="fi-text">Instant Booking</div>
          <div class="fi-sub">Secure your date immediately with a 20% deposit.</div>
        </div>
      </div>
      <div class="feature-item">
        <div class="fi-icon"><i class="fa-solid fa-file-contract"></i></div>
        <div>
          <div class="fi-text">Smart Contracts</div>
          <div class="fi-sub">Digital signing and milestone payments built-in.</div>
        </div>
      </div>
    </div>
  </div>

  <div class="cg-right">
    <div class="booking-card">
      <div class="bc-price">${{ number_format($vendor->starting_price) }} <span>starting price</span></div>
      
      <div class="date-picker">
        <div class="dp-label">Select Date</div>
        <div class="dp-val">Add event date</div>
      </div>

      <div class="date-picker">
        <div class="dp-label">Event Type</div>
        <div class="dp-val">General Allocation</div>
      </div>

      <button class="btn-reserve" onclick="alert('Escrow payment simulation initialized. M-Pesa prompt would appear here.')">Request to Book</button>
      <div style="text-align:center; font-size:12px; color:var(--text-muted);">You won't be charged yet. Funds are held in escrow.</div>

      <div class="payment-methods">
        <i class="fa-brands fa-cc-visa" title="Visa"></i>
        <i class="fa-brands fa-cc-mastercard" title="Mastercard"></i>
        <i class="fa-brands fa-apple" title="Apple Pay"></i>
        <i class="fa-solid fa-mobile-screen" style="color:#10B981;" title="M-Pesa"></i>
      </div>
    </div>
  </div>
</div>

@endsection
