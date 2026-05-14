<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8"/>
<style>
  body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1C1210; margin: 0; padding: 0; }
  .header { background: #8B2A4A; color: #fff; padding: 24px 32px; }
  .header h1 { font-size: 22px; margin: 0 0 4px; }
  .header p  { font-size: 11px; margin: 0; opacity: 0.75; letter-spacing: 1px; text-transform: uppercase; }
  .body  { padding: 28px 32px; }
  .event-box { background: #FBF5E6; border: 1px solid #D4B060; border-radius: 8px; padding: 14px 18px; margin-bottom: 24px; }
  .event-box h2 { font-size: 16px; margin: 0 0 4px; color: #8B2A4A; }
  .event-box p  { font-size: 11px; color: #5C4A46; margin: 0; }
  table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
  thead th { background: #FAF7F2; font-size: 10px; font-weight: 600; letter-spacing: 0.8px; text-transform: uppercase; color: #9C8580; padding: 8px 12px; text-align: left; border-bottom: 1px solid #EDE0D8; }
  tbody td { padding: 10px 12px; border-bottom: 1px solid #EDE0D8; font-size: 11.5px; }
  .badge { padding: 2px 8px; border-radius: 99px; font-size: 10px; font-weight: 600; }
  .confirmed { background: #E6F4EC; color: #2A6B4A; }
  .pending   { background: #FDF3E3; color: #8B5E1A; }
  .rejected  { background: #FEE9E9; color: #9B2B2B; }
  .totals { background: #FAF7F2; border-radius: 8px; padding: 16px 18px; display: table; width: 100%; margin-bottom: 20px; }
  .total-row { display: table-row; }
  .total-label { display: table-cell; font-size: 12px; color: #5C4A46; padding: 4px 0; }
  .total-value { display: table-cell; text-align: right; font-weight: 600; font-size: 13px; color: #1C1210; padding: 4px 0; }
  .total-grand { background: #8B2A4A; color: #fff; padding: 12px 18px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; }
  .footer { border-top: 1px solid #EDE0D8; padding: 16px 32px; font-size: 10px; color: #9C8580; text-align: center; }
</style>
</head>
<body>

<div class="header">
  <h1>Wedding Innovation System</h1>
  <p>Contributions Report — {{ now()->format('F j, Y') }}</p>
</div>

<div class="body">

  @if($event)
  <div class="event-box">
    <h2>{{ $event->couple_name }}</h2>
    <p>{{ $event->venue }} · {{ $event->wedding_date->format('F j, Y') }} · Target: TZS {{ number_format($event->target_budget) }}</p>
  </div>
  @endif

  {{-- Summary Totals --}}
  <table style="margin-bottom:8px;">
    <tr>
      <td style="padding:6px 0;font-size:12px;color:#5C4A46;">Total Confirmed</td>
      <td style="padding:6px 0;font-size:13px;font-weight:600;color:#2A6B4A;text-align:right;">TZS {{ number_format($contributions->where('status','confirmed')->sum('amount')) }}</td>
    </tr>
    <tr>
      <td style="padding:6px 0;font-size:12px;color:#5C4A46;">Total Pending</td>
      <td style="padding:6px 0;font-size:13px;font-weight:600;color:#8B5E1A;text-align:right;">TZS {{ number_format($contributions->where('status','pending')->sum('amount')) }}</td>
    </tr>
    <tr>
      <td style="padding:6px 0;font-size:12px;color:#5C4A46;font-weight:600;border-top:1px solid #EDE0D8;">GRAND TOTAL</td>
      <td style="padding:6px 0;font-size:15px;font-weight:700;color:#8B2A4A;text-align:right;border-top:1px solid #EDE0D8;">TZS {{ number_format($contributions->sum('amount')) }}</td>
    </tr>
  </table>

  <h3 style="font-size:13px;font-weight:600;margin:20px 0 10px;">All Contributions ({{ $contributions->count() }} entries)</h3>

  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Contributor</th>
        <th>Phone</th>
        <th>Method</th>
        <th>Reference</th>
        <th>Amount (TZS)</th>
        <th>Date</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach($contributions as $i => $c)
      <tr>
        <td>{{ $i + 1 }}</td>
        <td>{{ $c->contributor_name ?? '—' }}</td>
        <td>{{ $c->contributor_phone }}</td>
        <td>{{ ucwords(str_replace('_',' ',$c->payment_method ?? '—')) }}</td>
        <td style="font-family:monospace;font-size:10px;">{{ $c->payment_reference ?? '—' }}</td>
        <td style="font-weight:600;">{{ $c->amount > 0 ? number_format($c->amount) : '—' }}</td>
        <td>{{ $c->created_at->format('M d, Y') }}</td>
        <td><span class="badge {{ $c->status }}">{{ ucfirst($c->status) }}</span></td>
      </tr>
      @endforeach
    </tbody>
  </table>

  @if($gifts->count())
  <h3 style="font-size:13px;font-weight:600;margin:20px 0 10px;">Gift Registry ({{ $gifts->count() }} items)</h3>
  <table>
    <thead>
      <tr><th>#</th><th>Item</th><th>Donor</th><th>Category</th><th>Est. Value (TZS)</th><th>Status</th></tr>
    </thead>
    <tbody>
      @foreach($gifts as $i => $g)
      <tr>
        <td>{{ $i+1 }}</td>
        <td>{{ $g->item_name }}</td>
        <td>{{ $g->donor_name }}</td>
        <td>{{ ucwords(str_replace('_',' ',$g->category)) }}</td>
        <td>{{ $g->estimated_value > 0 ? number_format($g->estimated_value) : '—' }}</td>
        <td><span class="badge {{ $g->status }}">{{ ucfirst($g->status) }}</span></td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @endif

</div>

<div class="footer">
  Generated by Wedding Innovation System · {{ now()->format('F j, Y H:i') }} ·
  Arusha Technical College · JANABOY Project · NTA Level 6
</div>

</body>
</html>
