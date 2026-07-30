@extends('layouts.app')
@section('title', 'Marketplace Leads')

@section('extra_css')
<style>
.lead-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 20px;
    transition: transform 0.2s, box-shadow 0.2s;
    position: relative;
    overflow: hidden;
}
.lead-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    border-color: rgba(168, 85, 247, 0.4);
}
.lc-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 16px;
}
.lc-title {
    font-size: 20px;
    font-weight: 700;
    color: #fff;
    margin-bottom: 6px;
}
.lc-meta {
    font-size: 13px;
    color: var(--text-muted);
    display: flex;
    gap: 16px;
}
.lc-meta i { margin-right: 6px; color: var(--brand-purple); }
.lc-budget {
    background: rgba(16, 185, 129, 0.1);
    color: #10B981;
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: 700;
    font-size: 14px;
}
.lc-desc {
    font-size: 14px;
    color: var(--text-muted);
    line-height: 1.6;
    margin-bottom: 20px;
}
.btn-bid {
    background: linear-gradient(90deg, #A855F7, #D946EF);
    color: #fff;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: box-shadow 0.2s;
}
.btn-bid:hover {
    box-shadow: 0 0 15px rgba(217, 70, 239, 0.5);
}

/* Modal Styles */
.modal-overlay {
    position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0,0,0,0.8); backdrop-filter: blur(5px);
    display: flex; align-items: center; justify-content: center;
    z-index: 1000; opacity: 0; pointer-events: none; transition: opacity 0.3s;
}
.modal-overlay.active { opacity: 1; pointer-events: auto; }
.modal-content {
    background: #141623; border: 1px solid rgba(255,255,255,0.1);
    border-radius: 20px; padding: 32px; width: 100%; max-width: 500px;
    transform: translateY(20px); transition: transform 0.3s;
}
.modal-overlay.active .modal-content { transform: translateY(0); }
.modal-title { font-size: 22px; font-weight: 700; color: #fff; margin-bottom: 8px; }
.modal-desc { font-size: 13px; color: var(--text-muted); margin-bottom: 24px; }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 style="color: #fff; font-weight: 700;">Marketplace Leads</h2>
    <p style="color: var(--text-muted); margin:0;">Find and pitch for upcoming events</p>
</div>

<div class="row">
    @forelse($leads as $lead)
    <div class="col-12">
        <div class="lead-card">
            <div class="lc-header">
                <div>
                    <div class="lc-title">{{ $lead->name }}</div>
                    <div class="lc-meta">
                        <span><i class="fa-solid fa-calendar"></i> {{ \Carbon\Carbon::parse($lead->event_date)->format('M d, Y') }}</span>
                        <span><i class="fa-solid fa-location-dot"></i> {{ $lead->location ?? 'TBA' }}</span>
                        <span><i class="fa-solid fa-users"></i> {{ $lead->guest_count ?? '50+' }} Guests</span>
                    </div>
                </div>
                <div class="lc-budget">Est. Budget: ${{ number_format($lead->target_budget ?? 5000) }}</div>
            </div>
            <div class="lc-desc">
                {{ $lead->description ?? 'We are looking for amazing vendors to help us make this event unforgettable. Looking for photography, catering, and venue options.' }}
            </div>
            <div>
                <button class="btn-bid" onclick="openModal('{{ $lead->name }}')">
                    <i class="fa-solid fa-paper-plane"></i> Submit Proposal
                </button>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center" style="padding: 60px 20px; background: var(--bg-card); border-radius: 16px; border: 1px dashed var(--border);">
        <i class="fa-solid fa-briefcase" style="font-size: 48px; color: var(--text-muted); margin-bottom: 16px; opacity: 0.5;"></i>
        <h4 style="color: #fff; font-weight: 600;">No active leads found</h4>
        <p style="color: var(--text-muted);">Check back later for new events looking for vendors.</p>
    </div>
    @endforelse
</div>

<!-- Proposal Modal -->
<div class="modal-overlay" id="proposalModal">
    <div class="modal-content">
        <div style="display:flex; justify-content:space-between; margin-bottom:20px;">
            <div class="modal-title">Submit Proposal</div>
            <button onclick="closeModal()" style="background:transparent; border:none; color:var(--text-muted); font-size:20px; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-desc">You are bidding on: <strong style="color:#fff;" id="modalEventName">Event Name</strong></div>
        
        <form onsubmit="submitForm(event)">
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); font-size: 13px; display:block; margin-bottom:8px;">Your Bid Amount ($)</label>
                <input type="number" class="form-input" style="width:100%; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); padding: 12px; border-radius: 8px; color:#fff;" placeholder="e.g. 1500" required>
            </div>
            <div class="form-group" style="margin-bottom: 24px;">
                <label style="color: var(--text-muted); font-size: 13px; display:block; margin-bottom:8px;">Cover Letter / Message</label>
                <textarea class="form-input" rows="4" style="width:100%; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); padding: 12px; border-radius: 8px; color:#fff;" placeholder="Describe what you will offer..." required></textarea>
            </div>
            <button type="submit" class="btn-bid" style="width:100%; justify-content:center;">
                Send Proposal
            </button>
        </form>
    </div>
</div>

<script>
function openModal(eventName) {
    document.getElementById('modalEventName').innerText = eventName;
    document.getElementById('proposalModal').classList.add('active');
}
function closeModal() {
    document.getElementById('proposalModal').classList.remove('active');
}
function submitForm(e) {
    e.preventDefault();
    closeModal();
    // In a real app, we'd use fetch() to submit the data to a route
    alert('Proposal submitted successfully! (Mock Action)');
}
</script>
@endsection
