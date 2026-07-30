@extends('layouts.app')
@section('title', 'Booked Events')

@section('extra_css')
<style>
.booking-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 0;
    margin-bottom: 24px;
    display: flex;
    overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
}
.booking-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.4);
    border-color: rgba(255,255,255,0.1);
}
.bc-date-box {
    background: rgba(139, 92, 246, 0.1);
    min-width: 120px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border-right: 1px solid rgba(139, 92, 246, 0.2);
    padding: 24px;
}
.bc-month { font-size: 14px; color: var(--brand-purple); font-weight: 700; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 4px; }
.bc-day { font-size: 36px; color: #fff; font-weight: 800; line-height: 1; margin-bottom: 4px; }
.bc-year { font-size: 13px; color: var(--text-muted); font-weight: 600; }

.bc-content {
    padding: 24px 32px;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.bc-title { font-size: 20px; font-weight: 800; color: #fff; margin-bottom: 8px; letter-spacing: -0.5px; }
.bc-info { display: flex; gap: 24px; margin-bottom: 16px; }
.bc-info-item { display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--text-muted); }
.bc-info-item i { color: var(--brand-purple); }

.bc-actions {
    padding: 24px;
    border-left: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 12px;
    min-width: 200px;
}
.bc-amount { font-size: 24px; font-weight: 800; color: #10B981; margin-bottom: 4px; text-align: center; }
.bc-label { font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; font-weight: 600; text-align: center; margin-bottom: 12px; }

.btn-outline {
    background: transparent;
    border: 1px solid rgba(255,255,255,0.2);
    color: #fff;
    padding: 10px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 13px;
    text-align: center;
    text-decoration: none;
    transition: background 0.2s, border-color 0.2s;
    display: flex; justify-content: center; align-items: center; gap: 8px;
}
.btn-outline:hover { background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.4); }

@media(max-width: 768px) {
    .booking-card { flex-direction: column; }
    .bc-date-box { border-right: none; border-bottom: 1px solid rgba(139, 92, 246, 0.2); padding: 16px; flex-direction: row; gap: 12px; justify-content: flex-start; }
    .bc-month { margin: 0; } .bc-day { font-size: 24px; margin: 0; }
    .bc-actions { border-left: none; border-top: 1px solid var(--border); }
}
</style>
@endsection

@section('content')
<div class="mb-4">
    <h2 style="color: #fff; font-weight: 700;">Booked Events</h2>
    <p style="color: var(--text-muted); margin:0;">Your confirmed upcoming jobs and assignments</p>
</div>

<div>
    @forelse($bookings as $b)
    <div class="booking-card">
        <div class="bc-date-box">
            <div class="bc-month">{{ \Carbon\Carbon::parse($b->event_date)->format('M') }}</div>
            <div class="bc-day">{{ \Carbon\Carbon::parse($b->event_date)->format('d') }}</div>
            <div class="bc-year">{{ \Carbon\Carbon::parse($b->event_date)->format('Y') }}</div>
        </div>
        <div class="bc-content">
            <div class="bc-title">{{ $b->event_name }}</div>
            <div class="bc-info">
                <div class="bc-info-item"><i class="fa-solid fa-location-dot"></i> {{ $b->location }}</div>
                <div class="bc-info-item"><i class="fa-solid fa-user"></i> Client: {{ $b->client_name }}</div>
            </div>
            <div style="display:flex; gap:12px;">
                <span style="background:rgba(59,130,246,0.1); color:#3B82F6; padding:4px 10px; border-radius:6px; font-size:11px; font-weight:700;"><i class="fa-solid fa-circle-check" style="margin-right:4px;"></i> Confirmed</span>
            </div>
        </div>
        <div class="bc-actions">
            <div>
                <div class="bc-amount">${{ number_format($b->amount) }}</div>
                <div class="bc-label">Contract Value</div>
            </div>
            <a href="#" class="btn-outline"><i class="fa-regular fa-message"></i> Contact Client</a>
        </div>
    </div>
    @empty
    <div style="text-align:center; padding: 60px 20px; background: var(--bg-card); border-radius: 16px; border: 1px dashed var(--border);">
        <i class="fa-regular fa-calendar-xmark" style="font-size: 48px; color: var(--text-muted); margin-bottom: 16px; opacity: 0.5;"></i>
        <h4 style="color: #fff; font-weight: 600;">No Booked Events Yet</h4>
        <p style="color: var(--text-muted); margin-bottom: 24px;">Submit proposals on marketplace leads to secure your first booking.</p>
        <a href="{{ route('vendor.leads') }}" style="background: linear-gradient(90deg, #A855F7, #D946EF); color: #fff; padding: 10px 24px; border-radius: 8px; font-weight: 600; text-decoration: none;">Browse Leads</a>
    </div>
    @endforelse
</div>
@endsection
