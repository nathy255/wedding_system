@extends('layouts.app')
@section('title', 'Vendor Marketplace')

@section('extra_css')
<style>
.page-header { margin-bottom: 32px; }
.ph-title { font-size: 32px; font-weight: 800; color: #fff; letter-spacing: -0.5px; margin-bottom: 8px; }
.ph-sub { color: var(--text-muted); font-size: 15px; max-width: 600px; }

.search-filter-bar { background: var(--bg-card); border: 1px solid var(--border); border-radius: 16px; padding: 12px 16px; display: flex; gap: 16px; align-items: center; margin-bottom: 32px; }
.search-input-wrap { flex: 1; display: flex; align-items: center; gap: 12px; padding: 0 8px; }
.search-input-wrap input { background: transparent; border: none; color: #fff; width: 100%; outline: none; font-size: 14px; }
.search-input-wrap input::placeholder { color: var(--text-faint); }
.filter-divider { width: 1px; height: 24px; background: var(--border); }
.filter-btn { background: transparent; border: none; color: var(--text-muted); font-size: 13px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: color 0.2s; }
.filter-btn:hover { color: #fff; }

.category-pills { display: flex; gap: 12px; margin-bottom: 32px; overflow-x: auto; padding-bottom: 8px; }
.category-pills::-webkit-scrollbar { display: none; }
.cat-pill { padding: 8px 16px; border-radius: 99px; background: rgba(255,255,255,0.03); border: 1px solid var(--border); color: var(--text-muted); font-size: 13px; font-weight: 500; cursor: pointer; transition: all 0.2s; white-space: nowrap; }
.cat-pill:hover, .cat-pill.active { background: #fff; color: #000; border-color: #fff; }

.vendors-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px; }
.vendor-card { border-radius: 16px; overflow: hidden; text-decoration: none; display: flex; flex-direction: column; transition: transform 0.2s; }
.vendor-card:hover { transform: translateY(-4px); }
.vc-image-wrap { position: relative; padding-top: 100%; border-radius: 16px; overflow: hidden; margin-bottom: 12px; }
.vc-image { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; }
.vc-favorite { position: absolute; top: 12px; right: 12px; width: 32px; height: 32px; border-radius: 50%; background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; color: #fff; transition: all 0.2s; z-index: 10;}
.vc-favorite:hover { transform: scale(1.1); color: var(--brand-coral); }

.vc-info { display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; }
.vc-name { font-size: 15px; font-weight: 600; color: #fff; margin-bottom: 4px; line-height: 1.2; }
.vc-category { font-size: 13px; color: var(--text-muted); margin-bottom: 2px; }
.vc-rating { display: flex; align-items: center; gap: 4px; font-size: 14px; font-weight: 500; color: #fff; }
.vc-price { font-size: 14px; color: var(--text-muted); margin-top: 6px; }
.vc-price span { font-weight: 600; color: #fff; }
@media (max-width: 768px) {
  .search-filter-bar {
    flex-direction: column;
    align-items: stretch;
    gap: 12px;
  }
  .page-header { margin-bottom: 24px; }
  .ph-title { font-size: 24px; }
  .ph-sub { font-size: 13px; }
  .filter-divider {
    display: none;
  }
  .filter-btn {
    justify-content: center;
    padding: 8px 0;
    border-top: 1px solid var(--border);
  }
}
</style>
@endsection

@section('content')

<div class="page-header">
  <h1 class="ph-title">Vendor Marketplace</h1>
  <p class="ph-sub">Discover, negotiate, and book the finest photographers, caterers, and venues directly on-platform with escrow protection.</p>
</div>

<div class="search-filter-bar">
  <div class="search-input-wrap">
    <i class="fa-solid fa-magnifying-glass text-muted"></i>
    <input type="text" placeholder="Search for vendors or services...">
  </div>
  <div class="filter-divider"></div>
  <button class="filter-btn"><i class="fa-solid fa-location-dot"></i> Dar es Salaam</button>
  <div class="filter-divider"></div>
  <button class="filter-btn"><i class="fa-solid fa-sliders"></i> Filters</button>
</div>

<div class="category-pills">
  <div class="cat-pill active">All Categories</div>
  <div class="cat-pill">Photography & Video</div>
  <div class="cat-pill">Venues</div>
  <div class="cat-pill">Catering</div>
  <div class="cat-pill">Decorators</div>
  <div class="cat-pill">Entertainment</div>
  <div class="cat-pill">Planners</div>
  <div class="cat-pill">Attire</div>
</div>

<div class="vendors-grid">
  @forelse($vendors as $vendor)
  <a href="{{ route('vendors.show', $vendor) }}" class="vendor-card">
    <div class="vc-image-wrap">
      <img src="{{ $vendor->cover_image ?? 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?q=80&w=600&auto=format&fit=crop' }}" class="vc-image" alt="{{ $vendor->name }}">
      <div class="vc-favorite" onclick="event.preventDefault(); this.style.color='#F43F5E';"><i class="fa-solid fa-heart"></i></div>
    </div>
    <div class="vc-info">
      <div>
        <div class="vc-name">{{ $vendor->name }}</div>
        <div class="vc-category">{{ $vendor->category }} • {{ $vendor->location ?? 'Global' }}</div>
        <div class="vc-price">From <span>${{ number_format($vendor->starting_price) }}</span></div>
      </div>
      <div class="vc-rating">
        <i class="fa-solid fa-star" style="font-size:10px;"></i> {{ number_format($vendor->rating, 2) }}
      </div>
    </div>
  </a>
  @empty
  <div style="grid-column: 1 / -1; text-align:center; padding: 60px 0;">
    <p style="color:var(--text-muted);">No vendors available at the moment.</p>
  </div>
  @endforelse
</div>

@endsection
