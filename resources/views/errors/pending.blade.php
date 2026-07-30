@extends('layouts.app')
@section('title', 'Coming Soon')

@section('extra_css')
<style>
.pending-container { display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 60vh; text-align: center; }
.pc-icon { width: 120px; height: 120px; border-radius: 50%; background: rgba(139, 92, 246, 0.1); color: var(--brand-purple); display: flex; align-items: center; justify-content: center; font-size: 48px; margin-bottom: 32px; box-shadow: 0 0 64px rgba(139, 92, 246, 0.2); }
.pc-title { font-size: 32px; font-weight: 800; color: #fff; letter-spacing: -1px; margin-bottom: 16px; }
.pc-sub { font-size: 16px; color: var(--text-muted); max-width: 500px; margin-bottom: 32px; line-height: 1.6; }

.btn-primary { background: linear-gradient(90deg, #A855F7, #D946EF); color: #fff; padding: 12px 32px; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 14px rgba(139, 92, 246, 0.25); transition: transform 0.2s; }
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(139, 92, 246, 0.35); }

/* ─── Mobile Responsive ─── */
@media (max-width: 768px) {
  .pc-icon { width: 90px; height: 90px; font-size: 36px; margin-bottom: 24px; }
  .pc-title { font-size: 24px; }
  .pc-sub { font-size: 14px; padding: 0 16px; margin-bottom: 24px; }
}
</style>
@endsection

@section('content')

<div class="pending-container">
  <div class="pc-icon">
    <i class="fa-solid fa-rocket"></i>
  </div>
  <h1 class="pc-title">Feature Coming Soon</h1>
  <p class="pc-sub">We are working hard behind the scenes to bring this feature to the EVENTA ecosystem. Our engineers are polishing the details to ensure a world-class experience.</p>
  <a href="{{ route('dashboard') }}" class="btn-primary">Return to Dashboard</a>
</div>

@endsection
