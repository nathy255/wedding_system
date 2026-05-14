<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - {{ $contribution->contributor_name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --rose: #8B2A4A;
            --gold: #B8932A;
            --ink: #1C1210;
            --border: #EDE0D8;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DM Sans', sans-serif; color: var(--ink); line-height: 1.6; padding: 40px; background: #f9f9f9; }
        .receipt-container { 
            max-width: 600px; 
            margin: 0 auto; 
            background: #fff; 
            padding: 50px; 
            border: 1px solid var(--border); 
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            position: relative;
        }
        .receipt-header { text-align: center; margin-bottom: 40px; border-bottom: 1px solid var(--border); padding-bottom: 30px; }
        .brand { font-family: 'Cormorant Garamond', serif; font-size: 28px; font-weight: 700; color: var(--rose); margin-bottom: 5px; }
        .receipt-title { font-size: 11px; text-transform: uppercase; letter-spacing: 3px; color: var(--gold); font-weight: 700; }
        
        .receipt-info { display: flex; justify-content: space-between; margin-bottom: 40px; font-size: 13px; }
        .info-group label { display: block; color: #9C8580; text-transform: uppercase; font-size: 10px; letter-spacing: 1px; margin-bottom: 4px; }
        .info-group div { font-weight: 600; }

        .details-table { width: 100%; border-collapse: collapse; margin-bottom: 40px; }
        .details-table th { text-align: left; border-bottom: 1px solid var(--border); padding: 10px 0; font-size: 11px; color: #9C8580; text-transform: uppercase; letter-spacing: 1px; }
        .details-table td { padding: 20px 0; border-bottom: 1px solid var(--border); }
        
        .amount-big { font-family: 'Cormorant Garamond', serif; font-size: 36px; font-weight: 700; color: var(--rose); text-align: center; margin: 30px 0; border: 2px solid var(--rose); border-radius: 12px; padding: 20px; }
        
        .thank-you { text-align: center; font-family: 'Cormorant Garamond', serif; font-size: 22px; font-style: italic; color: var(--ink); margin-top: 40px; }
        .event-details { text-align: center; font-size: 13px; color: #9C8580; margin-top: 10px; }
        
        .footer { text-align: center; margin-top: 50px; font-size: 10px; color: #ccc; border-top: 1px dashed var(--border); padding-top: 20px; }
        
        @media print {
            body { background: #fff; padding: 0; }
            .receipt-container { box-shadow: none; border: none; max-width: 100%; }
            .no-print { display: none; }
        }
        
        .print-btn { 
            position: fixed; top: 20px; right: 20px; 
            background: var(--rose); color: #fff; padding: 12px 24px; 
            border-radius: 30px; border: none; font-family: 'DM Sans', sans-serif; 
            font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;
            box-shadow: 0 4px 15px rgba(139, 42, 74, 0.3);
        }
    </style>
</head>
<body>

    <button class="print-btn no-print" onclick="window.print()">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
        Print Receipt
    </button>

    <div class="receipt-container">
        <div class="receipt-header">
            <div class="brand">WeddingIS</div>
            <div class="receipt-title">Official Receipt</div>
        </div>

        <div class="receipt-info">
            <div class="info-group">
                <label>Receipt No.</label>
                <div>WIS-{{ str_pad($contribution->id, 6, '0', STR_PAD_LEFT) }}</div>
            </div>
            <div class="info-group" style="text-align: right;">
                <label>Date</label>
                <div>{{ $contribution->created_at->format('M d, Y') }}</div>
            </div>
        </div>

        <table class="details-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th style="text-align: right;">Type</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div style="font-weight: 700; font-size: 16px;">{{ $contribution->contributor_name }}</div>
                        <div style="font-size: 13px; color: #9C8580;">{{ $contribution->contributor_phone }}</div>
                    </td>
                    <td style="text-align: right; vertical-align: top;">
                        <div style="font-weight: 600;">{{ ucfirst($contribution->type) }}</div>
                        <div style="font-size: 12px; color: #9C8580;">{{ ucwords(str_replace('_',' ',$contribution->payment_method)) }}</div>
                    </td>
                </tr>
            </tbody>
        </table>

        @if($contribution->type === 'cash')
        <div class="amount-big">
            TZS {{ number_format($contribution->amount) }}
        </div>
        @else
        <div style="text-align: center; margin: 30px 0; border: 2px solid var(--gold); border-radius: 12px; padding: 20px;">
            <div style="font-family: 'Cormorant Garamond', serif; font-size: 24px; font-weight: 700; color: var(--gold);">Gift Item Received</div>
            <div style="font-size: 16px; margin-top: 5px;">{{ $contribution->notes }}</div>
        </div>
        @endif

        <div class="thank-you">Thank you for your generous support!</div>
        <div class="event-details">
            In honor of <strong>{{ $contribution->event->couple_name }}</strong><br>
            {{ $contribution->event->wedding_date->format('F d, Y') }} · {{ $contribution->event->venue }}
        </div>

        <div class="footer">
            WeddingIS Innovation System · Generated by {{ $contribution->recordedBy?->full_name }} · {{ now()->format('Y-m-d H:i') }}
        </div>
    </div>

</body>
</html>
