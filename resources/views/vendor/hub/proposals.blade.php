@extends('layouts.app')
@section('title', 'My Proposals')

@section('extra_css')
<style>
.proposals-container {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
}
.ptable {
    width: 100%;
    border-collapse: collapse;
}
.ptable th {
    text-align: left;
    font-size: 11px;
    font-weight: 600;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 16px 24px;
    border-bottom: 1px solid rgba(255,255,255,0.05);
    background: rgba(0,0,0,0.2);
}
.ptable td {
    padding: 20px 24px;
    border-bottom: 1px solid rgba(255,255,255,0.03);
    vertical-align: middle;
}
.ptable tr:last-child td { border-bottom: none; }
.ptable tr:hover td { background: rgba(255,255,255,0.02); }

.event-name { font-size: 15px; font-weight: 700; color: #fff; margin-bottom: 4px; }
.event-meta { font-size: 12px; color: var(--text-muted); }
.bid-amount { font-size: 16px; font-weight: 800; color: #fff; letter-spacing: -0.5px; }

.status-badge {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 6px 12px; border-radius: 99px; font-size: 12px; font-weight: 700;
}
.status-pending { background: rgba(245, 158, 11, 0.15); color: #F59E0B; border: 1px solid rgba(245, 158, 11, 0.3); }
.status-accepted { background: rgba(16, 185, 129, 0.15); color: #10B981; border: 1px solid rgba(16, 185, 129, 0.3); }
.status-rejected { background: rgba(239, 68, 68, 0.15); color: #EF4444; border: 1px solid rgba(239, 68, 68, 0.3); }

</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 style="color: #fff; font-weight: 700;">My Proposals</h2>
    <a href="{{ route('vendor.leads') }}" style="color: var(--brand-purple); font-weight: 600; text-decoration: none;">
        Browse More Leads <i class="fa-solid fa-arrow-right" style="font-size:12px; margin-left:4px;"></i>
    </a>
</div>

<div class="proposals-container">
    <table class="ptable">
        <thead>
            <tr>
                <th>Event Details</th>
                <th>Submitted On</th>
                <th>Bid Amount</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($proposals as $p)
            <tr>
                <td>
                    <div class="event-name">{{ $p->event_name }}</div>
                    <div class="event-meta"><i class="fa-regular fa-calendar" style="margin-right:4px;"></i> Event Date: {{ $p->event_date }}</div>
                </td>
                <td style="color: var(--text-muted); font-size: 13px;">{{ $p->submitted_at }}</td>
                <td class="bid-amount">${{ number_format($p->amount) }}</td>
                <td>
                    @if($p->status === 'Pending')
                        <span class="status-badge status-pending"><i class="fa-solid fa-clock"></i> Pending</span>
                    @elseif($p->status === 'Accepted')
                        <span class="status-badge status-accepted"><i class="fa-solid fa-check"></i> Accepted</span>
                    @elseif($p->status === 'Rejected')
                        <span class="status-badge status-rejected"><i class="fa-solid fa-xmark"></i> Rejected</span>
                    @endif
                </td>
                <td>
                    <button style="background:transparent; border:1px solid rgba(255,255,255,0.2); color:#fff; border-radius:6px; padding:6px 12px; font-size:12px; font-weight:600; cursor:pointer; transition:background 0.2s;">
                        View Details
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center; padding: 40px;">
                    <p style="color:var(--text-muted); margin:0;">You haven't submitted any proposals yet.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
